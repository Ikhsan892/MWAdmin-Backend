<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function get_token(Request $request)
    {
        $user = User::find(1);

        $token = $user->createToken('token-name');
        return response()->json([
            'token' => $token->plainTextToken
        ]);
    }
    public function listuser(Request $request)
    {
        $user = User::find(1);
        if (FacadesGate::check('isIkhsan', $user)) {
            return response()->json(
                [
                    'message' => 'ok si dokter itu boleh lewat',
                    'current_user' => Auth::user()
                ]
            );
        } else {
            return response('unauthorized', 401);
        }
    }
    public function logout()
    {
        $user = Auth::user();
    }
    public function loginpasswordgrant(Request $request)
    {
        //$http = new Client;
        // $response = Http::post('http://localhost:8000/oauth/token', [
        //     'grant_type' => 'password',
        //     'client_id' => '5',
        //     'client_secret' => 'ONQkeFKo9sg3AJDZ8qAoNhoXqG0EOoLlMvi8jTCQ',
        //     'username' => 'mullrich@example.com',
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        //     'scope' => '',
        // ]);

        // return response()->json($response->getBody(), 200);
    }
}
