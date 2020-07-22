<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Undocumented function
     *
     * @param \Illuminate\Http\Request  $request
     * @return string
     */
    private function uploadImage($request)
    {
        // Create new Filename to store
        $filenameWithExt = $request->file('file')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('file')->getClientOriginalExtension();
        $filenameToStore = $filename . '_' . time() . '.' . $extension;

        // Resize and store the new file
        $image_resize = Image::make($request->file('file')->getRealPath());
        $image_resize->resize(320, 240);
        $image_resize->save('storage/images/category/' . $filenameToStore);

        return $filenameToStore;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.category.index', ['categories' => Category::orderBy('name', 'asc')->get()]); // Case insensitive by default
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('is-admin', auth()->user());

        return view('pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('is-admin', auth()->user());

        // Validate
        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
            'description' => 'required|string',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB FILE SIZE LIMIT
        ]);

        $category = new Category();
        $category->name = request('name');
        $category->description = request('description');
        $category->image_path = 'placeholder.png';

        // Handle File Upload
        if ($request->hasFile('file')) {
            // Upload the image to database and update the image_path in the database
            $category->image_path = $this->uploadImage($request);
        }

        $category->save();

        return redirect(route('category.index'))->with('status', 'Category created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //dd($category->restaurants);
        return view('pages.category.show', ['category' => Category::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('is-admin', auth()->user());

        return view('pages.category.edit', ['category' => Category::find($id)]);
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
        $this->authorize('is-admin', auth()->user()); // Not even sure if we need this, but i will leave it

        // Validate
        $category = Category::find($id);

        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name,' . $category->id,
            'description' => 'required|string',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB FILE SIZE LIMIT
            'delete_image' => 'nullable|boolean'
        ]);

        $category->name = request('name');
        $category->description = request('description');

        if ($request->has('delete_image') || $request->hasFile('file')) {
            // Delete the old file
            if ($category->image_path !== 'placeholder.png') {
                File::delete('storage/images/category/' . $category->image_path);
            }

            $request->has('delete_image') ? $category->image_path = 'placeholder.png' : $category->image_path = $this->uploadImage($request);
        }

        $category->save();

        return redirect(route('category.index'))->with('status', 'Category edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('is-admin', auth()->user());

        $category = Category::find($id);
        $category->restaurants()->detach(); // Remove the associations with this category in category_restaurant pivot table
        $category->delete();

        return redirect(route('category.index'))->with('status', 'Category deleted');
    }
}
