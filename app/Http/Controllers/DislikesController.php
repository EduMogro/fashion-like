<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dislike;

class DislikesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($post)
    {
        $dislikes = DB::select('SELECT * FROM dislikes WHERE (post_id = :post)', ['post' => $post]);

        return count($dislikes);
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
        // Obtengo los registros de los dislikes del usuario autenticado
        $dislikes = DB::select('SELECT * FROM dislikes
                            WHERE (user_id = :user AND post_id = :post)', 
                            ['post' => $post_id, 'user' => $user_id]);
        // Obtengo la cantidad de registros encontrados (si el usuario hizo dislike o no)
        $count = count($dislikes);

        if ($count) {
            $dislikes = DB::select('DELETE FROM dislikes 
                                WHERE (user_id = :user AND post_id = :post)
                                LIMIT 1', 
                                ['post' => $post_id, 'user' => $user_id]);
            $count = 0;
        } else {
            $dislike = new Dislike();
            $dislike->user_id = "1";
            $dislike->post_id = $post_id;

            $dislike->save();
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
        // Obtengo los registros de los dislikes del usuario autenticado
        $dislikes = DB::select('SELECT * FROM dislikes 
                            WHERE (user_id = :user AND post_id = :post)', 
                            ['post' => $post_id, 'user' => $user_id]);

        return count($dislikes);
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
