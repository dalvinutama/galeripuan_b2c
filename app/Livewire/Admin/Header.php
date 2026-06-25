<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Header extends Component
{
    #[Livewire\Attributes\On('profile-updated')]
    public function refreshHeader()
    {
    }

    public function render()
    {
        return view('livewire.admin.header');
    }
}