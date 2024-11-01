<?php
namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return response()->json($cities);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
            // Add other validation rules as needed
        ]);

        $city = City::create($request->all());
        return response()->json($city, 201);
    }

    public function show(City $city)
    {
        return response()->json($city);
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
            // Add other validation rules as needed
        ]);

        $city->update($request->all());
        return response()->json($city);
    }

    public function destroy(City $city)
    {
        $city->delete();
        return response()->json(null, 204);
    }
}
