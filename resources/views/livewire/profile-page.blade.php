<div class="bg-gray-50 min-h-screen pb-16">
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-serif text-[#3E2723] font-bold mb-12 text-center">{{ __('My Personal Sanctuary') }}</h1>

        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Sidebar Navigation -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 flex flex-col items-center border-b border-gray-50">
                        <div class="relative group cursor-pointer" onclick="document.getElementById('avatar-upload').click()">
                            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-[#FDFBF7] shadow-sm bg-gray-100">
                                @if($avatar)
                                    <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif($current_avatar)
                                    <img src="{{ asset('storage/' . $current_avatar) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-[#D4AF37] text-2xl font-bold bg-[#FDFBF7]">
                                        {{ substr($name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="absolute inset-0 bg-black bg-opacity-40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <input type="file" id="avatar-upload" wire:model="avatar" class="hidden" accept="image/*">
                        </div>
                        <h2 class="mt-4 text-xl font-serif text-gray-900 font-bold uppercase tracking-widest">{{ $name }}</h2>
                        <p class="text-sm text-gray-400 mt-1 uppercase tracking-tighter">{{ __('Member since') }} {{ auth()->user()->created_at->format('Y') }}</p>
                    </div>
                    <nav class="p-4">
                        <button wire:click="setTab('overview')" class="w-full flex items-center space-x-3 px-4 py-3 rounded-md transition-all duration-300 {{ $activeTab === 'overview' ? 'bg-[#3E2723] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span class="font-medium">{{ __('Personal Details') }}</span>
                        </button>
                        <button wire:click="setTab('orders')" class="w-full flex items-center space-x-3 px-4 py-3 rounded-md transition-all duration-300 mt-2 {{ $activeTab === 'orders' ? 'bg-[#3E2723] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            <span class="font-medium">{{ __('Order History') }}</span>
                        </button>
                        <button wire:click="setTab('security')" class="w-full flex items-center space-x-3 px-4 py-3 rounded-md transition-all duration-300 mt-2 {{ $activeTab === 'security' ? 'bg-[#3E2723] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <span class="font-medium">{{ __('Security Settings') }}</span>
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Content Area -->
            <div class="flex-1">
                @if (session()->has('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm animate-pulse">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Tab: Overview -->
                <div x-show="$wire.activeTab === 'overview'" class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
                    <h3 class="text-2xl font-serif text-gray-900 mb-8 pb-2 border-b">{{ __('Account Information') }}</h3>
                    <form wire:submit.prevent="updateProfile" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-400 tracking-widest mb-2">{{ __('Full Name') }}</label>
                                <input type="text" wire:model="name" class="w-full bg-[#FDFBF7] border-gray-100 rounded focus:ring-[#D4AF37] focus:border-[#D4AF37] py-3">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-400 tracking-widest mb-2">{{ __('Email Address') }}</label>
                                <input type="email" wire:model="email" class="w-full bg-[#FDFBF7] border-gray-100 rounded focus:ring-[#D4AF37] focus:border-[#D4AF37] py-3">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-400 tracking-widest mb-2">{{ __('Phone Number') }}</label>
                                <input type="text" wire:model="phone" class="w-full bg-[#FDFBF7] border-gray-100 rounded focus:ring-[#D4AF37] focus:border-[#D4AF37] py-3">
                                @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-400 tracking-widest mb-2">{{ __('Date of Birth') }}</label>
                                <input type="date" wire:model="birthday" class="w-full bg-[#FDFBF7] border-gray-100 rounded focus:ring-[#D4AF37] focus:border-[#D4AF37] py-3">
                                @error('birthday') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 tracking-widest mb-2">{{ __('Billing Address') }}</label>
                            <textarea wire:model="address" rows="3" class="w-full bg-[#FDFBF7] border-gray-100 rounded focus:ring-[#D4AF37] focus:border-[#D4AF37] py-3"></textarea>
                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-[#3E2723] text-white px-10 py-3 rounded shadow hover:bg-[#2d1c19] transition-all uppercase tracking-widest text-sm font-bold">
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tab: Orders -->
                <div x-show="$wire.activeTab === 'orders'" class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
                    <h3 class="text-2xl font-serif text-gray-900 mb-8 pb-2 border-b">{{ __('Recent Orders') }}</h3>
                    <div class="space-y-6">
                        @forelse($orders as $order)
                            <div class="flex items-center justify-between p-4 bg-[#FDFBF7] rounded border border-gray-50 hover:border-[#D4AF37] transition-all">
                                <div>
                                    <p class="font-bold text-gray-900 tracking-wider">#{{ $order->id }}</p>
                                    <p class="text-xs text-gray-400 mt-1 uppercase">{{ $order->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="text-center">
                                    <span class="px-3 py-1 bg-white border border-gray-100 rounded-full text-[10px] uppercase font-bold tracking-widest text-gray-600">
                                        {{ $order->status->value }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <p class="font-serif font-bold text-gray-900">€{{ number_format($order->total_eur, 2) }}</p>
                                    <a href="{{ route('orders.invoice', $order) }}" class="text-[10px] text-[#D4AF37] uppercase font-bold hover:underline">{{ __('View Details') }}</a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <p class="text-gray-400 italic font-serif">{{ __('Your journey has just begun. Place your first order today.') }}</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="mt-8 text-center">
                        <a href="{{ route('my-orders') }}" class="text-sm font-bold text-[#D4AF37] uppercase tracking-widest border-b-2 border-transparent hover:border-[#D4AF37] transition-all pb-1">{{ __('View Full History') }}</a>
                    </div>
                </div>

                <!-- Tab: Security -->
                <div x-show="$wire.activeTab === 'security'" class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
                    <h3 class="text-2xl font-serif text-gray-900 mb-8 pb-2 border-b">{{ __('Security & Password') }}</h3>
                    <form wire:submit.prevent="updatePassword" class="space-y-6 max-w-md">
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 tracking-widest mb-2">{{ __('Current Password') }}</label>
                            <input type="password" wire:model="current_password" class="w-full bg-[#FDFBF7] border-gray-100 rounded focus:ring-[#D4AF37] focus:border-[#D4AF37] py-3">
                            @error('current_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 tracking-widest mb-2">{{ __('New Password') }}</label>
                            <input type="password" wire:model="new_password" class="w-full bg-[#FDFBF7] border-gray-100 rounded focus:ring-[#D4AF37] focus:border-[#D4AF37] py-3">
                            @error('new_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 tracking-widest mb-2">{{ __('Confirm New Password') }}</label>
                            <input type="password" wire:model="new_password_confirmation" class="w-full bg-[#FDFBF7] border-gray-100 rounded focus:ring-[#D4AF37] focus:border-[#D4AF37] py-3">
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="bg-[#3E2723] text-white px-10 py-3 rounded shadow hover:bg-[#2d1c19] transition-all uppercase tracking-widest text-sm font-bold">
                                {{ __('Update Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
