<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ArticleController extends Controller implements HasMiddleware
{
    //
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view articles', only:['index']),
            new Middleware('permission:edit articles', only:['edit']),
            new Middleware('permission:create articles', only:['create']),
            new Middleware('permission:delete articles', only:['destroy']),
        ];
    }
    public function index()
    {
        $article=Article::orderBy('created_at','DESC')->paginate(10);
        return view('articles.index',[
            'article'=>$article
        ]);
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|unique:articles|min:3',
            'text' => 'required',
            'author' => 'required'
        ]);
        if($validator->passes()){
            $new = new Article();
            $new->title=$request->title;
            $new->text =$request->text;
            $new->author= $request->author;
            $new->save();
            
            return redirect()->route('article.index')->with('success','Article Added Successfully');
        }else{
            return redirect()->route('article.create')->withInput()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $article = Article::findorfail($id);
        return view('articles.edit',[
            'article' => $article
        ]);
    }

    public function update(Request $request ,$id)
    {
        $new = Article::findorfail($id);
        $validator = Validator::make($request->all(),[
            'title' => 'required|min:3',
            'text' => 'required',
            'author' => 'required'
        ]);
        if($validator->passes()){
            $new->title=$request->title;
            $new->text =$request->text;
            $new->author= $request->author;
            $new->save();
            
            return redirect()->route('article.index')->with('success','Article Updated Successfully');
        }else{
            return redirect()->route('article.edit')->withInput()->withErrors($validator);
        }
    }

    public function destroy(Request $request)
    {
        $id=$request->id;
        $article=Article::find($id);
        if($article ==null){
            session()->flash('error','Article not found');
            return response()->json([
                'status'=>false
            ]);
        }
        $article->delete();
        session()->flash('success','Article deleted found');
        return response()->json([
            'status'=>true
        ]);
    }


}
