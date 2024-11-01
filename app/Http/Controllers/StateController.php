<?php

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        $states = State::all();
        return response()->json($states);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Add other validation rules as needed
        ]);

        $state = State::create($request->all());
        return response()->json($state, 201);
    }

    public function show(State $state)
    {
        return response()->json($state);
    }

    public function update(Request $request, State $state)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Add other validation rules as needed
        ]);

        $state->update($request->all());
        return response()->json($state);
    }

    public function destroy(State $state)
    {
        $state->delete();
        return response()->json(null, 204);
    }
}
