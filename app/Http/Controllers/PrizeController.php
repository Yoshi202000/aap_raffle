<?php

namespace App\Http\Controllers;

use App\Models\Prize;
use App\Models\Raffle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PrizeController extends Controller
{
    public function store(Request $request)
    {
        // Basic validation for raffle_id
        $validator = Validator::make($request->all(), [
            'raffle_id' => 'required|exists:raffles,raffle_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            DB::beginTransaction();
            
            // Get existing prizes to track images that should be preserved
            $existingPrizes = Prize::where('raffle_id', $request->raffle_id)->get();
            $existingImages = [];
            
            foreach ($existingPrizes as $prize) {
                if ($prize->prize_image) {
                    $existingImages[] = $prize->prize_image;
                }
            }
            
            // Remove all existing prizes for this raffle
            Prize::where('raffle_id', $request->raffle_id)->delete();
            
            // Process each prize from the form data
            if ($request->has('prizes')) {
                foreach ($request->prizes as $index => $prizeData) {
                    // Validate individual prize data
                    $prizeValidator = Validator::make($prizeData, [
                        'prize_name' => 'required|string|max:255',
                        'prize_value' => 'required|numeric|min:0|max:9999999.99',
                    ]);
                    
                    if ($prizeValidator->fails()) {
                        throw new \Exception("Prize #" . ($index + 1) . ": " . $prizeValidator->errors()->first());
                    }
                    
                    // Initialize prize data
                    $newPrizeData = [
                        'prize_name' => $prizeData['prize_name'],
                        'prize_value' => $prizeData['prize_value'],
                        'raffle_id' => $request->raffle_id
                    ];
                    
                    // Check if there's an image file for this prize
                    $imageKey = "prize_image_" . $index;
                    if ($request->hasFile($imageKey)) {
                        $image = $request->file($imageKey);
                        
                        // Validate the image
                        $imageValidator = Validator::make(['image' => $image], [
                            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                        ]);
                        
                        if ($imageValidator->fails()) {
                            throw new \Exception("Prize #" . ($index + 1) . " image: " . $imageValidator->errors()->first());
                        }
                        
                        $imageName = time() . '_' . $index . '_' . $image->getClientOriginalName();
                        $image->move(public_path('images/prizes'), $imageName);
                        $newPrizeData['prize_image'] = 'images/prizes/' . $imageName;
                    } elseif (isset($prizeData['existing_image'])) {
                        // Keep the existing image if it was preserved
                        $newPrizeData['prize_image'] = $prizeData['existing_image'];
                        
                        // Remove this image from the list to be deleted
                        $key = array_search($prizeData['existing_image'], $existingImages);
                        if ($key !== false) {
                            unset($existingImages[$key]);
                        }
                    }
                    
                    // Create the prize
                    Prize::create($newPrizeData);
                }
            }
            
            // Clean up unused images (optional)
            foreach ($existingImages as $imagePath) {
                if (file_exists(public_path($imagePath))) {
                    unlink(public_path($imagePath));
                }
            }
            
            DB::commit();
            return response()->json(['message' => 'Prizes saved successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Prize save error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to save prizes: ' . $e->getMessage()], 500);
        }
    }
    

    public function update(Request $request, Prize $prize)
    {
        $validated = $request->validate([
            'prize_name' => 'required|string|max:255',
            'prize_value' => 'required|numeric|min:0',
        ]);

        $prize->update($validated);

        return redirect()->back()->with('success', 'Prize updated.');
    }

    public function destroy(Prize $prize)
    {
        $prize->delete();

        return redirect()->back()->with('success', 'Prize deleted.');
    }

    public function showByRaffle($raffle_id)
    {
        $raffle = Raffle::findOrFail($raffle_id);
        $prizes = Prize::where('raffle_id', $raffle_id)->get();
        
        return view('prizes.show', compact('raffle', 'prizes'));
    }
    public function debug(Request $request)
{
    // Log the request data
    Log::info('Prize request data:', [
        'all' => $request->all(),
        'files' => $request->allFiles(),
        'headers' => $request->header()
    ]);
    
    return response()->json([
        'success' => true,
        'message' => 'Debug information logged',
        'data' => [
            'request' => $request->all(),
            'files' => count($request->allFiles()) . ' files received'
        ]
    ]);
}
}
