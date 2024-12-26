<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Storage;

class ProductController extends Controller implements HasMiddleware
{
    //
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view products', only:['index']),
            new Middleware('permission:edit products', only:['edit']),
            new Middleware('permission:create products', only:['create']),
            new Middleware('permission:delete products', only:['destroy']),
        ];
    }
    public function index()
    {
        $product=Product::orderBy('created_at','DESC')->paginate(10);
        return view('products.index',[
            'product'=>$product
        ]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:products|min:3',
            'image' => 'required|mimes:jpg,png,webp,jpeg',
            'mrp' => 'required',
            'price' => 'required',
            'qty' => 'required'
        ]);
        if($validator->passes()){
            $new = new Product();
            $new->name=$request->name;
            $new->mrp =$request->mrp;
            $new->price= $request->price;
            $new->qty= $request->qty;

            // if($request->hasfile('image'))
            // {
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time().'.'.$extenstion;
                $file->storeAs('uploads/products/', $filename);
                $new->image = $filename;
            // }
    

            $new->save();
            
            return redirect()->route('product.index')->with('success','Product Added Successfully');
        }else{
            return redirect()->route('product.create')->withInput()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $product = Product::findorfail($id);
        return view('products.edit',[
            'product' => $product
        ]);
    }

    public function update(Request $request ,$id)
    {
        $new = Product::findorfail($id);
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:products,name,'.$id.',id|min:3',
            // 'image' => 'required',
            'mrp' => 'required',
            'price' => 'required',
            'qty' => 'required'
        ]);
        if($validator->passes()){
            // $new = new Product();
            $new->name=$request->name;
            $new->mrp =$request->mrp;
            $new->price= $request->price;
            $new->qty= $request->qty;

            if($request->hasfile('image'))
            {
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time().'.'.$extenstion;
                $file->storeAs('uploads/products/', $filename);
                $new->image = $filename;
            }
    

            $new->save();
            
            return redirect()->route('product.index')->with('success','Product Added Successfully');
        }else{
            return redirect()->route('product.create')->withInput()->withErrors($validator);
        }
    }

    public function destroy(Request $request)
    {
        $id=$request->id;
        $article=Product::find($id);
        if($article ==null){
            session()->flash('error','Product not found');
            return response()->json([
                'status'=>false
            ]);
        }
        $article->delete();
        session()->flash('success','Product deleted found');
        return response()->json([
            'status'=>true
        ]);
    }


}
