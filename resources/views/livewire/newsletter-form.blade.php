<div>
  <h3 class="font-bold text-white mb-5 text-sm uppercase tracking-wider">Newsletter</h3>
  <p class="text-sm mb-4" style="color:#64748B">Get weekly insights delivered to your inbox.</p>

  @if($subscribed)
    <div class="p-3 rounded-lg text-sm mb-3 flex items-center gap-2" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399;">
      <i class="fas fa-check-circle flex-shrink-0"></i>
      <span>Thank you for subscribing! Welcome aboard.</span>
    </div>
  @endif

  <form wire:submit="subscribe">
    <div class="flex flex-col gap-2">
      <div>
        <input 
          type="email" 
          wire:model="email" 
          placeholder="your@email.com" 
          class="form-input text-sm w-full @error('email') border-red-500 @enderror" 
          required 
        />
        @error('email')
          <span class="text-xs mt-1 block font-medium" style="color:#ef4444;">{{ $message }}</span>
        @enderror
      </div>
      <button type="submit" class="btn btn-primary w-full justify-center" wire:loading.attr="disabled">
        <span wire:loading.remove wire:target="subscribe">
          Subscribe <i class="fas fa-paper-plane ml-1"></i>
        </span>
        <span wire:loading wire:target="subscribe" class="inline-flex items-center justify-center gap-2">
          <i class="fas fa-spinner fa-spin"></i> Subscribing...
        </span>
      </button>
    </div>
  </form>
</div>
