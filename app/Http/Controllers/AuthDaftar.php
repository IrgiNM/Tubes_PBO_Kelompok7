<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class AuthDaftar extends Controller
{
    protected $userService;

    public function __construct(UserService $userService, OrderService $orderService)
    {
        $this->userService = $userService;
    }

    public function daftar(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ]);

        $user = $this->userService->registerUser($request->all());
        
        return redirect()->route('home');
    }
}