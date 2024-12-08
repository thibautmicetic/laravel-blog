<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index() {
        $users = User::paginate(5);
        $articles = Article::orderBy('likes', 'desc')->take(5)->get();
        return view('welcome', [
            'users' => $users,
            'articles' => $articles,
        ]);
    }
}
