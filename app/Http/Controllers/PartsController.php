<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Storage;

class PartsController extends Controller implements HasMiddleware
{
    //
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view parts', only:['index']),
            new Middleware('permission:edit parts', only:['edit']),
            new Middleware('permission:create parts', only:['create']),
            new Middleware('permission:delete parts', only:['destroy']),
        ];
    }
    public function index()
    {
        $part=Part::orderBy('created_at','DESC')->get();
        return view('parts.index',[
            'part'=>$part
        ]);
    }

    public function create()
    {
        return view('parts.create');
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
            $new = new Part();
            $new->name=$request->name;
            $new->mrp =$request->mrp;
            $new->price= $request->price;
            $new->qty= $request->qty;

            // if($request->hasfile('image'))
            // {
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time().'.'.$extenstion;
                $file->storeAs('uploads/parts/', $filename);
                $new->image = $filename;
            // }
    

            $new->save();
            
            return redirect()->route('part.index')->with('success','Part Added Successfully');
        }else{
            return redirect()->route('part.create')->withInput()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $part = Part::findorfail($id);
        return view('parts.edit',[
            'part' => $part
        ]);
    }

    public function update(Request $request ,$id)
    {
        $new = Part::findorfail($id);
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:products,name,'.$id.',id|min:3',
            // 'image' => 'required',
            'mrp' => 'required',
            'price' => 'required',
            'qty' => 'required'
        ]);
        if($validator->passes()){
            // $new = new Part();
            $new->name=$request->name;
            $new->mrp =$request->mrp;
            $new->price= $request->price;
            $new->qty= $request->qty;

            if($request->hasfile('image'))
            {
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time().'.'.$extenstion;
                $file->storeAs('uploads/parts/', $filename);
                $new->image = $filename;
            }
    

            $new->save();
            
            return redirect()->route('part.index')->with('success','Part Updated Successfully');
        }else{
            return redirect()->route('part.create')->withInput()->withErrors($validator);
        }
    }

    public function destroy(Request $request)
    {
        $id=$request->id;
        $article=Part::find($id);
        if($article ==null){
            session()->flash('error','Part not found');
            return response()->json([
                'status'=>false
            ]);
        }
        $article->delete();
        session()->flash('success','Part deleted found');
        return response()->json([
            'status'=>true
        ]);
    }

}
