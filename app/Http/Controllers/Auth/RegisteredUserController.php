<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\UserRole; // Thêm import UserRole Enum
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage; // Import Storage for handling file uploads

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request including the avatar image
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate avatar image (optional)
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => UserRole::USER->value, // Set default role as user
        ]);

        // Handle avatar upload if file is provided
        if ($request->hasFile('avatar')) {
            // Get the uploaded file
            $avatar = $request->file('avatar');
            // Generate a unique filename
            $filename = uniqid('avatar_') . '.' . $avatar->getClientOriginalExtension();
            // Store the file in the public disk (uploads/avatars)
            $path = $avatar->storeAs('uploads/avatars', $filename, 'public');
            // Save the avatar path to the user model
            $user->avatar_url = $path;
            $user->save();
        }

        // Fire the Registered event
        event(new Registered($user));

        // Log in the user
        Auth::login($user);

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
}
