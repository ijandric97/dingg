<?php

namespace App\Http\Controllers;

use App\Group;
use App\Restaurant;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Restaurant $restaurant)
    {
        $this->authorize('edit-restaurant', $restaurant);

        return view('pages.restaurant.group.index', [
            'restaurant' => $restaurant,
            'groups' => $restaurant->groups()->orderBy('sort_order', 'asc')->get(),
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
            'name' => 'required|array',
            'name.*' => 'required|string',
            'description' => 'required|array',
            'description.*' => 'nullable|string',
            'id' => 'required|array',
            'id.*' => 'nullable|numeric',
        ]);

        // Delete non-existing ones by comparing ids in the request with the id's in the base
        foreach ($restaurant->groups()->get() as $group) { // Delete the ones we are no longer using
            $found = false;

            for ($i=0; $i < count(request('id')); $i++) {
                $id = request('id.'.$i);
                if ($id == $group->id) {
                    $found = true;
                }
            }

            if ($found == false) {
                $group->restaurant()->dissociate();
                $group->products()->update(['group_id' => null]); // We need to manually detach all hasMany
                $group->delete();
            }
        }

        // Create / Edit the rest
        for ($i=0; $i < count(request('id')); $i++) {
            $id = request('id.'.$i);

            if ($id) {
                $group = Group::findOrFail($id)->first();
            } else {
                $group = new Group();
            }

            $group->name = request('name.'.$i);
            $group->description = request('description.'.$i);
            $group->sort_order = $i;
            $group->restaurant()->associate($restaurant);
            $group->save();
        }

        return redirect(route('restaurant.show', $restaurant->id))->with('success', 'Groups edited');
    }
}
