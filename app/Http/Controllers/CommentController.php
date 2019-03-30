<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anexo;
use App\Comment;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
      public function getComments($anexo)
      {
            return Comment::where('anexo_id', $anexo)->get();
      }
      public function store(Request $request)
      {
            $request['user_id'] = Auth::user()->id;
            $request['username'] = Auth::user()->name;

            $this->validate($request,[
                  'description'     => 'required',
                  'anexo_id'        => 'required',
                  'username'        => 'required'
            ]);

            Comment::create($request->all());
            return;
      }
}
