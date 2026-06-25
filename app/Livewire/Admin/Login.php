<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email;
    public $password;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt(['email' => $this->email, 'password' => $this->password])) {
            // Notifikasi Keamanan: Admin Login
            $loggedInAdmin = Auth::guard('admin')->user();
            $allAdmins = \App\Models\Admin::all();
            foreach ($allAdmins as $adminUser) {
                if ($adminUser->id !== $loggedInAdmin->id) { // Notif ke admin LAIN
                    $adminUser->notify(new \App\Notifications\AdminNotification(
                        'Peringatan Keamanan',
                        "Admin {$loggedInAdmin->name} baru saja login ke sistem.",
                        '#'
                    ));
                }
            }

            return redirect()->to('/admin/dashboard');
        }

        session()->flash('error', 'Email atau Password salah!');
    }

    public function render()
    {
        // Kita arahkan ke folder layout tema Gallery Puan
        return view('livewire.admin.login')->layout('themes.gallerypuan.layouts.raw');
    }
}