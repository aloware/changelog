<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Notifications\UserAdded;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    public function index()
    {
        return view('team.index')->with('user', Auth::user());
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = new User();
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');
        $user->password = Hash::make('sample');
        $user->company_id = Auth::user()->company_id;
        $user->save();

        $user->notify(new UserAdded($user));

        return response()->json(['status' => 'success', 'user' => $user]);

    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');
        $user->password = $request->get('password');
        $user->save();
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {

        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unable to find user.']);
        }

        if (\auth()->user()->can('delete', Auth::user(), $user)) {
            $user->delete();
            return response()->json(['status' => 'success', 'message' => 'User has been successfully deleted.']);
        } else {
            return $this->handleUnauthorizedJsonResponse();
        }

    }

    public function setPassword($uuid)
    {
        $user = User::where('uuid', $uuid)->first();

        if (!$user) {
            abort(404);
        }

        if ($user->email_verified_at) {
            return redirect()->route('home');
        }

        return view('auth.passwords.set')->with('user', $user);
    }

    public function updatePassword(Request $request, $uuid): \Illuminate\Http\RedirectResponse
    {
        $user = User::where('uuid', $uuid)->first();

        $user->password = Hash::make($request->get('password'));
        $user->email_verified_at = Carbon::now();
        $user->save();

        $guard = Auth::guard();
        $guard->login($user);

        return redirect()->route('home');
    }
}
