<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\OrderService;
use App\Http\Controllers\AuthLogout;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService, OrderService $orderService)
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        return app(AuthLogin::class)->login($request);
    }

    public function daftar(Request $request)
    {
        return app(AuthDaftar::class)->daftar($request);
    }

    public function logout(Request $request)
    {
        return app(AuthLogout::class)->logout($request);
    }
}