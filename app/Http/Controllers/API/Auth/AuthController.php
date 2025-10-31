<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Register a new user and return a JWT token
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|string|in:admin,homeowner,tradesperson', // added role
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Assign role
        $user->assignRole($data['role']);

        $token = auth('api')->login($user);

        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'bearer'
        ], 201);
    }
    /**
     * Login user and return JWT token
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error'=>'Invalid credentials'], 401);
        }

        //  respondWithToken call
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }

    /**
     * Logout user (invalidate token)
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message'=>'Successfully logged out']);
    }
    /**
     * Step 1: Send OTP to user email
     */
    public function sendOtp(Request $request)
    {
        $request->validate(['email'=>'required|email|exists:users,email']);

        $otp = rand(1000, 9999); // 4-digit code

        // Save OTP in password_resets table
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $otp,
                'created_at' => now()
            ]
        );

        // Send OTP via email (optional for testing)
        Mail::raw("Your password reset OTP is: $otp", function($message) use($request){
            $message->to($request->email)
                ->subject('Password Reset OTP');
        });

        // Return OTP in response for testing
        return response()->json([
            'message' => 'OTP sent to your email',
            'otp' => $otp
        ]);
    }
    /**
     * Step 2: Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'otp'=>'required|digits:4'
        ]);

        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$record) {
            return response()->json(['error'=>'Invalid OTP'], 400);
        }

        return response()->json(['message'=>'OTP verified successfully'], 200);
    }
    /**
     * Step 3: Reset Password
     */
    /**
     * Reset Password without OTP
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        // Update password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password successfully updated']);
    }
}
