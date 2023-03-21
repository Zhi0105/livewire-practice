<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class practiceController extends Controller
{
    public function show()
    {

        // $comments = Comment::all();
        // return view('practice', compact('comments'));
        //   <livewire:comment :initialComments="$comments" /> // props of livewire component

        return view('practice');
    }
}
