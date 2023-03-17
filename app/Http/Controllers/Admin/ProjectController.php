<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;




class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderBy('updated_at', 'DESC')->simplePaginate(10);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::orderBy('id')->get();
        $technologies = Technology::orderBy('id')->get();
        $project = new Project();

        return view('admin.projects.create', compact('project', 'types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:projects',
            'project_url' => 'required|url',
            'image_url' => 'image|nullable',
            'description' => 'required|string',
            'type_id' => 'nullable|exists:types,id'

        ]);

        $data = $request->all();
        $new_project = new Project();

        if (Arr::exists($data, 'image_url')) {
            $img_url = Storage::put('projects', $data['image_url']);
            $data['image_url'] = $img_url;
        };

        $new_project->fill($data);
        $new_project->save();

        if (Arr::exists($data, 'technologies')) $new_project->technologies()->attach($data['technologies']);


        return to_route('admin.projects.show', $new_project->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::orderBy('id')->get();
        $technologies = Technology::orderBy('id')->get();
        $project_technologies = $project->technologies->pluck('id')->toArray();


        return view('admin.projects.edit', compact('project', 'types', 'technologies', 'project_technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|unique:projects',
            'project_url' => 'required|url',
            'image_url' => 'image|nullable',
            'description' => 'required|string',
            'type_id' => 'nullable|exists:types,id'
        ]);

        $data = $request->all();

        if (Arr::exists($data, 'image_url')) {
            if ($project->image_url) Storage::delete($project->image_url);

            $img_url = Storage::put('projects', $data['image_url']);
            $data['image_url'] = $img_url;
        };


        $project->fill($data);
        $project->save();

        if (Arr::exists($data, 'technologies')) $project->technologies()->sync($data['technologies']);
        else if (count($project->technologies)) $project->technologies()->detach();

        return to_route('admin.projects.show', $project->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return to_route('admin.projects.index');
    }
}
