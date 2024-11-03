<?php
namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        $states = State::all();
        return view('states.index', compact('states'));
    }

    public function create()
    {
        return view('states.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'region' => 'required'
        ]);
        State::create($request->all());
        return redirect()->route('states.index');
    }

    public function show(State $state)
    {
        return view('states.show', compact('state'));
    }

    public function edit(State $state)
    {
        return view('states.edit', compact('state'));
    }

    public function update(Request $request, State $state)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'region' => 'required'
        ]);
        $state->update($request->all());
        return redirect()->route('states.index');
    }

    public function destroy(State $state)
    {
        $state->delete();
        return redirect()->route('states.index');
    }
}
