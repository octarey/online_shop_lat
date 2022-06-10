<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(function($request, $next){
           if(Gate::allows('manage-categories')) return $next($request);
           abort(403, 'Anda tidak memiliki cukup hak akses');
        });
    }

    public function index(Request $request)
    {
        $cats = Category::paginate(5);
        $keyword = $request->get('name');

        if($keyword){
            $cats = Category::where("name", "LIKE", "%$keyword%")->paginate(5);
        }

        return view ('categories.index', ['categories' => $cats]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Validator::make($request->all(), [
            "name" => "required|min:3|max:50"
        ])->validate();

        $cat = $request->get('name');
        $user = \Auth::user()->id;

        $new_cat = new Category;
        $new_cat->name = $cat;

        if($request->file('image')){
            $image_path = $request->file('image')->store('category_images', 'public');
            $new_cat->image = $image_path;
        }
        
        $new_cat->created_by = $user;
        $new_cat->slug = \Str::slug($cat, '-');

        $new_cat->save();

        return redirect()->route('categories.create')->with('status', 'Category successfully created');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cat = Category::findOrFail($id);

        return view('categories.show', ['category' => $cat]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cat = Category::findOrfail($id);

        return view('categories.edit', ['category' => $cat]);
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
        \Validator::make($request->all(), [
            "name" => "required|min:3|max:50"
        ])->validate();

        $cat = Category::findOrFail($id);

        $cat->name = $request->get('name');
        $cat->slug = \Str::slug($request->get('name'));

        if($request->file('image')){
            if($cat->image && file_exists(storage_path('app/public/'.$cat->image))){
                \Storage::delete('public/'. $cat->image);
            }

            $new_image = $request->file('image')->store('category_images','public');
            $cat->image = $new_image;
        }

        $cat->updated_by = \Auth::user()->id;
        $cat->save();

        return redirect()->route('categories.edit', [$id])->with('status', 'Category successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat_delete = Category::findOrFail($id);

        $cat_delete->delete();

        return redirect()->route('categories.index')->with('status', 'Category successfully deleted');
    }

    public function trash(){
        $deleted_cat = Category::onlyTrashed()->paginate(5);

        return view('categories.trash', ['categories' => $deleted_cat]);
    }

    public function restore($id){
        $restored_cat = Category::withTrashed()->findOrFail($id);

        if($restored_cat->trashed()){
            $restored_cat->restore();
        } else {
            return redirect()->route('categories.index')->with('status', 'Category in not trash');
        }

        return redirect()->route('categories.index')->with('status', 'Category successfully restored');
    }

    public function delete_permanent($id){
        $cat = Category::withTrashed()->findOrFail($id);

        if(!$cat->trashed()){
            return redirect()->route('categories.index')->with('status', 'Can not delet permanent active category');
        }else{
            $cat->forceDelete();

            return redirect()->route('categories.index')->with('status', 'Category permanently deleted');
        }
    }

    public function ajaxSearch(Request $request){
        $keyword = $request->get('q');
        $categories = Category::where("name", "LIKE", "%$keyword%")->get();

        return $categories;
    }
}
