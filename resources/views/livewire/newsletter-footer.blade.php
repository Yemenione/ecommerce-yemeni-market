<div>
    <h4 class="font-bold mb-4 uppercase tracking-wider text-xs">{{ __('Newsletter') }}</h4>
    <p class="text-gray-400 mb-4 text-sm">
        {{ __('Subscribe to receive updates, access to exclusive deals, and more.') }}
    </p>

    @if (session()->has('success'))
        <div class="p-2 mb-4 text-xs text-green-400 border border-green-800 rounded bg-green-900/30" role="alert">
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <form wire:submit.prevent="subscribe" class="flex flex-col gap-2">
        <div class="relative">
            <input 
                wire:model="email" 
                type="email" 
                placeholder="{{ __('Enter your email') }}" 
                class="w-full px-4 py-2 text-sm bg-gray-800 border-gray-700 text-white placeholder-gray-500 rounded focus:ring-[#D4AF37] focus:border-[#D4AF37] transition-colors"
                required
            >
            @error('email') <span class="text-xs text-red-400 absolute -bottom-5 left-0">{{ $message }}</span> @enderror
        </div>
        <button 
            type="submit" 
            class="px-4 py-2 text-sm font-medium text-[#1A1A1A] bg-[#D4AF37] rounded hover:bg-white hover:text-[#1A1A1A] transition-all duration-300 uppercase tracking-wide mt-2"
        >
            {{ __('Subscribe') }}
        </button>
    </form>
</div>
