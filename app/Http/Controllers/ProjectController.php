<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
use App\Services\KeypairService;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::latest()->paginate(10);

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'difficulty' => 'required|numeric|min:1|max:15'
        ]);

        $service = new KeypairService();
        $keypair = $service->createKeypair();

        $project = [
            'blockchain_id' => Project::findOrCreateBlockchain($request->type, $request->difficulty)->id,
            'name' => $request->name,
            'type' => $request->type,
            'public_key' => $service->getPublicKey($keypair),
            'secret_key' => $service->getSecretKey($keypair),
            'start_version' => getenv('HELPPOCHAIN_CURRENT_VERSION'),
            'current_version' => getenv('HELPPOCHAIN_CURRENT_VERSION'),
        ];
        
        Project::create($project);

        return redirect()->route('projects.index')
                        ->with('success','Project created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {   
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Creates a new transaction.
     *
     * @param  json  $data
     * @return \Illuminate\Http\Response
     */
    public function createTransaction(Project $project, Request $request)
    {
        $request->validate([
            'data' => 'json',
        ]);

        $transaction = $project->createTransaction($request->data);

        return redirect()->route('projects.show', $project->id)
                        ->with('success','Project created successfully');
    }
}
