<?php

namespace App\Http\Controllers;

use App\Product;
use App\Group;
use App\Restaurant;
use App\Helpers\AppHelper;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Restaurant $restaurant
     * @return View
     * @throws AuthorizationException
     */
    public function index(Restaurant $restaurant)
    {
        $this->authorize('edit-restaurant', $restaurant);

        return view('pages.restaurant.product.index', [
            'restaurant' => $restaurant,
            'products' => $restaurant->products()->with('group')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Restaurant $restaurant
     * @return View
     * @throws AuthorizationException
     */
    public function create(Restaurant $restaurant)
    {
        $this->authorize('edit-restaurant', $restaurant);

        return view('pages.restaurant.product.create', [
            'restaurant' => $restaurant,
            'groups' => $restaurant->groups()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Restaurant $restaurant
     * @return Application|RedirectResponse|Response|Redirector
     * @throws AuthorizationException
     */
    public function store(Request $request, Restaurant $restaurant)
    {
        $this->authorize('edit-restaurant', $restaurant);

        // Validate
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB FILE SIZE LIMIT
            'price' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0|max:100',
            'available' => 'nullable|boolean',
            'group' => 'nullable|string',
        ]);

        $product = new Product([
            'name' => request('name'),
            'description' => request('description'),
            'price' => request('price'),
            'discount' => request('discount'),
            'available' => $request->has('available'),
        ]);

        $product->image_path = 'placeholder.png';
        if ($request->hasFile('file')) {
            // Upload the image to database and update the image_path in the database
            $product->image_path = AppHelper::uploadImage($request);
        }

        $product->group()->associate(Group::where('name', request('group'))->first());
        $product->restaurant()->associate($restaurant);
        $product->save();

        return redirect(route('restaurant.product.index', $restaurant))->with('success', 'Product Created');
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return Response|void
     */
    public function show(Product $product)
    {
        return abort(404); // We might need this later who knows?
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Restaurant $restaurant
     * @param Product $product
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Restaurant $restaurant, Product $product)
    {
        $this->authorize('edit-restaurant', $restaurant);

        return view('pages.restaurant.product.edit', [
            'restaurant' => $restaurant,
            'product' => $product,
            'groups' => $restaurant->groups()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Restaurant $restaurant
     * @param Product $product
     * @return Application|RedirectResponse|Response|Redirector
     * @throws AuthorizationException
     */
    public function update(Request $request, Restaurant $restaurant, Product $product)
    {
        $this->authorize('edit-restaurant', $restaurant);

        // Validate
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'delete_image' => 'nullable|boolean',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB FILE SIZE LIMIT
            'price' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0|max:100',
            'available' => 'nullable|boolean',
            'group' => 'nullable|string',
        ]);

        // Compare the products first


        if (!($product->name == request('name') && $product->price == request('price') && $product->discount == request('discount'))) {
            // WE need to backup the old copy
            $product->deleted = true;
            $product->save();

            $newProduct = new Product([
                'name' => request('name'),
                'price' => request('price'),
                'discount' => request('discount'),
            ]);
            $newProduct->image_path = $product->image_path;

            // SWAP
            $product = $newProduct;
        }

        $product->description = request('description');
        $product->available = $request->has('available');
        $product->group()->associate(Group::where('name', request('group'))->first());
        $product->restaurant()->associate($restaurant);

        if ($request->has('delete_image') || $request->hasFile('file')) {
            // Delete the old file
            if ($product->image_path !== 'placeholder.png') {
                File::delete('storage/images/' . $product->image_path);
            }

            $request->has('delete_image') ? $product->image_path = 'placeholder.png' : $product->image_path = AppHelper::uploadImage($request);
        }

        $product->save();

        return redirect(route('restaurant.product.index', $restaurant))->with('success', 'Product Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Restaurant $restaurant
     * @param Product $product
     * @return Application|RedirectResponse|Response|Redirector
     * @throws AuthorizationException
     */
    public function destroy(Restaurant $restaurant, Product $product)
    {
        $this->authorize('edit-restaurant', $restaurant);

        $product->deleted = true;
        $product->save();

        return redirect(route('restaurant.product.index', $restaurant))->with('success', 'Product Deleted');
    }
}
