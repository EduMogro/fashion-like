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
        // Obtengo el id del usuario autenticado
        $user_id = 1;
        // Obtengo los registros de los likes del usuario autenticado
        $likes = DB::select('SELECT * FROM likes
                            WHERE (user_id = :user AND post_id = :post)', 
                            ['post' => $post_id, 'user' => $user_id]);
        // Obtengo la cantidad de registros encontrados (si el usuario hizo like o no)
        $count = count($likes);

        if ($count) {
            $likes = DB::select('DELETE FROM likes 
                                WHERE (user_id = :user AND post_id = :post)
                                LIMIT 1', 
                                ['post' => $post_id, 'user' => $user_id]);
            $count = 0;
        } else {
            $like = new Like();
            $like->user_id = "1";
            $like->post_id = $post_id;

            $like->save();
            $count = 1;
        }
        return $count;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($post_id)
    {
        // Obtengo el id del usuario autenticado
        $user_id = 1;
        // Obtengo los registros de los likes del usuario autenticado
        $likes = DB::select('SELECT * FROM likes 
                            WHERE (user_id = :user AND post_id = :post)', 
                            ['post' => $post_id, 'user' => $user_id]);

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
