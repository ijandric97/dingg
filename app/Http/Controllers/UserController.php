<?php

namespace App\Http\Controllers;

use App\User;
use App\Helpers\AppHelper;
use App\Request as AppRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('is-admin');

        // Search if get contains ?user field
        $name = request()->input('user');
        if ($name) {
            $users = User::where('name', 'LIKE', '%' . $name . '%')->paginate(50);
        } else {
            $users = User::orderBy('name', 'asc')->paginate(50);
        }

        return view('pages.user.index', [
            'users' => $users,
            'name' => $name,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('edit-user', $user);

        return view('pages.user.show', [
            'user' => $user,
            'favorites' => $user->favorites()->paginate(30),
        ]);
    }

    /**
     * Display the restaurants user owns.
     *
     * @param User $user
     * @throws AuthorizationException
     */
    public function restaurants(User $user)
    {
        $this->authorize('is-restaurant');

        return view('pages.user.restaurants', [
            'user' => $user,
            'restaurants' => $user->ownedRestaurants()->paginate(30),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('edit-user', $user);

        return view('pages.user.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Application|RedirectResponse|Response|Redirector
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('edit-user', $user);

        $request->validate([
            'phone' => 'required|string|regex:/(\+385)[ ][0-9]{2}[ ][0-9]{6}[0-9]?/',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB FILE SIZE LIMIT
            'delete_image' => 'nullable|boolean',
        ]);

        // Picture
        if ($request->has('delete_image') || $request->hasFile('file')) {
            // Delete the old file
            if ($user->image_path !== 'placeholder.png') {
                File::delete('storage/images/' . $user->image_path);
            }

            $request->has('delete_image') ? $user->image_path = 'placeholder.png' : $user->image_path = AppHelper::uploadImage($request);
        }

        $user->phone = request('phone');
        $user->save();

        return redirect(route('user.show', $user))->with('success', 'User Edited');
    }

    /**
     * Edit users role
     *
     * @param Request $request
     * @param User $user
     * @return Application|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function role(Request $request, User $user)
    {
        $this->authorize('is-admin');

        $request->validate([
           'role' => 'required|in:user,restaurant',
        ]);

        if ($user->role != 'admin') {
            $user->role = request('role');
            $user->save();
            return redirect(route('user.show', $user))->with('success', 'Role Edited');
        }

        return redirect(route('user.show', $user))->with('error', 'Can\'t change admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Application|RedirectResponse|Response|Redirector
     * @throws AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('is-admin');

        if ($user->role === 'admin') {
            return redirect(route('user.index', $user))->with('error', 'Can\'t delete admin');
        }

        $user->deleted = true;
        $user->save();

        return redirect(route('user.index'))->with('success', 'User Deleted');
    }
}
