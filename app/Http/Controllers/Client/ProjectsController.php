<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProjectRequest;
use App\Models\Project;
use App\Models\Category;
use App\Models\Tag;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        // $projects = Project::where('user_id', '=' , $user->id )->paginate();
        // use egerlouding بنستخدم الegerlouding عشان نقلل عدد جمل الاستعلام الي بتتعمل علي BD
        
        $projects = $user->projects()->with('category.parent','tags')->paginate();
        return view('client.projects.index',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client.projects.create',
        [
            'project' => new Project(),
            'types' => Project::types(),
            'categories' => $this->categories(),
            'tags' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        

        $user = $request->user();
       
        $project = $user->projects()->create($request->all()); 

        $tags = explode(',',$request->input('tags'));
        $project->syncTags($tags);
        



        return redirect()
        ->route('client.projects.index')
        ->with('success','Project added');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $project = $user->projects()->findOrFail($id);
        return view('client.projects.show',
        [
            'project'=>$project,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $project = $user->projects()->findOrFail($id);
        $tags = $project->tags()->pluck('name')->toArray();
        $types = Project::types();
        $categories = $this->categories();

        return view('client.projects.edit',compact(['project','types','categories', 'tags']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest  $request, string $id)
    {
        $user = Auth::user();
        $project = $user->projects()->findOrFail($id);

        $project->update($request->all());

        $tags = explode(',',$request->input('tags'));
        $project->syncTags($tags);

        return redirect()
        ->route('client.projects.index')
        ->with('success','Project updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Project::where('user_id',Auth::id())
        // ->where('id',$id)
        // ->delete();

        //Or
        $user = Auth::user();

        $user->projects()->where('id',$id)->delete();


        return redirect()
        ->route('client.projects.index')
        ->with('success','Project Deleted');
    }

    protected function categories()
    {
        return Category::pluck('name','id')->toArray();

    }
}
