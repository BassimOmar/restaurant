<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Services\MealAiService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MealChatController extends Controller
{
    private MealAiService $aiService;
    
    public function __construct(MealAiService $aiService)
    {
        $this->aiService = $aiService;
    }
    
    /**
     * Process chat message and return meals
     * POST /api/chat
     * Body: {"message": "I want high protein no nuts"}
     */
    public function chat(Request $request): JsonResponse
    {
        // Validate input
        $validated = $request->validate([
            'message' => 'required|string|max:500',
        ]);
        
        $userMessage = $validated['message'];
        
        try {
            // Step 1: Extract filters using AI
            $filters = $this->aiService->extractFilters($userMessage);
            
            // Step 2: Query database with filters
            $meals = $this->queryMeals($filters);
            
            // Step 3: Generate response message
            $responseMessage = $this->generateResponseMessage($filters, $meals);
            
            return response()->json([
                'success' => true,
                'message' => $responseMessage,
                'meals' => $meals->map(function ($meal) {
                    return [
                        'id' => $meal->id,
                        'name' => $meal->name,
                        'description' => $meal->description,
                        'price' => (float) $meal->price,
                        'protein' => $meal->protein,
                        'calories' => $meal->calories,
                        'image_url' => $meal->image_url,
                        'category' => $meal->category->name ?? 'Other',
                    ];
                }),
                'filters' => $filters,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, something went wrong. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
    
    /**
     * Query meals based on AI-extracted filters
     */
    private function queryMeals(array $filters)
    {
        $query = MenuItem::query()
            ->where('is_available', true)
            ->with('category');
        
        // Filter: Avoid certain ingredients
        if (!empty($filters['avoid'])) {
            $avoidList = array_map('trim', explode(',', strtolower($filters['avoid'])));
            
            foreach ($avoidList as $ingredient) {
                $query->where(function($q) use ($ingredient) {
                    $q->where('name', 'not like', "%{$ingredient}%")
                      ->where('description', 'not like', "%{$ingredient}%");
                });
            }
        }
        
        // Filter: Minimum protein
        if ($filters['min_protein'] !== null) {
            $query->where('protein', '>=', $filters['min_protein']);
        }
        
        // Filter: Maximum calories
        if ($filters['max_calories'] !== null) {
            $query->where('calories', '<=', $filters['max_calories']);
        }
        
        return $query->orderBy('name')->get();
    }
    
    /**
     * Generate human-friendly response message
     */
    private function generateResponseMessage(array $filters, $meals): string
    {
        $count = $meals->count();
        
        if ($count === 0) {
            // No results
            $constraints = [];
            if ($filters['avoid']) {
                $constraints[] = "without {$filters['avoid']}";
            }
            if ($filters['min_protein']) {
                $constraints[] = "with at least {$filters['min_protein']}g protein";
            }
            if ($filters['max_calories']) {
                $constraints[] = "under {$filters['max_calories']} calories";
            }
            
            if (empty($constraints)) {
                return "I couldn't find any meals. Try asking about our menu!";
            }
            
            return "Sorry, I couldn't find meals " . implode(', ', $constraints) . ". Try different criteria?";
        }
        
        // Results found
        $constraints = [];
        if ($filters['avoid']) {
            $constraints[] = "avoiding {$filters['avoid']}";
        }
        if ($filters['min_protein']) {
            $constraints[] = "{$filters['min_protein']}g+ protein";
        }
        if ($filters['max_calories']) {
            $constraints[] = "under {$filters['max_calories']} cal";
        }
        
        if (empty($constraints)) {
            return "Here are {$count} meals from our menu:";
        }
        
        return "Found {$count} meal" . ($count > 1 ? 's' : '') . " (" . implode(', ', $constraints) . "):";
    }
}