<?php

namespace App\Http\Controllers;

use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;

class GroceryListPriceUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $items = $request->user()->groceryLists()->with('item')->get();

        // Prepare items data for AI
        $itemsData = $items->map(function ($groceryList) {
            return [
                'id' => $groceryList->id,
                'name' => $groceryList->item->name_bn,
                'name_en' => $groceryList->item->name_en,
                'quantity' => $groceryList->quantity,
                'unit' => $groceryList->unit,
                'current_price' => $groceryList->price,
            ];
        })->toArray();

        // Create prompt for Gemini
        $prompt = "You are a Bangladesh grocery price expert. Today's date is ".now()->format('F d, Y').".
Given the following grocery items, provide updated current market prices in BDT (Bangladeshi Taka) for each item based on today's market rates in Bangladesh.

Items:
".json_encode($itemsData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE).'

Please return a JSON array with the following format for each item:
[
    {
        "id": item_id,
        "price": updated_price_per_unit_in_BDT
    }
]

Consider:
- Current Bangladesh market prices
- Seasonal variations
- Common retail prices in Dhaka
- Provide realistic prices based on the unit (kg, liter, piece, etc.)

Return only the JSON array, no additional text or explanation.';

        try {
            $result = Gemini::generativeModel(model: 'gemini-2.0-flash')->generateContent($prompt);
            $responseText = $result->text();

            // Clean the response (remove markdown code blocks if present)
            $responseText = preg_replace('/```json\s*|\s*```/', '', $responseText);
            $responseText = trim($responseText);

            // Parse JSON
            $updatedPrices = json_decode($responseText, true);

            if ($updatedPrices && is_array($updatedPrices)) {
                // Update prices for each item
                foreach ($updatedPrices as $priceData) {
                    if (isset($priceData['id'], $priceData['price'])) {
                        $groceryList = $items->firstWhere('id', $priceData['id']);
                        if ($groceryList) {
                            $groceryList->price = $priceData['price'];
                            $groceryList->save();
                        }
                    }
                }

                return redirect()->back()->with('success', 'দাম সফলভাবে আপডেট করা হয়েছে!');
            }

            return redirect()->back()->with('error', 'AI থেকে সঠিক তথ্য পাওয়া যায়নি। আবার চেষ্টা করুন।');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'দাম আপডেট করতে সমস্যা হয়েছে: '.$e->getMessage());
        }
    }
}
