<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

class AuthLogin extends Controller
{
    protected $userService;

    public function __construct(UserService $userService, OrderService $orderService)
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:5', 
        ]);

        $user = $this->userService->authenticateUser($request->username, $request->password);

        if ($user) {
            if ($user->usertype == 'customer') {
                return redirect()->route('home');
            } else {
                return redirect()->route('admin');
            }
        }

        return redirect()->back()->withErrors(['username' => 'Username atau password salah']);
    }


}