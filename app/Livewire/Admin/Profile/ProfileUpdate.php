<?php

namespace App\Livewire\Admin\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Admin;

class ProfileUpdate extends Component
{
    public $name;
    public $email;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount()
    {
        $user = auth('admin')->user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admins')->ignore(auth('admin')->id())],
            'current_password' => ['nullable', 'required_with:new_password', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function updateProfile()
    {
        $this->validate();

        $user = Admin::find(auth('admin')->id());

        // Validasi password saat ini jika ada percobaan ubah password
        if (!empty($this->new_password)) {
            if (!Hash::check($this->current_password, $user->password)) {
                $this->addError('current_password', 'Kata sandi saat ini tidak cocok.');
                return;
            }
            $user->password = Hash::make($this->new_password);
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->save();

        // Reset password fields
        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';

        session()->flash('success', 'Profil berhasil diperbarui!');
        
        // Memaksa refresh pada header agar nama admin berubah jika ada update
        $this->dispatch('profile-updated');
    }

    public function render()
    {
        return view('livewire.admin.profile.profile-update')
            ->layout('components.layouts.app', ['title' => 'Pengaturan Profil Admin']);
    }
}
