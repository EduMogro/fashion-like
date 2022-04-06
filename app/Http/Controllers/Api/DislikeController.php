<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Dislike;
// use App\Models\User;

class DislikeController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_id)
    {
        // Obtengo el id del usuario autenticado
        $user_id = auth()->user()->id;
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
            $dislike->user_id = $user_id;
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
        $user_id = auth()->user()->id;
        // Obtengo los registros de los dislikes del usuario autenticado
        $dislikes = DB::select('SELECT * FROM dislikes 
                            WHERE (user_id = :user AND post_id = :post)', 
                            ['post' => $post_id, 'user' => $user_id]);

        return count($dislikes);
    }
}
