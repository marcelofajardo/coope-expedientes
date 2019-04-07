<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anexo;
use App\Comment;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{

      public function miscomentarios()
      {
            $comentarios = Comment::where('user_id', Auth::user()->id)->get();
            return view('comments.index', [
              'comentarios' => $comentarios,
              'action'=>'index'
            ]);
      }
      public function getComments($anexo)
      {
            return Comment::where('anexo_id', $anexo)->get();
      }
      public function show(Comment $comment)
      {
            return view('comments.show', [
            // 'anexo'    => $anexo,
             'comment'  => $comment
            ]);
      }

      public function delete(Comment $comment)
      {
            if ($comment->delete())
            {
                  return redirect()->route('comment.miscomentarios')->with('success', 'Comentario eliminado satisfactoriamente.');
            }else{
                  return redirect()->route('comment.miscomentarios')->with('danger', 'Ocurrió un error al intentar borrar este comentario.');
            }

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
