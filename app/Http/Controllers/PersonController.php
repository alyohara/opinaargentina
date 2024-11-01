<?php
namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{
    public function index()
    {
        $people = Person::where('state', 'live')->paginate(10);
        return view('people.index', compact('people'));
    }

    public function create()
    {
        $states = State::all();
        return view('people.create', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'telephone' => 'nullable|string|max:255',
            'cellphone' => 'nullable|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ]);

        Person::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'cellphone' => $request->cellphone,
            'city_id' => $request->city_id,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('people.index');
    }

    public function edit(Person $person)
    {
        $states = State::all();
        $cities = City::where('state_id', $person->city->state_id)->get();
        return view('people.edit', compact('person', 'states', 'cities'));
    }

    public function update(Request $request, Person $person)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'telephone' => 'nullable|string|max:255',
            'cellphone' => 'nullable|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ]);

        $person->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'cellphone' => $request->cellphone,
            'city_id' => $request->city_id,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('people.index');
    }

    public function destroy(Person $person)
    {
        $person->update([
            'state' => 'deleted',
            'deleted_by' => Auth::id(),
            'deleted_at' => now(),
        ]);

        return redirect()->route('people.index');
    }

    public function show(Person $person)
    {
        return view('people.show', compact('person'));
    }
}
