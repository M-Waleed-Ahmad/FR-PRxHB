<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show the registration form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle user registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'type' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
        ]);

        return redirect()->route('login.form')->with('success', 'Registration successful. Please login.');
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle user login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login successful.');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ]);
    }

    // Handle user logout
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            return redirect()->route('login.form')->with('success', 'You have been logged out.');
        } else {
            dd('User is not authenticated.');
            return back()->withErrors(['error' => 'User is not authenticated.']);
        }
    }
    
    // Show dashboard (different views for admin and users)
    public function dashboard()
    {
        $categories = Category::all();
        $user = Auth::user();
        if ($user->type === 'admin') {
            return view('dashboard.admin', ['categories' => $categories]);
        } else {
            return view('dashboard.user', ['categories' => $categories]);
        }
    }
    // Add the following methods for managing users.
public function getUsers()
{
    $users = User::all();
    return response()->json($users);
}

public function getUser($id)
{
    $user = User::findOrFail($id);
    return response()->json($user);
}

public function createUser(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:8',
        'type' => 'required|in:admin,user',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'type' => $request->type,
    ]);

    return response()->json($user);
}

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'type']));

        return response()->json($user);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    public function searchUsers($query)
    {
        try {
            $users = User::where('name', 'like', "%$query%")->get();
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while searching for users'], 500);
        }
    }

}
