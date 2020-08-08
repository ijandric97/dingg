<?php

namespace App\Http\Controllers;

use App\Request as AppRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class RequestController extends Controller
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

        $colors = [
            '0' => 'text-danger',
            '1' => 'text-success',
            '2' => 'text-dark',
        ];

        return view('pages.request.index', [
            'requests' => AppRequest::paginate(50),
            'colors' => $colors,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AppRequest $apprequest
     * @return View
     * @throws AuthorizationException
     */
    public function edit(AppRequest $apprequest)
    {
        $this->authorize('is-admin');

        $colors = [
            '0' => 'bg-danger',
            '1' => 'bg-success',
            '2' => 'bg-dark',
        ];

        return view('pages.request.edit', [
            'request' => $apprequest,
            'colors' => $colors,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param AppRequest $apprequest
     * @return Application|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update(Request $request, AppRequest $apprequest)
    {
        $this->authorize('is-admin');

        $request->validate([
           'status' => 'required|in:1,0'
        ]);

        if ($apprequest->status < 2) {
            return redirect(route('request.index'))->with('error', 'Can only update in progress requests.');
        }

        $apprequest->status = request('status');
        $apprequest->save();

        return redirect(route('request.index'))->with('success', 'Request status modified.');
    }
}
