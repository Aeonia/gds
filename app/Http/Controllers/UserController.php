<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only([
            'edit',
            'update',
            'upgrade'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index', [
            'users' => User::paginate(50)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->can('update', $user)) {
            $user->fill($request->all());
            $user->save();
        }

        return redirect()->route('users.show', [$user]);
    }

    /**
     * Upgrade the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $user_id
     * @return \Illuminate\Http\Response
     */
    public function upgrade(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        if (Auth::user()->can('upgrade', $user)) {
            $user->fill($request->all());
            $user->save();
        }

        return redirect()->route('users.show', [$user]);
    }
}
