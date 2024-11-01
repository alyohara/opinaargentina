<?php
namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::paginate(10); // Adjust the number as needed
        return view('cities.index', compact('cities'));
    }

    public function create()
    {
        $states = State::all();
        return view('cities.create', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
        ]);

        City::create($request->all());
        return redirect()->route('cities.index');
    }

    public function edit(City $city)
    {
        $states = State::all();
        return view('cities.edit', compact('city', 'states'));
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
        ]);

        $city->update($request->all());
        return redirect()->route('cities.index');
    }

    public function show(City $city)
    {
        return view('cities.show', compact('city'));
    }

    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('cities.index');
    }
}
