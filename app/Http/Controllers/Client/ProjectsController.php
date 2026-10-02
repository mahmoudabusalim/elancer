<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProjectRequest;
use App\Models\Project;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
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

        $projects = $user->projects()->with('category.parent', 'tags')->paginate();
        return view('client.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'client.projects.create',
            [
                'project' => new Project(),
                'types' => Project::types(),
                'categories' => $this->categories(),
                'tags' => [],
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {



        $user = $request->user();
        $data = $request->except('attachments');
        $data['attachments'] = $this->uploadAttachments($request);



        $project = $user->projects()->create($data);

        $tags = explode(',', $request->input('tags'));
        $project->syncTags($tags);




        return redirect()
            ->route('client.projects.index')
            ->with('success', 'Project added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $project = $user->projects()->findOrFail($id);
        return view(
            'client.projects.show',
            [
                'project' => $project,
            ]
        );
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

        return view('client.projects.edit', compact(['project', 'types', 'categories', 'tags']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest  $request, string $id)
    {
        $user = Auth::user();
        $project = $user->projects()->findOrFail($id);

        $data = $request->except('attachments');
        $data['attachments'] = array_merge(($project->attachments ?? [] ),
        $this->uploadAttachments($request));

        $project->update($data);

        $tags = explode(',', $request->input('tags'));
        $project->syncTags($tags);

        return redirect()
            ->route('client.projects.index')
            ->with('success', 'Project updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = Auth::user();

        $project = $user->projects()->findOrFail($id);

        if(isset($project->attachments)):
            foreach ($project->attachments as $attachment):
                //unlink(storage_path('app/public/' .$attachmet));
                Storage::disk('uploads')->delete($attachment);
            endforeach;
        endif;

          $project->delete();

        return redirect()
            ->route('client.projects.index')
            ->with('success', 'Project Deleted');
    }

    protected function categories()
    {
        return Category::pluck('name', 'id')->toArray();
    }

    protected function uploadAttachments(ProjectRequest $request)
    {
        if (!$request->hasFile('attachments')):
            return;
        endif;

        $files = $request->file('attachments');
        $attachments = [];

        foreach ($files as $file):
            if ($file->isValid()):

                $path = $file->store('/attachments', [
                    'disk' => 'uploads'
                ]);
                $attachments[] = $path;
            endif;
        endforeach;
        return $attachments;
    }
}
