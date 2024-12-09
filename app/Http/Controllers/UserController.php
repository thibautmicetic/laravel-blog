<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    private String $emptyContent = "emptyContent";

    public function index()
    {
        // On récupère l'utilisateur connecté.
        $user = Auth::user();

        $articles = Article::where('user_id', $user->id)
            ->where('draft', 0)
            ->paginate(5);


        // On retourne la vue.
        return view('dashboard', [
            'articles' => $articles
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('articles.create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        // On récupère les données du formulaire
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        if(!$validated) {
            return redirect()->route('articles.create');
        }

        $data = $request->only(['title', 'content', 'categories', 'draft']);

        // Créateur de l'article (auteur)
        $data['user_id'] = Auth::user()->id;

        // Gestion du draft
        $data['draft'] = isset($data['draft']) ? 1 : 0;

        // On crée l'article
        $article = Article::create($data); // $Article est l'objet article nouvellement créé

        // Exemple pour ajouter des catégories à l'article en venant du formulaire
        $article->categories()->sync($request->input('categories'));

        // Exemple pour ajouter la catégorie 1 à l'article
        // $article->categories()->sync(1);

        // Exemple pour ajouter des catégories à l'article
        // $article->categories()->sync([1, 2, 3]);

        // On redirige l'utilisateur vers la liste des articles
        return redirect()->route('dashboard')->with('insertSuccess', 'Article créé !');
    }

    public function edit(Article $article)
    {
        // On vérifie que l'utilisateur est bien le créateur de l'article
        if ($article->user_id !== Auth::user()->id) {
            return redirect()->route('dashboard')->with('error', 'Vous ne pouvez pas modifier cet article !');
        }

        $categories = Category::all();

        // On retourne la vue avec l'article
        return view('articles.edit', [
            'article' => $article,
            'categories' => $categories,
        ]);
    }

    public function update(Article $article, Request $request)
    {
        // On vérifie que l'utilisateur est bien le créateur de l'article
        if ($article->user_id !== Auth::user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        if(!$validated) {
            return redirect()->route('articles.create');
        }

        // On récupère les données du formulaire
        $data = $request->only(['title', 'content', 'draft']);

        // Gestion du draft
        $data['draft'] = isset($data['draft']) ? 1 : 0;

        // On met à jour l'article
        $article->update($data);

        $article->categories()->sync($request->input('categories'));

        // On redirige l'utilisateur vers la liste des articles (avec un flash)
        return redirect()->route('dashboard')->with('updateSuccess', 'Article mis à jour !');
    }

    public function remove(Request $request, Article $article) {
        // On vérifie que l'utilisateur est bien le créateur de l'article
        if ($article->user_id !== Auth::user()->id) {
            return redirect()->route('dashboard')->with('error', 'Vous ne pouvez pas supprimer cet article !');
        }
        $article->delete();

        return redirect()->route('dashboard')->with('deleteSuccess', 'Article supprimé !');
    }

    public function like(Article $article) {
        $article->likes++;
        $article->save();

        return redirect()->route('public.show', [$article->user_id, $article->id]);
    }
}
