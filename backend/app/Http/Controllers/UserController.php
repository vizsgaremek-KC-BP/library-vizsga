<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'edu_id' => 'required|string|unique:users|regex:/^7\d{10}$/',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/'
            ],
        ], [
            'edu_id.regex' => __('messages.edu_id_format'),
            'email.email' => __('messages.email_format'),
            'password.regex' => __('messages.password_strength'),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'edu_id' => $request->edu_id,
            'password' => Hash::make($request->password),
            'status' => 'active',
        ]);

        return response()->json(['message' => __('messages.user_created'), 'user' => $user], 201);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => __('messages.user_not_found')], 404);
        }

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => __('messages.user_not_found')], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'edu_id' => 'sometimes|string|unique:users|regex:/^7\d{10}$/',
            'password' => [
                'sometimes',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/'
            ],
            'role' => 'sometimes|string|in:admin,student',
        ], [
            'edu_id.regex' => __('messages.edu_id_format'),
            'email.email' => __('messages.email_format'),
            'password.regex' => __('messages.password_strength'),
        ]);

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'edu_id' => $request->edu_id ?? $user->edu_id,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role ?? $user->role,
        ]);

        return response()->json($user);
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => __('messages.user_not_found')], 404);
        }

        if ($user->role === 'admin' && $request->status === 'inactive') {
            return response()->json(['message' => __('messages.cannot_deactivate_admin')], 403);
        }

        $request->validate([
            'status' => 'required|in:active,inactive',
        ], [
            'status.in' => __('messages.invalid_status')
        ]);

        $user->status = $request->status;
        $user->save();

        return response()->json([
            'message' => __('messages.user_status_updated'),
            'user' => $user
        ]);
    }
}
