<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Restaurant;
use App\Category;
use App\Comment;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /*$categories = Category::all();
        foreach ($categories as $category) {
            # TODO -> some kind of join on restaurants to get how many restaurants ar ein category just like in wolt...
        }*/

        return view('pages.restaurant.index', ['categories' => null]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $workhours = $restaurant->getWorkhoursTable();
        $comments = $restaurant->comments()->orderBy('updated_at', 'desc')->paginate(10);

        return view('pages.restaurant.show', ['restaurant' => $restaurant, 'workhours' => $workhours, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $restaurant = Restaurant::findOrFail($id);

        $this->authorize('edit-restaurant', $restaurant); // $user is automatically passed

        //dd($restaurant->categories()->get());
        // Prepare categories
        $categories = Category::orderBy('name', 'asc')->get();

        // Prepare workhours
        $workhours = $restaurant->getWorkhoursTable();
        $rest_cats = $restaurant->getCategoriesNameTable(); // Our selected categories

        return view('pages.restaurant.edit', ['restaurant' => $restaurant, 'categories' => $categories, 'rest_cats' => $rest_cats, 'workhours' => $workhours]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request);

        $restaurant = Restaurant::findOrFail($id);

        $this->authorize('edit-restaurant', $restaurant); // $user is automatically passed

        // Validate
        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
            'description' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string|regex:/(\+385)[ ][0-9]{2}[ ][0-9]{6}[0-9]?/',
            'website' => 'required|string|regex:"http[s]?://.*"',
            'category' => 'required|array|min:3|max:3',
            'category.*' => 'nullable|string|distinct',
            'wh_start' => 'required|array|min:7|max:7',
            'wh_start.*' => 'nullable|string|date_format:H:i',
            'wh_end' => 'required|array|min:7|max:7',
            'wh_end.*' => 'nullable|string|date_format:H:i',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB FILE SIZE LIMIT
        ]);

        return redirect(route('restaurant.show', $id))->with('success', 'Restaurant edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function favorite($id)
    {
        // We dont need to authorize, this will simply do nothing for the non-user and return him
        // to restaurant.show
        $restaurant = Restaurant::findOrFail($id);

        $user = auth()->user();

        if ($user) {
            $user->toggleFavorite($restaurant);
        }

        return redirect(route('restaurant.show', $id));
    }

    public function addComment(Request $request, $id)
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

        $comment = new Comment();

        $comment->title = request('title');
        $comment->body = request('body');
        $comment->rating = request('rating');
        $comment->user_id = Auth::user()->id;
        $comment->restaurant_id = Restaurant::findOrFail($id)->id;

        $comment->save();

        return redirect(route('restaurant.show', $id));
    }

    public function deleteComment(Request $request, $restaurant_id, $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);

        $this->authorize('delete-comment', $comment);

        $comment->delete();

        return redirect(route('restaurant.show', $restaurant_id));
    }
}
