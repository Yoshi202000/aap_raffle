<?php

namespace App\Http\Controllers;

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
