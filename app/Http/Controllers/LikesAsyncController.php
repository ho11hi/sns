<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LikesAsyncController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $like = new Like;
        $like->user_id = $request->user_id;
        $like->post_id = $request->post_id;
        $like->created_at = Carbon::now();
        $like->updated_at = Carbon::now();
        $like->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($u_id, $p_id)
    {
        Like::where('user_id', $u_id)->where('post_id', $p_id)->delete();
    }
}
