<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller {
    public function register( Request $request ) {
        $data = $request->validate( [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ] );

        User::create( [
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make( $data['password'] ),
        ] );

        return response()->json( ['message' => 'User Created Successfully', 'status' => true] );
    }

    public function login( Request $request ) {
        $data = $request->validate( [
            'email'    => 'required|email',
            'password' => 'required',
        ] );

        $user = User::where( 'email', $data['email'] )->first();

        if ( !$user || !Hash::check( $data['password'], $user->password ) ) {
            return response()->json( ['message' => 'Invalid Credential', 'status' => false] );
        }

        $token = $user->createToken( 'api' )->plainTextToken;
        return response()->json( ['token' => $token, 'status' => true] );
    }

    public function logout( Request $request ) {
        $request->user()->currentAccessToken()->delete();
        return response()->json( ['message' => 'Logout Successfully', 'status' => true] );
    }

    public function profile( Request $request ) {
        $user = $request->user();
        return response()->json( ['user' => $user, 'status' => true] );
    }
}
