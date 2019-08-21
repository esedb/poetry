<?php

namespace App\Http\Controllers;

use App\Article;
use App\User;
use Illuminate\Http\Request;
use Auth;
use DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Request $request)
    {
        if(!Auth::check()){
            redirect('/login');

        }
    }

    public function index()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'poem' => 'required',
            'title' => 'required'
        ]);

        $article = new Article();
        $article->title  = $request->input('article');
        $article->poem  = $request->input('poem');
        $article->description = $request->input('description');
        $article->user_id = $request->session()->get('user_id');
        $article->save();

        return View::make('article.successfull', $article);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);

        return View::make("article", $article);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article, Request $request)
    {
        $article->user_id = Auth::id() != null ? Auth::user()->id: 1;
        $article->poem = $request->input('poem');
        $article->title = $request->input('title');
        $article->update();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
       $article->update($request->all());
        return $article;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
    }

    public function testUser(){
        $user = User::find(1);
        return  view('welcome')->with('user', $user);
    }

    public function getRecentArticles(){
        $users = DB::table('articles')->select('*')
        ->orderBy('created_at', 'DESC')->take(10)->get();
        return response()->json($users);


    }

}

