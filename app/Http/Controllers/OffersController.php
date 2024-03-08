<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\offers; // Corrected namespace for Offer model

class OffersController extends Controller
{
    public function get_offers()
    {
        $offers = offers::all(); // Corrected reference to Offer model
        return response()->json($offers);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'image'=> 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $offer = new offers(); // Corrected model name
        $offer->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            $fileName = $request->file('image')->store('posts', 'public');
            $offer->image = $fileName;

        }
        $offer->save();

        return response()->json(['message' => 'Offer created successfully', 'offer' => $offer]);
    }

    public function show($id)
    {
        $offer = offers::find($id);
        if (!$offer) {
            return response()->json(['message' => 'Offer not found'], 404);
        }
        return response()->json($offer);
    }

    public function update(Request $request, $id)
    {
        $offer = offers::find($id);
        if (!$offer) {
            return response()->json(['message' => 'Offer not found'], 404);
        }

        $request->validate([
            'category_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $offer->category_id = $request->category_id;
        if ($request->hasFile('image')) {
            $offer->image = $request->file('image')->store('offers', 'public');
        }
        $offer->save();

        return response()->json(['message' => 'Offer updated successfully', 'offer' => $offer]);
    }

    public function destroy($id)
    {
        $offer = offers::find($id);
        if (!$offer) {
            return response()->json(['message' => 'Offer not found'], 404);
        }
        $offer->delete();
        return response()->json(['message' => 'Offer deleted successfully']);
    }












}
