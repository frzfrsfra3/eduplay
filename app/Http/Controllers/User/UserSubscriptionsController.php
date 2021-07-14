<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserSubscriptions;
use Carbon\Carbon;

class UserSubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $plans = Plan::all();
        return view('users.subscriptions', compact('user' ,'plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * param  \Illuminate\Http\Request  $request
     * return \Illuminate\Http\Response
     */
    public function store(User $user, Request $request)
    {
        $request->validate(
        [
            'plan_id' => 'required',
            'months' => 'required|numeric'
        ]);

        $plan_id = $request->input('plan_id');
        $months = $request->input('months');

        // calculate dates
        $subscribed_at = Carbon::now();
        $expired_at = Carbon::now()->addMonth($months);

        $subscription = new UserSubscriptions;
        $subscription->plan_id = $plan_id;
        $subscription->user_id = $user->id;
        $subscription->subscribed_at = $subscribed_at;
        $subscription->expired_at = $expired_at;
        $subscription->save();

        return redirect(route('subscriptions.index' , ['user' => $user->id]));
    }

    /**
     * Display the specified resource.
     *
     * param  int  $id
     * return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * param  int  $id
     * return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * param  \Illuminate\Http\Request  $request
     * param  int  $id
     * return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * param  int  $id
     * return \Illuminate\Http\Response
     */
    public function destroy(User $user, UserSubscriptions $subscription)
    {
        $subscription->delete();
        return redirect(route('subscriptions.index' , ['user' => $user->id]));
    }
}
