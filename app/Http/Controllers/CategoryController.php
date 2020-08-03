<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;
use App\Category;
use App\Helpers\AppHelper;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('pages.category.index', [
            'categories' => Category::orderBy('name', 'asc')->get() // Case insensitive by default
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('is-admin', auth()->user());

        return view('pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     * @throws AuthorizationException
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

        $category = new Category([
            'name' => request('name'),
            'description' => request('description'),
        ]);

        $category->image_path = 'placeholder.png';
        if ($request->hasFile('file')) {
            // Upload the image to database and update the image_path in the database
            $category->image_path = AppHelper::uploadImage($request);
        }

        $category->save();

        return redirect(route('category.index'))->with('success', 'Category created');
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return Application|Factory|Response|View
     */
    public function show(Category $category)
    {
        return view('pages.category.show', [
            'category' => $category,
            'restaurants' => $category->restaurants()->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Category $category)
    {
        $this->authorize('is-admin', auth()->user());

        return view('pages.category.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return Application|RedirectResponse|Response|Redirector
     * @throws AuthorizationException
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('is-admin', auth()->user()); // Not even sure if we need this, but i will leave it

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
                File::delete('storage/images/' . $category->image_path);
            }

            $request->has('delete_image') ? $category->image_path = 'placeholder.png' : $category->image_path = AppHelper::uploadImage($request);
        }

        $category->save();

        return redirect(route('category.show', $category->id))->with('success', 'Category edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Application|RedirectResponse|Response|Redirector
     * @throws AuthorizationException
     * @throws Exception
     */
    public function destroy(Category $category)
    {
        $this->authorize('is-admin', auth()->user());

        $category->restaurants()->detach(); // Remove the associations with this category in category_restaurant pivot table

        try {
            $category->delete();
        } catch (Exception $e) {
            return redirect(route('category.index'))->with('error', 'Category not deleted');
        }

        return redirect(route('category.index'))->with('success', 'Category deleted');
    }
}
