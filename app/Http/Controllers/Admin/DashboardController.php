<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $artikelCount = Article::count();
        $userCount = User::count();
        return view('welcome', compact('artikelCount', 'userCount'));
    }
}
