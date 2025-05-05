<?php
namespace App\Http\Controllers;

use App\Models\Raffle;
use Illuminate\Http\Request;
use App\Models\Prize;
use Illuminate\Support\Facades\Validator;

class RaffleController extends Controller
{
    public function show($raffle_id)
    {
        $raffle = \App\Models\Raffle::findOrFail($raffle_id);
        $prizes = \App\Models\Prize::where('raffle_id', $raffle_id)->get();
        
        return view('raffles.show', compact('raffle', 'prizes'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'raffle_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('bg_image')) {
            $image = $request->file('bg_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $validated['bg_image'] = 'images/' . $imageName;
        }

        Raffle::create($validated);
    
        return redirect()->back()->with('success', 'Raffle created!');
    }
    
    public function index()
    {
        $raffles = Raffle::all();
        return view('raffles.index', compact('raffles'));
    }
    

    public function edit($raffle_id)
    {
        $raffle = Raffle::findOrFail($raffle_id);
        
        $prizes = Prize::where('raffle_id', $raffle_id)->get();
        
        return view('raffles.edit', compact('raffle', 'prizes'));
    }

    public function update(Request $request, Raffle $raffle)
    {
        $validated = $request->validate([
            'raffle_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('bg_image')) {
            $image = $request->file('bg_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
    
            $validated['bg_image'] = 'images/' . $imageName;
        }

        $raffle->update($validated);

        return redirect('/raffles')->with('success', 'Raffle updated with image!');
    }
    public function create()
    {
        $raffles = Raffle::all();
        return view('raffles.create', compact('raffles'));
    }

}
