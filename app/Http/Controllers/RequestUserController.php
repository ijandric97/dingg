<?php

namespace App\Http\Controllers;

use App\Request as AppRequest;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class RequestUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function index(User $user)
    {
        $this->authorize('edit-user', $user);

        $too_many = $user->requests()->count() > 30;

        $colors = [
            '0' => 'text-danger',
            '1' => 'text-success',
            '2' => 'text-dark',
        ];

        return view('pages.user.request.index', [
            'user' => $user,
            'too_many' => $too_many,
            'colors' => $colors,
            'requests' => $user->requests()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param User $user
     * @return Application|RedirectResponse|Redirector|View
     * @throws AuthorizationException
     */
    public function create(User $user)
    {
        $this->authorize('edit-user', $user);

        if ($user->requests()->count() > 30) {
            return redirect(route('user.request.index', $user))->with('error', 'Too many requests');
        }

        return view('pages.user.request.create', [
            'user' => $user,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Application|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('edit-user', $user);

        if ($user->requests()->count() > 30) {
            return redirect(route('user.request.index', $user))->with('error', 'Too many requests');
        }

        $request->validate([
           'name' => 'required|string',
           'description' => 'required|string',
        ]);

        $req = new AppRequest();
        $req->name = request('name');
        $req->description = request('description');
        $req->user_id = $user->id;
        $req->save();

        return redirect(route('user.request.index', $user))->with('success', 'Request created');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @param AppRequest $appRequest
     * @return Application|RedirectResponse|Redirector|void
     * @throws AuthorizationException
     */
    public function destroy(User $user, AppRequest $request)
    {
        $this->authorize('edit-user', $user);

        if ($request->status < 2) {
            return redirect(route('user.request.index', $user))->with('error', 'Can only remove request that are not yet approved/denied.');
        }

        $request->user()->dissociate();
        $request->delete();

        return redirect(route('user.request.index', $user))->with('success', 'Request removed.');
    }
}
