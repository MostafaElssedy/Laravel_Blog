<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdminSettings extends Component
{
    use WithFileUploads;

    public $blog_name, $blog_email, $blog_description;
    public $blog_logo, $blog_favicon;
    public $blog_phone, $blog_meta_keywords;
    public $current_logo, $current_favicon;
    public $tab = 'general_info';

    public function selectTab($tab)
    {
        $this->tab = $tab;
    }

    public function mount()
    {
        $settings = GeneralSetting::getSettings();
        if (!$settings) {
            $settings = new GeneralSetting();
            $settings->save();
        }

        $this->blog_name = $settings->blog_name;
        $this->blog_email = $settings->blog_email;
        $this->blog_phone = $settings->blog_phone;
        $this->blog_meta_keywords = $settings->blog_meta_keywords;
        $this->blog_description = $settings->blog_description;
        $this->current_logo = $settings->blog_logo;
        $this->current_favicon = $settings->blog_favicon;
    }

    public function updateSettings()
    {
        $this->validate([
            'blog_name' => 'required|string',
            'blog_email' => 'required|email',
            'blog_phone' => 'nullable|string',
            'blog_meta_keywords' => 'nullable|string',
            'blog_description' => 'nullable|string',
            'blog_logo' => 'nullable|image|max:2048', // Max 2MB
            'blog_favicon' => 'nullable|image|max:1024', // Max 1MB
        ]);

        $settings = GeneralSetting::getSettings();
        if (!$settings) {
            $settings = new GeneralSetting();
        }

        $settings->blog_name = $this->blog_name;
        $settings->blog_email = $this->blog_email;
        $settings->blog_phone = $this->blog_phone;
        $settings->blog_meta_keywords = $this->blog_meta_keywords;
        $settings->blog_description = $this->blog_description;

        $path = public_path('images/settings');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        // Handle Logo Upload
        if ($this->blog_logo) {
            $old_logo = $settings->blog_logo;
            if ($old_logo && File::exists($path . '/' . $old_logo)) {
                File::delete($path . '/' . $old_logo);
            }
            $logo_name = 'LOGO_' . uniqid() . '.' . $this->blog_logo->getClientOriginalExtension();
            File::copy($this->blog_logo->getRealPath(), $path . '/' . $logo_name);
            $settings->blog_logo = $logo_name;
        }

        // Handle Favicon Upload
        if ($this->blog_favicon) {
            $old_favicon = $settings->blog_favicon;
            if ($old_favicon && File::exists($path . '/' . $old_favicon)) {
                File::delete($path . '/' . $old_favicon);
            }
            $favicon_name = 'FAVICON_' . uniqid() . '.' . $this->blog_favicon->getClientOriginalExtension();
            File::copy($this->blog_favicon->getRealPath(), $path . '/' . $favicon_name);
            $settings->blog_favicon = $favicon_name;
        }

        $settings->save();
        GeneralSetting::clearSettingsCache();

        $this->current_logo = $settings->blog_logo;
        $this->current_favicon = $settings->blog_favicon;
        $this->blog_logo = null;
        $this->blog_favicon = null;
        
        $logo_url = $settings->blog_logo ? asset('images/settings/' . $settings->blog_logo) : asset('Back/vendors/images/deskapp-logo.svg');
        $favicon_url = $settings->blog_favicon ? asset('images/settings/' . $settings->blog_favicon) : asset('Back/vendors/images/favicon-32x32.png');
        
        $this->dispatch('updateLayoutLogo', [
            'logo_url' => $logo_url,
            'favicon_url' => $favicon_url
        ]);

        $this->dispatch('showToast', ['message' => 'Settings have been updated successfully!', 'type' => 'success']);
    }

    public function render()
    {
        return view('livewire.admin-settings');
    }
}
