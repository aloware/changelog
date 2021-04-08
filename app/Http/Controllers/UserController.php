<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\User;
use App\Notifications\UserAdded;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    public function index()
    {
        return view('team.index')->with('user', Auth::user());
    }

    /**
     *  * @OA\Get(
     *     path="/api/users",
     *     summary="get users list",
     *     @OA\Response(
     *          response="200",
     *          description="success"
     *     )
     * )
     * @return JsonResponse
     */
    public function getLists(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        return response()->json(new UserCollection($user->teammates()));
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

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unable to find user.']);
        }

        if (\auth()->user()->can('update', $user)) {
            try {
                $user->first_name = $request->get('first_name');
                $user->last_name = $request->get('last_name');
                $user->email = $request->get('email');

                if ($request->has('password') && $request->get('password') === $request->get('password_confirmation')) {
                    $user->password = Hash::make($request->get('password'));
                }

                $user->save();
                return response()->json(['status' => 'success', 'message' => 'User profile has been successfully updated.']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => 'Error while updating user profile.']);
            }
        } else {
            return $this->handleUnauthorizedJsonResponse();
        }
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
        $user = User::byUuid($uuid);

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
        $user = User::byUuid($uuid);

        $user->password = Hash::make($request->get('password'));
        $user->email_verified_at = Carbon::now();
        $user->save();

        $guard = Auth::guard();
        $guard->login($user);

        return redirect()->route('home');
    }

    public function sendInvitationLink($id): \Illuminate\Http\JsonResponse
    {
        $user = User::find($id);

        try {
            $user->notify(new UserAdded($user));
            $response = ['status' => 'success', 'message' => 'Invitation link has been successfully sent.'];
        } catch (\Exception $e) {
            $response = ['status' => 'error', 'message' => 'An error was encountered while sending the invitation link.'];
        }

        return response()->json($response);
    }

    public function profile()
    {
        return view('user.profile')->with('user', Auth::user());
    }

    public function uploadAvatar(Request $request, $uuid): \Illuminate\Http\JsonResponse
    {
        $user = User::byUuid($uuid);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Uuid::uuid1().'.'.$file->extension();

            $user->avatar = $filename;
            $user->save();

            $request->file('file')->storeAs($user->uuid . '/avatar', $filename, 'public');
            return response()->json(['url' => url('/api/user/'. $user->uuid .'/avatar?filename='.$filename)]);
        }

        return response()->json(['status' => 'error', 'message' => 'No file found.']);
    }
}
