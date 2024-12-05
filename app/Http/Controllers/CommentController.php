<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Article $article) {

        if(!Auth::check()) {
            return redirect()->route('login');
        }

        // On récupère les données du formulaire
        $validated = $request->validate([
            'comment' => 'required'
        ]);

        if(!$validated) {
            return redirect()->route('public.show', [Auth::user()->id, $article->id]);
        }

        $data = $request->only(['comment']);

        // Créateur de l'article (auteur)
        $content = $data['comment'];

        Comment::create([
            'content' => $content,
            'article_id' => $article->id,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('public.show', [Auth::user()->id, $article->id])->with('successCreateComment', 'Le commentaire a été créé !');
    }
}
