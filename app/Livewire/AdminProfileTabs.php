<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminProfileTabs extends Component
{
    public $tab = 'personal_details';
    public $name, $email, $username, $bio;
    public $current_password, $new_password, $new_password_confirmation;
    public $facebook, $x, $linkedin, $instagram, $github, $whatsapp, $youtube;

    public function mount()
    {
        $admin = Auth::user();
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->username = $admin->username;
        $this->bio = $admin->bio;

        if ($admin->socialLinks) {
            $this->facebook = $admin->socialLinks->facebook;
            $this->x = $admin->socialLinks->x;
            $this->linkedin = $admin->socialLinks->linkedin;
            $this->instagram = $admin->socialLinks->instagram;
            $this->github = $admin->socialLinks->github;
            $this->whatsapp = $admin->socialLinks->whatsapp;
            $this->youtube = $admin->socialLinks->youtube;
        }
    }

    public function updateProfileInfo()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.Auth::id(),
            'username' => 'required|min:3|unique:users,username,'.Auth::id(),
        ]);

        $admin = User::find(Auth::id());
        $admin->name = $this->name;
        $admin->email = $this->email;
        $admin->username = $this->username;
        $admin->bio = $this->bio;
        $admin->save();

        $this->dispatch('updateAdminProfileHeader');
        
        $this->dispatch('showToast', [
            'message' => 'Your profile info has been updated successfully.',
            'type' => 'success'
        ]);
    }

    public function changePassword()
    {
        $this->validate([
            'current_password' => [
                'required', function($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        return $fail('Incorrect current password.');
                    }
                }
            ],
            'new_password' => 'required|min:5|max:25|confirmed',
        ]);

        $admin = User::find(Auth::id());
        $admin->password = Hash::make($this->new_password);
        $admin->save();

        $this->dispatch('showToast', [
            'message' => 'Your password has been changed successfully.',
            'type' => 'success'
        ]);

        $this->current_password = $this->new_password = $this->new_password_confirmation = null;
    }

    public function updateSocialLinks()
    {
        $admin = Auth::user();
        
        $admin->socialLinks()->updateOrCreate(
            ['user_id' => $admin->id],
            [
                'facebook' => $this->facebook,
                'x' => $this->x,
                'linkedin' => $this->linkedin,
                'instagram' => $this->instagram,
                'github' => $this->github,
                'whatsapp' => $this->whatsapp,
                'youtube' => $this->youtube,
            ]
        );

        $this->dispatch('updateAdminProfileHeader');
        
        $this->dispatch('showToast', [
            'message' => 'Your social links have been updated successfully.',
            'type' => 'success'
        ]);
    }

    public function selectTab($tab)
    {
        $this->tab = $tab;
    }

    public function render()
    {
        return view('livewire.admin-profile-tabs');
    }
}
