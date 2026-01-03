<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function create()
    {
        // Use local file if exists, otherwise use a default Lottie animation URL
        // You can replace the URL with your own Lottie animation from LottieFiles
        $lottiePath = file_exists(public_path('storage/animations/login.json'))
            ? asset('storage/animations/login.json')
            : 'https://lottie.host/embed/your-animation-id.json';

        return view('auth.login', compact('lottiePath'));
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'min:6'],
        ]);

        $user = User::where('username', $credentials['username'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            return redirect()->intended('/dashboard')->with('success', 'مرحباً بك! تم تسجيل الدخول بنجاح');
        }

        return back()->withErrors([
            'username' => 'اسم المستخدم أو كلمة المرور غير صحيحة. يرجى المحاولة مرة أخرى.',
        ])->onlyInput('username');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
