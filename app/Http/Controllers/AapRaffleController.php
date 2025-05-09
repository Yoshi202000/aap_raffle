<?php

namespace App\Http\Controllers;

use App\Models\AapRaffle;
use Illuminate\Http\Request;

class AapRaffleController extends Controller
{
    public function index()
    {
        $raffles = AapRaffle::orderBy('ar_order', 'asc')->get();
        return view('aap_raffle.index', compact('raffles'));
    }
    

    public function create()
{
    return view('aap_raffle.create'); 
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'nullable|integer',
            'ar_cat' => 'nullable|integer',
            'ar_members' => 'nullable|integer',
            'ar_attendees' => 'nullable|integer',
            'ar_nameprize' => 'required|string|max:255',
            'ar_nameprizet' => 'nullable|string|max:100',
            'ar_noprize' => 'required|integer',
            'ar_noattendees' => 'nullable|integer',
            'ar_date' => 'nullable|date',
            'ar_order' => 'required|integer|min:0|max:255',
            'raffle_image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('raffle_image')) {
            $image = $request->file('raffle_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $validated['raffle_image'] = 'images/' . $imageName;
        }

        AapRaffle::create($validated);

        return redirect()->route('aap_raffles.index')->with('success', 'AAP Raffle entry created!');
    }

    public function edit(AapRaffle $aap_raffle)
{
    return view('aap_raffle.edit', compact('aap_raffle'));
}
public function show(AapRaffle $aap_raffle)
{
    return view('aap_raffle.show', compact('aap_raffle'));
}


    public function update(Request $request, AapRaffle $aapRaffle)
    {
        $validated = $request->validate([
            'branch_id' => 'nullable|integer',
            'ar_cat' => 'nullable|integer',
            'ar_members' => 'nullable|integer',
            'ar_attendees' => 'nullable|integer',
            'ar_nameprize' => 'required|string|max:255',
            'ar_nameprizet' => 'nullable|string|max:100',
            'ar_noprize' => 'required|integer',
            'ar_noattendees' => 'nullable|integer',
            'ar_date' => 'nullable|date',
            'ar_order' => 'required|integer|min:0|max:255',
            'raffle_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('raffle_image')) {
            $image = $request->file('raffle_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $validated['raffle_image'] = 'images/' . $imageName;
        }

        $aapRaffle->update($validated);

        return redirect()->route('aap_raffles.index')->with('success', 'AAP Raffle entry updated!');
    }

    public function destroy(AapRaffle $aapRaffle)
    {
        $aapRaffle->delete();
        return redirect()->route('aap_raffles.index')->with('success', 'AAP Raffle entry deleted!');
    }
    public function updateOrder(Request $request)
{
    $orders = $request->input('orders', []);
    
    foreach ($orders as $item) {
        $raffle = AapRaffle::find($item['id']);
        if ($raffle) {
            $raffle->ar_order = $item['order'];
            $raffle->save();
        }
    }
    
    return response()->json(['success' => true]);
}

public function updateField(Request $request, $id)
{
    $raffle = AapRaffle::findOrFail($id);
    
    $field = $request->input('field');
    $value = $request->input('value');
    
    // Validate the field and value
    $validator = null;
    
    switch ($field) {
        case 'ar_nameprize':
            $validator = Validator::make(['ar_nameprize' => $value], [
                'ar_nameprize' => 'required|string|max:255',
            ]);
            break;
        case 'ar_noattendees':
            $validator = Validator::make(['ar_noattendees' => $value], [
                'ar_noattendees' => 'nullable|integer|min:0',
            ]);
            break;
        case 'ar_noprize':
            $validator = Validator::make(['ar_noprize' => $value],[
                'ar_noprize' => 'required|integer|min:0',
            ]);
            break;
        default:
            return response()->json(['error' => 'Invalid field'], 400);
    }
    
    if ($validator && $validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 400);
    }
    
    // Update the field
    $raffle->$field = $value;
    $raffle->save();
    
    return response()->json(['success' => true, 'message' => 'Field updated successfully']);
}



public function updateImage(Request $request, $id)
{
    $raffle = AapRaffle::findOrFail($id);
    
    // Validate the image
    $request->validate([
        'raffle_image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
    ]);
    
    // Upload the new image
    if ($request->hasFile('raffle_image')) {
        $image = $request->file('raffle_image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);
        
        // Update the raffle entry
        $raffle->raffle_image = 'images/' . $imageName;
        $raffle->save();
        
        return response()->json([
            'success' => true, 
            'message' => 'Image updated successfully',
            'image_url' => asset($raffle->raffle_image)
        ]);
    }
    
    return response()->json(['error' => 'No image provided'], 400);
}
}
