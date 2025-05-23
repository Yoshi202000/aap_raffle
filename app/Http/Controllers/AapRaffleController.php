<?php

namespace App\Http\Controllers;

use App\Models\AapRaffle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AapRaffleController extends Controller
{
    public function index()
    {
        $raffles = AapRaffle::orderBy('ar_order', 'asc')->get();
        return view('aap_raffle.index', compact('raffles'));
    }
    public function showcasetwo()
    {
        return view('aap_raffle.raffle_showcase');
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
            'raffle_image' => 'required|file|mimes:jpg,jpeg,png|max:20048',
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
            'raffle_image' => 'nullable|file|mimes:jpg,jpeg,png|max:20048',
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
    
    $request->validate([
        'raffle_image' => 'required|file|mimes:jpg,jpeg,png|max:20048',
    ]);
    
    if ($request->hasFile('raffle_image')) {
        $image = $request->file('raffle_image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);
        
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
public function decreasePrize(Request $request)
{
    try {
        $request->validate([
            'raffle_id' => 'required|integer|exists:aap_raffle,ar_id'
        ]);
        
        $raffleId = $request->input('raffle_id');
        
        // Find the raffle
        $raffle = AapRaffle::findOrFail($raffleId);
        
        // Check if there are prizes left
        if ($raffle->ar_noprize <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'No more prizes available for this raffle'
            ], 400);
        }
        
        // Decrease the prize count by 1
        $raffle->ar_noprize = $raffle->ar_noprize - 1;
        $raffle->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Prize count decreased successfully',
            'new_count' => $raffle->ar_noprize,
            'raffle_id' => $raffleId
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred: ' . $e->getMessage()
        ], 500);
    }
}
 public function carouselAll()
    {
        $allRaffles = AapRaffle::where('ar_members', 1)->orderBy('ar_order', 'asc')->get();
        
        $prizes = [];
        
        foreach ($allRaffles as $raffle) {
            $prizes[] = [
                'prize_name' => $raffle->ar_nameprize,
                'prize_image' => $raffle->raffle_image,
                'prize_count' => $raffle->ar_noprize,
                'raffle_id' => $raffle->ar_id,
                'description' => $raffle->ar_nameprizet
            ];
        }
        
        // Get a random winner from the database
        $randomCoupon = DB::table('aap_scoupon_detail')
            ->where('ascd_status', 'ACTIVE')
            ->inRandomOrder()
            ->first();
            
        $winner = null;
        
        if ($randomCoupon) {
            $winnerData = DB::table('aap_scoupon_detail as ad')
                ->join('aap_scoupon_header as ah', 'ah.asc_id', '=', 'ad.asc_id')
                ->join('members_table as mt', 'ah.members_id', '=', 'mt.members_id')
                ->select('mt.members_firstname', 'mt.members_lastname', 'ad.ascd_couponcode')
                ->where('ad.ascd_couponcode', $randomCoupon->ascd_couponcode)
                ->first();
                
            if ($winnerData) {
                $winner = [
                    'name' => $winnerData->members_firstname . ' ' . $winnerData->members_lastname,
                    'coupon' => $winnerData->ascd_couponcode
                ];
            }
        }
        
        return view('aap_raffle.all_carousel', [
            'prizes' => $prizes,
            'title' => 'All Raffle Prizes',
            'winner' => $winner
        ]);
    }
public function attendeesCarousel()
{
    // Get all raffles that have ar_members == 0, ordered by ar_order
    $allRaffles = AapRaffle::where('ar_members', 0)->orderBy('ar_order', 'asc')->get();
    
    // Format them for the carousel
    $prizes = [];
    
    foreach ($allRaffles as $raffle) {
        $prizes[] = [
            'prize_name' => $raffle->ar_nameprize,
            'prize_image' => $raffle->raffle_image,
            'prize_count' => $raffle->ar_noprize,
            'raffle_id' => $raffle->ar_id,
            'description' => $raffle->ar_nameprizet
        ];
    }
    
    return view('aap_raffle.attendees_carousel', [
        'prizes' => $prizes,
        'title' => 'Attendee Raffle Prizes'
    ]);
}
}
