<?php

namespace App\Http\Controllers;

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
    
    protected $rules=[
            'name'=>['required',
            'string',
            'max:255',
            'min:2',
            'filter'
        ],
            'parent_id'=>'nullable|int|exists:categories,id',
            'description'=>'required|string',
            'art_file'=>['nullable','image']
        ];
    protected $messages = [
            'required' => 'The :attribute field is mandatory',
        ];
    protected function rules()
        {
            $rules = $this->rules;
            // $rules['name'][] = function($attribute,$value,$fail){
            //     if($value == 'god'){
            //         $fail('this word is not allowed');
            //     }
            // };

            // OR
            // $rules['name'][] = new FilterRule();
            // __________________________________________________
            return $rules;
        }
    //Action
    public function index($id = null)
    {


       $categories = Category::all();

       $title = 'Categories';
    //    return veiw('categories',compact('categories','title'));
        //   OR
          return view('categories.index',
          [
            'categories' => $categories,
            'title' => 'Categories',
            'flashMassage' => session('success')
          ]);
        //   OR
        //   return view('categories')->with([
        //     'title' => $title,
        //     'categories' => $categories,

        //   ]);
    }
    public function show($id){

    //  $category = DB::table('categories')->where('id','=',$id)->first();
    //  $category = Category::where('id','=',$id)->first();
     $category = Category::findOrFail($id);
            if($category == null){
                abort(404);
             }
        return view('categories.show',[
            'category' => $category,
        ]);
    }

    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('categories.create',compact('parents','category'));
    }
    public function store(Request $request)
    {

        $clean =$request->validate($this->rules() , $this->messages);

        //OR
        // $clean = $this->validate($request,$rules);
        //OR
        //دي هي الاساس موجودة داخل validate().
        // $validator = Validator::make($request->all(),$rules);
        // $clean = $validator->validate();
        // if($validator->fails()){
        //     return redirect()->back()->withErrors($validator);
        // }
        // dd(
        //     $request->name ,
        //     $request->input('name'),
        //     $request->post('name'),
        //     $request->get('name'),
        //     $request['name'],
        //     $request->query('name')
        // );
        // DB::table('categories')->insert([]);
        $category = new Category();
        $category->name = $request-> input('name');
        $category->description = $request-> input('description');
        $category->parent_id = $request-> input('parent_id');
        $category->slug = Str::slug($request-> input('name'));
        $category->save();
        return redirect(route('categories.index'))
        ->with('success','Category is Created!');

    }
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parents = Category::all();
        // dd($parent_id);

        return view('categories.edit',
    [
        'category' => $category ,
        'parents' => $parents ,
    ]);

    }
    public function update(Request $request ,$id)
    {
        $category = Category::findOrFail($id);

        $clean =$request->validate($this->rules( ) , $this->messages);


        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->parent_id = $request->input('parent_id');
        $category->slug = Str::slug($category->name);
        $category->save();
        return redirect(route('categories.index'))
        ->with('warning','Category is Updated!');


    }
    public function destroy($id)
    {
    //     DB::table('catedories')->where('id',$id)->delete();

    //     Category::where('id', $id )->delete();

        Category::destroy($id);

        // $category = Category::findOrFail($id);
        //     $category->delete();
        // session()->flash('success', 'Category Deleted!');
        Session::flash('error','Category is Deleted!');
        return redirect(route('categories.index'));
        // ->with('success','Category is deleted!');

    }

}
