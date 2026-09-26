<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
// use App\Rules\FilterRule;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Response;

class CategoriesController extends Controller
{
    protected $rules = [
        'name' => [
            'required',
            'string',
            'max:255',
            'min:2',
            'filter'
        ],
        'parent_id' => 'nullable|int|exists:categories,id',
        'description' => 'required|string',
        'art_file' => ['nullable', 'image']
    ];
    protected $messages = [
        'required' => 'The :attribute field is mandatory',
    ];
    protected function rules()
    {
        $rules = $this->rules;

        return $rules;
    }
    //Action
    public function index($id = null)
    {

        $categories = Category::leftjoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])->paginate(3);



        $title = 'Categories';

        return view(
            'categories.index',
            [
                'categories' => $categories,
                'title' => 'Categories',
                'flashMassage' => session('success')
            ]
        );
    }
    public function show(Category $category)
    {


        if ($category == null) {
            abort(404);
        }
        return view('categories.show', [
            'category' => $category,
        ]);
    }

    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('categories.create', compact('parents', 'category'));
    }
    public function store(Request $request)
    {

        $clean = $request->validate($this->rules(), $this->messages);

        $data = $request->all();
        if (! $data['slug']) {
            $data['slug'] = Str::slug($data['name']);
        };

        $category = Category::create($data);
        return redirect(route('categories.index'))
            ->with('success', 'Category is Created!');
    }
    public function edit(Category $category)
    {

        $parents = Category::all();


        return view(
            'categories.edit',
            [
                'category' => $category,
                'parents' => $parents,
            ]
        );
    }
    public function update(Request $request, Category $category)
    {


        $clean = $request->validate($this->rules(), $this->messages);

        $data = $request->all();

        $category->update($data);



        return redirect(route('categories.index'))
            ->with('warning', 'Category is Updated!');
    }
    public function destroy(Category $category)
    {

        $category->delete();


        Session::flash('error', 'Category is Deleted!');
        return redirect(route('categories.index'));
    }
}
