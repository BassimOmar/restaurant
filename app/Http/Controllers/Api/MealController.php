<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MealController extends Controller
{
    /**
     * Get filtered meals based on dietary preferences
     * 
     * Query parameters:
     * - avoid: string (comma-separated ingredients to avoid)
     * - min_protein: int (minimum protein in grams)
     * - max_calories: int (maximum calories)
     */
    public function index(Request $request): JsonResponse
    {
        // Validate query parameters
        $validated = $request->validate([
            'avoid' => 'nullable|string|max:500',
            'min_protein' => 'nullable|integer|min:0',
            'max_calories' => 'nullable|integer|min:0',
        ]);

        try {
            // Start query
            $query = MenuItem::query()
                ->where('is_available', true)
                ->with('category');

            // Filter: Avoid certain ingredients
            if ($request->has('avoid') && !empty($request->avoid)) {
                $avoidList = array_map('trim', explode(',', strtolower($request->avoid)));
                
                foreach ($avoidList as $ingredient) {
                    $query->where(function($q) use ($ingredient) {
                        $q->where('name', 'not like', "%{$ingredient}%")
                          ->where('description', 'not like', "%{$ingredient}%");
                    });
                }
            }

            // Filter: Minimum protein
            if ($request->has('min_protein') && $request->min_protein !== null) {
                $query->where('protein', '>=', $request->min_protein);
            }

            // Filter: Maximum calories
            if ($request->has('max_calories') && $request->max_calories !== null) {
                $query->where('calories', '<=', $request->max_calories);
            }

            // Execute query
            $meals = $query->orderBy('name', 'asc')->get();

            // Transform data
            $mealsData = $meals->map(function ($meal) {
                return [
                    'id' => $meal->id,
                    'name' => $meal->name,
                    'description' => $meal->description,
                    'price' => (float) $meal->price,
                    'protein' => $meal->protein,
                    'calories' => $meal->calories,
                    'image' => $meal->image,
                    'category' => $meal->category->name ?? 'Other',
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $mealsData,
                'count' => $mealsData->count(),
                'filters' => [
                    'avoid' => $request->avoid,
                    'min_protein' => $request->min_protein,
                    'max_calories' => $request->max_calories,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching meals',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}