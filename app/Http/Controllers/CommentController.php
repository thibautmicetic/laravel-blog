<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, int $articleId) {
        // On récupère les données du formulaire
        $data = $request->only(['content']);

        // Créateur de l'article (auteur)
        $content = $data['content'];

        Comment::create([
            'content' => $content,
            'article_id' => $articleId,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('public.index', [Auth::user()->id])->with('successCreateComment', 'Le commentaire a été créé !');
    }
}
