<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroceryItemResource;
use App\Models\GroceryItem;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;

class GrocerySearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $query = $request->input('query', '');

        // First, search in the database
        $groceryItems = GroceryItem::search($query)
            ->limit(10)
            ->get();

        // If no items found in database, try Gemini AI
        if ($groceryItems->isEmpty() && ! empty($query)) {
            try {
                $aiItemData = $this->searchWithGemini($query);

                if ($aiItemData) {
                    // Save the AI-generated item to database for future searches
                    $groceryItem = GroceryItem::create([
                        'icon' => $aiItemData['icon'],
                        'name_bn' => $aiItemData['name_bn'],
                        'name_bn_en' => $aiItemData['name_bn_en'],
                        'name_en' => $aiItemData['name_en'],
                    ]);

                    return response()->json([
                        'data' => [new GroceryItemResource($groceryItem)],
                        'source' => 'ai',
                        'message' => 'নতুন প্রোডাক্ট যোগ করা হয়েছে',
                    ]);
                }

                // If Gemini also can't find it
                return response()->json([
                    'data' => [],
                    'message' => 'প্রোডাক্ট পাওয়া যায়নি',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'data' => [],
                    'message' => 'প্রোডাক্ট পাওয়া যায়নি',
                ]);
            }
        }

        return GroceryItemResource::collection($groceryItems);
    }

    /**
     * Search for grocery item using Gemini AI
     */
    private function searchWithGemini(string $query): ?array
    {
        $prompt = "You are a grocery item database assistant. Given a grocery item name '{$query}', provide the following information in JSON format:
{
    \"icon\": \"emoji icon for the item\",
    \"name_bn\": \"Bengali name\",
    \"name_bn_en\": \"Bengali name in English letters\",
    \"name_en\": \"English name\"
}

If you cannot identify this as a valid grocery item, return null. Only return valid grocery items.
Return only the JSON, no additional text.";

        $result = Gemini::generativeModel(model: 'gemini-2.0-flash')->generateContent($prompt);
        $responseText = $result->text();

        // Clean the response (remove markdown code blocks if present)
        $responseText = preg_replace('/```json\s*|\s*```/', '', $responseText);
        $responseText = trim($responseText);

        // Try to parse JSON
        $data = json_decode($responseText, true);

        if ($data && isset($data['icon'], $data['name_bn'], $data['name_bn_en'], $data['name_en'])) {
            return [
                'icon' => $data['icon'],
                'name_bn' => $data['name_bn'],
                'name_bn_en' => $data['name_bn_en'],
                'name_en' => $data['name_en'],
            ];
        }

        return null;
    }
}
