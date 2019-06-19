<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anexo;
use App\Comment;
use Illuminate\Support\Facades\DB;
use App\Expediente;
use Mail;
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

            //$comentario = $request->all();
            Comment::create($request->all());
            if($comentario = Comment::create($request->all())){
                  $anexo = Anexo::find($request->anexo_id);
                  $expediente = Expediente::find($anexo->expediente_id);
                  $habilitados = DB::select("
                        SELECT
                        eu.user_id AS id,
                        eu.expediente_id,
                        users.`email`,
                        users.`name` AS usuario
                        FROM
                        expediente_usuarios eu
                        INNER JOIN users ON users.`id` = eu.`user_id`
                        WHERE
                        eu.expediente_id = $expediente->id
                        ");

                  foreach ($habilitados as $hab) {
                        $this->enviarEmailComment1($comentario, $hab, $anexo);
                  }



            }
            return;
      }

      private function enviarEmailComment1($comentario, $hab, $anexo)
      {
            \Mail::Send('emails.notificationComment',['nombre'=>'Nuevo Comentario', 'comentario'=>$comentario, 'hab'=>$hab, 'anexo'=>$anexo],function($message) use ($hab){
                  $message->from('expedientes@desarrollostello.com', 'Expedientes');
                  $message->to($hab->email)->subject('Sistema Expedientes - Nuevo Comentario');
            });
      }

      private function enviarEmailComment($comentario, $email)
      {
            \Mail::Send('emails.notificationComment',['nombre'=>'Nuevo Comentario', 'comentario'=>$comentario],function($message) use ($email){
                  $message->from('expedientes@desarrollostello.com', 'Expedientes');
                  $message->to($email)->subject('Sistema Expedientes - Nuevo Comentario');
            });
      }
}
