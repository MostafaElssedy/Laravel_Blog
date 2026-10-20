<?php

namespace App\Livewire;

use Livewire\Component;

class AdminHeaderProfileInfo extends Component
{
    protected $listeners = [
        'updateAdminProfileHeader' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.admin-header-profile-info');
    }
}
