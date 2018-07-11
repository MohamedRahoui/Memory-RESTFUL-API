<?php

namespace App\Http\Controllers;

use App\Experiment;
use App\User;
use Illuminate\Http\Request;

class ExperimentController extends Controller
{

    public function __construct()
    {
        $this->middleware('staff')->except(['indexByUser', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $experiments = Experiment::all();
        return response()->json($experiments);
    }

    public function indexByUser($id)
    {
        $user = User::find($id);
        return response()->json($user->experiments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'url' => 'required',
            'time' => 'required',
            'popups' => 'required|array',
            'answers' => 'array'
        ]);
        $experiment = new Experiment($request->all());
        $experiment->save();
        return response()->json($experiment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $experiment = Experiment::findOrFail($id);
        return response()->json($experiment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $experiment = Experiment::findOrFail($id);
        $experiment->delete();
        return response()->json([
            'deleted' => true
        ]);
    }
}
