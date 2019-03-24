<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anexo;
use App\Comment;

class CommentController extends Controller
{
    public function store(Request $request, Anexo $anexo)
    {
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->parent_id = $request->parent_id;
        $comment->user_id = \auth()->id();

        $anexo->comments()->save($comment);

        return \redirect()->route('anexos.show', $anexo);
    }
}
