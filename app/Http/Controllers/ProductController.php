<?php

namespace App\Http\Controllers;

use App\Product;
use App\Group;
use App\Restaurant;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
            'available' => $request->has('available') ? true : false,
        ]);

        if (request('discount') > 0) {
            //TODO fuck me up fam
        }

        $product->image_path = 'placeholder.png';
        if ($request->hasFile('file')) {
            // Upload the image to database and update the image_path in the database
            $product->image_path = $this->uploadImage($request);
        }

        $product->group()->associate(Group::where('name', request('group'))->first());
        $product->restaurant()->associate($restaurant);
        $product->save();

        return redirect(route('restaurant.product.index', $restaurant))->with('success', 'Product Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        abort(404); // We might need this later who knows?
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
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

        $product->name = request('name');
        $product->description = request('description');
        $product->price = request('price');
        $product->discount = request('discount');
        $product->available = $request->has('available') ? true : false;

        if (request('discount') > 0) {
            //TODO fuck me up fam
        }

        if ($request->has('delete_image') || $request->hasFile('file')) {
            // Delete the old file
            if ($product->image_path !== 'placeholder.png') {
                File::delete('storage/images/product/' . $product->image_path);
            }

            $request->has('delete_image') ? $product->image_path = 'placeholder.png' : $product->image_path = $this->uploadImage($request);
        }

        $product->group()->associate(Group::where('name', request('group'))->first());
        $product->restaurant()->associate($restaurant);
        $product->save();

        return redirect(route('restaurant.product.index', $restaurant))->with('success', 'Product Created');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant, Product $product)
    {
        $this->authorize('edit-restaurant', $restaurant);

        $product->deleted = true;
        $product->save();

        return redirect(route('restaurant.product.index', $restaurant))->with('success', 'Product Deleted');
    }

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
        $image_resize->save('storage/images/product/' . $filenameToStore);

        return $filenameToStore;
    }
}
