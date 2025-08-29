<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Setting;

class AdminController extends Controller
{

    public function index()
    {

        return view('admin.index');
    }
    public function invites() {
        return view('admin.invites');
    }
    public function approvals() {
        $articles = Article::where('approved', 0)->get();
        return view('admin.approvals', compact('articles'));
    }
    public function settings() {
        return view('admin.settings');
    }
}
