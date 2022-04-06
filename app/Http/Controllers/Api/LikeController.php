<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Like;
// use App\Models\User;

class LikeController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($post_id)
    {
        // Obtengo el id del usuario autenticado
        $user_id = auth()->user()->id;
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
            $like->user_id = $user_id;
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
        $user_id = auth()->user()->id;
        // Obtengo los registros de los likes del usuario autenticado
        $likes = DB::select('SELECT * FROM likes 
                            WHERE (user_id = :user AND post_id = :post)', 
                            ['post' => $post_id, 'user' => $user_id]);

        return count($likes);
    }
}
