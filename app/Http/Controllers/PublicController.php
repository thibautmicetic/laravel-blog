<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(User $user)
    {
        // On récupère les articles publiés de l'utilisateur
        $articles = Article::where('user_id', $user->id)->where('draft', 0)->get();

        // On retourne la vue
        return view('public.index', [
            'articles' => $articles,
            'user' => $user
        ]);
    }

    public function show(User $user, Article $article)
    {
        // $user est l'utilisateur de l'article
        // $article est l'article à afficher

        if($article->draft == 1) {
            return redirect()->route('public.index', [$user->id])->with('errorDraft', 'Cet article n\'existe pas !');
        }

        // Je vous laisse faire le code
        return view('public.show', [
            'article' => $article,
            'user' => $user
        ]);
    }
}
