<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Like;

class LikesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($post)
    {
        $likes = DB::select('SELECT * FROM likes WHERE (post_id = :post)', ['post' => $post]);

        return count($likes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_id)
    {
        $likes = DB::select('SELECT * FROM likes WHERE (user_id = 1 AND post_id = :post)', ['post' => $post]);
        if (!count($likes)) {
            $like = new Like();
            $like->user_id = "1";
            $like->post_id = $post_id;

            $like->save();
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($post)
    {
        $likes = DB::select('SELECT * FROM likes WHERE (user_id = 1 AND post_id = :post)', ['post' => $post]);

        return count($likes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        // $post = Post::findOrFail($request->id);
        // $post->description = $request->description;

        // $post->save();
        // return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // $post = Post::destroy($request->id);

        // return $post;
    }
}
