<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminProfileHeader extends Component
{
    public $admin;

    protected $listeners = [
        'updateAdminProfileHeader' => '$refresh'
    ];

    public function mount()
    {
        $this->admin = Auth::user();
    }

    public function render()
    {
        return view('livewire.admin-profile-header');
    }
}
