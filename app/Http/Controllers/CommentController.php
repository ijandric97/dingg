<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Restaurant $restaurant)
    {
        if (!Auth::check()) {
            abort(403);
        }

        // Validate
        $request->validate([
            'title' => 'required|string|max:250',
            'body' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        $comment = new Comment([
            'title' => request('title'),
            'body' => request('body'),
            'rating' => request('rating'),
        ]);

        $comment->user()->associate($request->user());
        $comment->restaurant_id = $restaurant->id;

        $comment->save();

        return redirect(route('restaurant.show', $restaurant->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant, Comment $comment)
    {
        $this->authorize('delete-comment', $comment);

        $comment->delete();

        return redirect(route('restaurant.show', $restaurant->id));
    }
}
