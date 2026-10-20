<div>
    <div class="row">
        <!-- Settings Form -->
        <div class="col-md-12">
            <div class="profile-tab w-100 d-flex flex-column flex-grow-1">
                <div class="tab premium-tabs-card w-100 flex-grow-1">
                    <ul class="nav premium-nav-tabs" role="tablist">
                        <li class="nav-item flex-fill">
                            <a wire:click.prevent="selectTab('general_info')" class="nav-link {{ $tab == 'general_info' ? 'active' : '' }}" data-toggle="tab" href="#general_info" role="tab">General Info</a>
                        </li>
                        <li class="nav-item flex-fill">
                            <a wire:click.prevent="selectTab('logo_favicon')" class="nav-link {{ $tab == 'logo_favicon' ? 'active' : '' }}" data-toggle="tab" href="#logo_favicon" role="tab">Logo & Favicon</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- General Info Tab -->
                        <div class="tab-pane fade {{ $tab == 'general_info' ? 'show active' : '' }}" id="general_info" role="tabpanel">
                            <div class="pt-3">
                                <form wire:submit.prevent="updateSettings">
                                    <div class="flex-row-gap">
                                        <div class="flex-col-half">
                                            <div class="premium-form-group">
                                                <label>Blog Name</label>
                                                <input type="text" class="premium-form-control" wire:model="blog_name" placeholder="Enter blog name">
                                                @error('blog_name') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="flex-col-half">
                                            <div class="premium-form-group">
                                                <label>Blog Email</label>
                                                <input type="email" class="premium-form-control" wire:model="blog_email" placeholder="Enter blog email">
                                                @error('blog_email') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="flex-col-half">
                                            <div class="premium-form-group">
                                                <label>Blog Phone Number <small>(optional)</small></label>
                                                <input type="text" class="premium-form-control" wire:model="blog_phone" placeholder="Enter blog phone">
                                                @error('blog_phone') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="flex-col-half">
                                            <div class="premium-form-group">
                                                <label>Blog Meta Keywords <small>(optional)</small></label>
                                                <input type="text" class="premium-form-control" wire:model="blog_meta_keywords" placeholder="Enter blog meta keywords">
                                                @error('blog_meta_keywords') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="flex-col-full">
                                            <div class="premium-form-group">
                                                <label>Blog Description</label>
                                                <textarea class="premium-form-control" wire:model="blog_description" placeholder="Enter blog description" rows="4"></textarea>
                                                @error('blog_description') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="premium-form-group mt-4 mb-0 text-right">
                                        <button type="submit" class="premium-btn">
                                            <span wire:loading.remove wire:target="updateSettings">Save Settings</span>
                                            <span wire:loading wire:target="updateSettings"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Logo & Favicon Tab -->
                        <div class="tab-pane fade {{ $tab == 'logo_favicon' ? 'show active' : '' }}" id="logo_favicon" role="tabpanel">
                            <div class="pt-3">
                                <form wire:submit.prevent="updateSettings">
                                    <div class="flex-row-gap">
                                        <div class="flex-col-half">
                                            <div class="premium-form-group">
                                                <div class="d-flex align-items-center">
                                                    <!-- Image Preview Area -->
                                                    <div class="mr-4 shadow-sm" style="width: 120px; height: 120px; border-radius: 12px; border: 1px solid #eaedf1; background: #f8f9fa; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; flex-shrink: 0;">
                                                        @if ($blog_logo)
                                                            <img src="{{ $blog_logo->temporaryUrl() }}" alt="Logo Preview" style="max-width: 100%; max-height: 100%;">
                                                        @elseif($current_logo)
                                                            <img src="{{ asset('images/settings/' . $current_logo) }}" alt="Current Logo" style="max-width: 100%; max-height: 100%;">
                                                        @else
                                                            <i class="bi bi-image text-muted" style="font-size: 2.5rem;"></i>
                                                        @endif
                                                    </div>

                                                    <!-- Upload Button Area -->
                                                    <div>
                                                        <h6 class="mb-2">Blog Logo</h6>
                                                        <label for="blogLogoInput" class="btn btn-outline-primary btn-sm mb-2" style="cursor: pointer; font-weight: 500;">
                                                            <i class="fa fa-upload mr-1"></i> Change Logo
                                                        </label>
                                                        <div class="text-muted" style="font-size: 13px;">Allowed: JPG, PNG, SVG.<br>Max file size: 2MB.</div>
                                                        <input type="file" id="blogLogoInput" class="d-none" wire:model="blog_logo" accept="image/*">
                                                        @error('blog_logo') <span class="text-danger mt-2 d-block" style="font-size: 13px;">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-col-half">
                                            <div class="premium-form-group">
                                                <div class="d-flex align-items-center">
                                                    <!-- Image Preview Area -->
                                                    <div class="mr-4 shadow-sm" style="width: 120px; height: 120px; border-radius: 12px; border: 1px solid #eaedf1; background: #f8f9fa; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; flex-shrink: 0;">
                                                        @if ($blog_favicon)
                                                            <img src="{{ $blog_favicon->temporaryUrl() }}" alt="Favicon Preview" style="max-width: 100%; max-height: 100%;">
                                                        @elseif($current_favicon)
                                                            <img src="{{ asset('images/settings/' . $current_favicon) }}" alt="Current Favicon" style="max-width: 100%; max-height: 100%;">
                                                        @else
                                                            <i class="bi bi-image text-muted" style="font-size: 2.5rem;"></i>
                                                        @endif
                                                    </div>

                                                    <!-- Upload Button Area -->
                                                    <div>
                                                        <h6 class="mb-2">Blog Favicon</h6>
                                                        <label for="blogFaviconInput" class="btn btn-outline-primary btn-sm mb-2" style="cursor: pointer; font-weight: 500;">
                                                            <i class="fa fa-upload mr-1"></i> Change Favicon
                                                        </label>
                                                        <div class="text-muted" style="font-size: 13px;">Allowed: JPG, PNG, ICO.<br>Max file size: 1MB.</div>
                                                        <input type="file" id="blogFaviconInput" class="d-none" wire:model="blog_favicon" accept="image/*">
                                                        @error('blog_favicon') <span class="text-danger mt-2 d-block" style="font-size: 13px;">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="premium-form-group mt-4 mb-0 text-right">
                                        <button type="submit" class="premium-btn">
                                            <span wire:loading.remove wire:target="updateSettings">Save Settings</span>
                                            <span wire:loading wire:target="updateSettings"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('updateLayoutLogo', (event) => {
        let logoUrl = event[0].logo_url;
        let faviconUrl = event[0].favicon_url;
        
        // Update Logos
        let darkLogo = document.querySelector('.brand-logo .dark-logo');
        let lightLogo = document.querySelector('.brand-logo .light-logo');
        if(darkLogo) darkLogo.src = logoUrl;
        if(lightLogo) lightLogo.src = logoUrl;

        // Update Favicons
        let favicons = document.querySelectorAll('link[rel="icon"], link[rel="apple-touch-icon"]');
        favicons.forEach(icon => {
            icon.href = faviconUrl;
        });
    });
</script>
@endscript
