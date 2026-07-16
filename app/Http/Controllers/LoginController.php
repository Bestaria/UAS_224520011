<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Membaca data user dari users.json
     */
    private function getUsers()
    {
        $path = storage_path('app/users.json');

        if (!file_exists($path)) {
            return [];
        }

        $data = json_decode(file_get_contents($path), true);

        return is_array($data) ? $data : [];
    }

    /**
     * Halaman Login
     */
    public function index()
    {
        // Jika sudah login
        if (session()->has('login')) {

            if (session('role') == 'admin') {
                return redirect('/dashboard');
            }

            return redirect('/reservasi/create');
        }

        return view('auth.login');
    }

    /**
     * Proses Login
     */
    public function login(Request $request)
    {
        // Validasi
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $users = $this->getUsers();

        if (empty($users)) {
            return back()->with(
                'error',
                'Data user tidak ditemukan.'
            );
        }

        foreach ($users as $user) {

            if (
                trim($request->email) === trim($user['email']) &&
                trim($request->password) === trim($user['password'])
            ) {

                session([
                    'login' => true,
                    'id'    => $user['id'],
                    'nama'  => $user['nama'],
                    'email' => $user['email'],
                    'role'  => $user['role']
                ]);

                if ($user['role'] == 'admin') {

                    return redirect('/dashboard')
                        ->with(
                            'success',
                            'Selamat datang, '.$user['nama']
                        );
                }

                return redirect('/reservasi/create')
                    ->with(
                        'success',
                        'Selamat datang, '.$user['nama']
                    );
            }
        }

        return back()
            ->withInput()
            ->with(
                'error',
                'Email atau Password salah.'
            );
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->flush();

        return redirect('/login')
            ->with(
                'success',
                'Logout berhasil.'
            );
    }
}