<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class UserService
{
    public function registerUser($data)
    {
        try {
            $user = new User();
            $user->username = $data['username'];
            $user->usertype = "customer";
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->save();

            // Simpan data pengguna ke file JSON
            $this->storeUserJson($user);

            // Login pengguna setelah berhasil mendaftar
            Auth::login($user);
            
            return $user;
        } catch (Exception $e) {
            Log::error('Failed to register user: ' . $e->getMessage());
            throw new Exception('Unable to register user at this time.');
        }
    }

    public function storeUserJson($user)
    {
        try {
            $userData = $user->toArray();
            $jsonPath = storage_path('app/public/users/users' . $user->id . '.json');

            // Pastikan direktori ada, jika tidak maka buat
            $directory = dirname($jsonPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);  // Membuat direktori jika belum ada
            }

            // Menulis data pengguna ke file JSON
            if (file_put_contents($jsonPath, json_encode($userData, JSON_PRETTY_PRINT)) === false) {
                throw new Exception('Failed to write user data to JSON file.');
            }

            Log::info("User data saved to JSON at: " . $jsonPath);
        } catch (Exception $e) {
            Log::error('Error saving user data to JSON: ' . $e->getMessage());
            throw new Exception('Unable to save user data to JSON file.');
        }
    }

    public function authenticateUser($username, $password)
    {
        try {
            $user = User::where('username', $username)->first();

            if ($user && Hash::check($password, $user->password)) {
                Auth::login($user);
                return $user;
            }

            return null;
        } catch (Exception $e) {
            Log::error('Error authenticating user: ' . $e->getMessage());
            throw new Exception('Unable to authenticate user at this time.');
        }
    }
}
