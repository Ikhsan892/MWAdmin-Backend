<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function confirmed(Request $request)
    {
        $user = Auth::user();
        if ($user->can('update', $user)) {
            $update = User::where('name', $request->name)->update([
                'confirmed' => 1,
                'updated_at' => Carbon::now()
            ]);
            if ($update) {
                return response()->json([
                    'success' => true,
                    'message' => 'User has been confirmed for member'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User cannot be confirmed cause some trouble or check spelling name'
                ], 203);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You are not admin'
            ], 403);
        }
    }
    public function user_detail(Request $request)
    {
        $user = Auth::user();
        $response = [
            'user' => $user
        ];
        return response()->json($response, 200);
    }
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'success'   => false,
                'severity' => 'error',
                'message' => 'Email atau Password Salah'
            ], 227);
        }

        $token = $user->createToken($user->firstName)->plainTextToken;
        $response = [
            'severity'  => 'success',
            'success'   => true,
            'user'      => $user,
            'token'     => $token
        ];

        return response()->json($response, 201);
    }
    public function signup(Request $req)
    {
        $name = User::where('firstName', $req->firstName)
            ->first();
        $email = User::where('email', $req->email)->first();
        if ($name) {
            return response()->json([
                'message' => 'this name already exists'
            ], 417);
        } else {
            if ($email) {
                return response()->json([
                    'message' => 'this email already exists'
                ], 417);
            } else {
                $user = new User;
                $user->role = $req->role;
                $user->confirmed = 0;
                $user->alamat = $req->alamat;
                $user->no_telpon = $req->no_telpon;
                $user->ttl = $req->ttl;
                $user->jabatan = $req->jabatan;
                $user->profile_image = $req->profile_image;
                $user->firstName = $req->firstName;
                $user->lastName = $req->lastName;
                $user->email = $req->email;
                $user->password = Hash::make($req->password);
                try {
                    if ($user->save()) {
                        $token = $user->createToken($req->firstName)->plainTextToken;
                        return response()->json(
                            [
                                'message' => 'success',
                                'success' => $user,
                                'token' => $token,
                            ],
                            200
                        );
                    }
                } catch (Throwable $e) {
                    return response()->json($e->getMessage(), 500);
                }
            }
        }
    }
    public function logout(Request $request)
    {
        if ($request->user()->currentAccessToken()->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'You Have Been Logout'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Something Wrong When Logout'
            ], 500);
        }
    }
    public function update(Request $request, $name)
    {
        $user = Auth::user();
        if ($user->can('update', $user)) {
            $update = User::where('name', $name)->update(array_merge($request->all(), ['updated_at' => Carbon::now()]));
            if ($update) {
                return response()->json([
                    'success' => true,
                    'message' => $name . ' has been updated'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error while updating, try again'
                ], 400);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You are not admin'
            ], 403);
        }
    }
    public function checkConfirm()
    {
        $user = Auth::user();
        $check = User::where('name', $user->name)->get('confirmed');
        if ($check[0]->confirmed === 1) {
            return response()->json(['success' => true, "message" => 'Confirmed', 'user' => $user], 201);
        } else {
            return response()->json(['success' => false, "message" => 'Unconfirmed', 'user' => $user], 201);
        }
    }
}
