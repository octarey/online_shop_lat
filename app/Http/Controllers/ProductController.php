<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(function($request, $next){
           if(Gate::allows('manage-products')) return $next($request);
           abort(403, 'Anda tidak memiliki cukup hak akses');
        });
    }

    public function index(Request $request)
    {
        $status = $request->get('status');
        $keyword = $request->get('keyword') ? $request->get('keyword') : '';

        if ($status) {
            $products = Product::with('categories')
                        ->where('status', strtoupper($status))
                        ->where("name","LIKE","%$keyword%")
                        ->paginate(10);
        } else {
            $products = Product::with('categories')
                        ->where("name", "LIKE", "%$keyword%")
                        ->paginate(10);
        }
        
        return view ('products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
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
            "name" => "required|min:5|max:100",
            "description" => "required|min:20|max:1000",
            "merk" => "required",
            "origin" => "required",
            "price" => "required|digits_between:0,10",
            "stock" => "required",
            "image" => "required"
        ])->validate();

        $new_product = new Product;

        $new_product->name = $request->get('name');
        $new_product->description = $request->get('description');
        $new_product->merk = $request->get('merk');
        $new_product->origin = $request->get('origin');
        $new_product->price = $request->get('price');
        $new_product->stock = $request->get('stock');

        $new_product->status = $request->get('save_action');

        $image = $request->file('image');
        if($image){
            $image_path = $image->store('product-images', 'public');
            $new_product->image = $image_path;
        }

        $new_product->slug = \Str::slug($request->get('name'));
        $new_product->created_by = \Auth::user()->id;
        $new_product->save();

        $new_product->categories()->attach($request->get('categories'));

        if($request->get('save_action') == 'PUBLISH'){
            return redirect()->route('products.create')->with('status', 'Product successfully saved and published');
        } else {
            return redirect()->route('products.index')->with('status', 'Product saved as draft');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view ('products.edit', ['product'=>$product]);
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
            "name" => "required|min:5|max:100",
            "description" => "required|min:20|max:1000",
            "merk" => "required",
            "origin" => "required",
            "price" => "required|digits_between:0,10",
            "stock" => "required",
        ])->validate();
        
        $product = Product::findOrFail($id);

        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->merk = $request->get('merk');
        $product->origin = $request->get('origin');
        $product->price = $request->get('price');
        $product->stock = $request->get('stock');

        $new_image = $request->file('image');
        if($new_image){
            if($product->image && file_exists(storage_path('app/public/'. $product->image))){
                \Storage::delete('public/'. $product->image);
            }

            $new_image_path = $new_image->store('product-images', 'public');
            $product->image = $new_image_path;
        }

        $product->updated_by = \Auth::user()->id;
        $product->status = $request->get('status');
        $product->save();

        $product->categories()->sync($request->get('categories'));

        return redirect()->route('products.edit', [$product->id])->with('status', 'Product successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('status', 'Product moved to trash');
    }

    public function trash(){
        $products_trash = Product::onlyTrashed()->paginate(10);
        return view('products.trash', ['products' => $products_trash]);
    }

    public function restore($id){
        $product = Product::withTrashed()->findOrFail($id);

        if($product->trashed()){
            $product->restore();
            return redirect()->route('products.trash')->with('status', 'Product successfully restored');
        } else {
            return redirect()->route('products.trash')->with('status', 'Product is not in trash');
        }
    }

    public function deletePermanent($id){
        $product = Product::withTrashed()->findOrFail($id);

        if (!$product->trashed()) {
            return redirect()->route('products.trash')->with('status', 'Product is not in trash')->with('status_type', 'alert');
        } else {
            $product->categories()->detach();
            $product->forceDelete();

            return redirect()->route('products.trash')->with('status', 'Product permanently deleted');
        }
        
    }
}
