<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MealAiService
{
    // Ollama API endpoint
    private const OLLAMA_URL = 'http://127.0.0.1:11434/api/generate';
    
    // AI model name
    private const MODEL = 'llama3.2:1b';
    
    // System prompt - teaches AI to extract filters
    private const SYSTEM_PROMPT = <<<'PROMPT'
You are a food filter assistant. Extract filtering criteria from user messages.

OUTPUT RULES:
1. Return ONLY valid JSON - no text before or after
2. Use this exact structure: {"avoid": "string or null", "min_protein": number or null, "max_calories": number or null}
3. Extract allergies/avoidances into "avoid" as comma-separated lowercase words
4. Extract protein needs into "min_protein" as number (assume 25g for "high protein")
5. Extract calorie limits into "max_calories" as number
6. Set null if not mentioned

EXAMPLES:
Input: "I'm allergic to peanuts and shellfish"
Output: {"avoid": "peanuts,shellfish", "min_protein": null, "max_calories": null}

Input: "Show me high protein meals"
Output: {"avoid": null, "min_protein": 25, "max_calories": null}

Input: "Low calorie under 500 calories no dairy"
Output: {"avoid": "dairy", "min_protein": null, "max_calories": 500}

Input: "High protein no gluten"
Output: {"avoid": "gluten", "min_protein": 25, "max_calories": null}

Input: "What's available?"
Output: {"avoid": null, "min_protein": null, "max_calories": null}

Now extract from this message:
PROMPT;

    /**
     * Extract meal filters from natural language using Ollama
     */
    public function extractFilters(string $userMessage): array
    {
        try {
            // Build prompt
            $fullPrompt = self::SYSTEM_PROMPT . "\n" . $userMessage;
            
            // Call Ollama API
            $response = Http::timeout(15)->post(self::OLLAMA_URL, [
                'model' => self::MODEL,
                'prompt' => $fullPrompt,
                'stream' => false,
                'options' => [
                    'temperature' => 0.1,  // Low = consistent output
                    'num_predict' => 100,  // Limit response length
                ]
            ]);
            
            if (!$response->successful()) {
                Log::error('Ollama API failed', ['status' => $response->status()]);
                return $this->getEmptyFilters();
            }
            
            // Parse Ollama response
            $data = $response->json();
            $aiResponse = $data['response'] ?? '';
            
            // Clean response (remove markdown if present)
            $cleanedResponse = $this->cleanJsonResponse($aiResponse);
            
            // Decode JSON
            $filters = json_decode($cleanedResponse, true);
            
            // Validate structure
            if (!$this->isValidFilterStructure($filters)) {
                Log::warning('Invalid AI filter structure', ['response' => $cleanedResponse]);
                return $this->getEmptyFilters();
            }
            
            return $filters;
            
        } catch (\Exception $e) {
            Log::error('AI filter extraction failed', ['error' => $e->getMessage()]);
            return $this->getEmptyFilters();
        }
    }
    
    /**
     * Clean JSON response from AI (remove markdown, whitespace)
     */
    private function cleanJsonResponse(string $response): string
    {
        return trim(str_replace(['```json', '```'], '', $response));
    }
    
    /**
     * Validate filter structure
     */
    private function isValidFilterStructure(?array $filters): bool
    {
        if (!is_array($filters)) {
            return false;
        }
        
        // Check required keys exist
        if (!array_key_exists('avoid', $filters) ||
            !array_key_exists('min_protein', $filters) ||
            !array_key_exists('max_calories', $filters)) {
            return false;
        }
        
        // Validate types
        if ($filters['avoid'] !== null && !is_string($filters['avoid'])) {
            return false;
        }
        
        if ($filters['min_protein'] !== null && !is_numeric($filters['min_protein'])) {
            return false;
        }
        
        if ($filters['max_calories'] !== null && !is_numeric($filters['max_calories'])) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Return empty filters (fallback)
     */
    private function getEmptyFilters(): array
    {
        return [
            'avoid' => null,
            'min_protein' => null,
            'max_calories' => null,
        ];
    }
}