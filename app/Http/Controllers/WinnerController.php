<?php

namespace App\Http\Controllers;
use App\Models\Raffle;
use Illuminate\Http\JsonResponse;
use App\Models\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WinnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display the random resource of coupon code.
     */


public function randomApi(): JsonResponse
{
    try {
        // Get a random ACTIVE coupon
        $randomCoupon = DB::table('aap_scoupon_detail')
            ->where('ascd_status', 'ACTIVE')
            ->inRandomOrder()
            ->first();

        if (!$randomCoupon) {
            return response()->json(['winner' => null]);
        }

        // Mark the coupon as INACTIVE
        DB::table('aap_scoupon_detail')
            ->where('ascd_couponcode', $randomCoupon->ascd_couponcode)
            ->update(['ascd_status' => 'INACTIVE']);

        // Join tables to get winner info
        $winner = DB::table('aap_scoupon_detail as ad')
            ->join('aap_scoupon_header as ah', 'ah.asc_id', '=', 'ad.asc_id')
            ->join('members_table as mt', 'ah.members_id', '=', 'mt.members_id')
            ->select('mt.members_firstname', 'mt.members_lastname', 'ad.ascd_couponcode')
            ->where('ad.ascd_couponcode', $randomCoupon->ascd_couponcode)
            ->first();

        if (!$winner) {
            return response()->json(['winner' => null]);
        }

        return response()->json([
            'winner' => [
                'name' => $winner->members_firstname . ' ' . $winner->members_lastname,
                'coupon' => $winner->ascd_couponcode,
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Something went wrong.',
            'details' => $e->getMessage()
        ], 500);
    }
}
    public function random()
    {
        // Get a random active coupon
        $randomCoupon = DB::table('aap_scoupon_detail')
            ->where('ascd_status', 'ACTIVE')
            ->inRandomOrder()
            ->first();

        // If no active coupons found
        if (!$randomCoupon) {
            return view('winner.show', ['winner' => null]);
        }

        // Update the status of the selected coupon to INACTIVE
        DB::table('aap_scoupon_detail')
            ->where('ascd_couponcode', $randomCoupon->ascd_couponcode)
            ->update(['ascd_status' => 'INACTIVE']);

        // Get winner info using the random coupon
        $winner = DB::table('aap_scoupon_detail as ad')
            ->join('aap_scoupon_header as ah', 'ah.asc_id', '=', 'ad.asc_id')
            ->join('members_table as mt', 'ah.members_id', '=', 'mt.members_id')
            ->select('mt.members_firstname', 'mt.members_lastname', 'ad.ascd_couponcode')
            ->where('ad.ascd_couponcode', $randomCoupon->ascd_couponcode)
            ->first();

        return view('winner.show', [
        'couponCode' => $winner->ascd_couponcode,
        'winnerName' => $winner->members_firstname . ' ' . $winner->members_lastname
    ]);
    }

    public function statusupdate()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Winner $winner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Winner $winner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Winner $winner)
    {
        //
    }
}
