<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Http\Requests;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use Validator, Response;
use Illuminate\Support\Facades\Input;


class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('id','DESC')->paginate(10);
        return view('index', compact('articles'));
    }
    public function store(StoreRequest $request)
    {
        // $rules = array (
        //         'title' => 'required' 
        // );
        // $validator = Validator::make ( Input::all (), $rules );
        // if ($validator->fails ())
        //     return Response::json ( array (
                    
        //             'errors' => $validator->getMessageBag ()->toArray () 
        //     ) );

        // else {

            $articles = new Article();
            $articles->title = $request->title;
            $articles->description = $request->description;
            $articles->save();
            return response ()->json ( $articles );
        // }
    }

    public function show($id)
    {
        $article = Article::find($id);
        return view('show',compact('article'));
    }

    public function update(Request $request)
    {
        $articles = Article::findOrFail($request->id);
        $articles->title = $request->title;
        $articles->description = $request->description;
        $articles->save();
        return response ()->json ( $articles );
    }

    public function destroy(Request $request)
    {
        $articles = Article::find($request->id);
        $articles->delete();
        return response ()->json ( $articles );
    }
}