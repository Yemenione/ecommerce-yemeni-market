<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <div class="flex h-full items-center">
    <main class="w-full max-w-md mx-auto p-6">
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="p-4 sm:p-7">
          <div class="text-center">
            <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">{{ __('Login') }}</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
              {{ __('Don\'t have an account yet?') }}
              <a class="text-[#D4AF37] decoration-2 hover:underline font-medium" href="{{ route('register') }}">
                {{ __('Sign up here') }}
              </a>
            </p>
          </div>

          <div class="mt-5">
            <!-- Form -->
            <form wire:submit.prevent="login">
              <div class="grid gap-y-4">
                <!-- Form Group -->
                <div>
                  <label for="email" class="block text-sm mb-2 dark:text-white">{{ __('Email address') }}</label>
                  <div class="relative">
                    <input type="email" id="email" wire:model="email" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="email-error">
                    @error('email')
                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                      <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.5.5 0 0 0 .5.5v3a.5.5 0 0 0-1 0v-3A.5.5 0 0 0 8 4zm0 5a.5.5 0 0 0 .5.5v1a.5.5 0 0 0-1 0v-1a.5.5 0 0 0 .5-.5z"/>
                      </svg>
                    </div>
                    @enderror
                  </div>
                  @error('email')
                  <p class="hidden text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                  @enderror
                </div>
                <!-- End Form Group -->

                <!-- Form Group -->
                <div>
                  <div class="flex justify-between items-center">
                    <label for="password" class="block text-sm mb-2 dark:text-white">{{ __('Password') }}</label>
                    <a class="text-sm text-[#D4AF37] decoration-2 hover:underline font-medium" href="/forgot-password">{{ __('Forgot password?') }}</a>
                  </div>
                  <div class="relative">
                    <input type="password" id="password" wire:model="password" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="password-error">
                    @error('password')
                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                      <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.5.5 0 0 0 .5.5v3a.5.5 0 0 0-1 0v-3A.5.5 0 0 0 8 4zm0 5a.5.5 0 0 0 .5.5v1a.5.5 0 0 0-1 0v-1a.5.5 0 0 0 .5-.5z"/>
                      </svg>
                    </div>
                    @enderror
                  </div>
                  @error('password')
                  <p class="hidden text-xs text-red-600 mt-2" id="password-error">{{ $message }}</p>
                  @enderror
                </div>
                <!-- End Form Group -->

                <!-- Checkbox -->
                <div class="flex items-center">
                  <div class="flex">
                    <input id="remember-me" wire:model="remember" type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded text-[#D4AF37] focus:ring-[#D4AF37] dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-[#D4AF37] dark:checked:border-[#D4AF37] dark:focus:ring-offset-gray-800">
                  </div>
                  <div class="ms-3">
                    <label for="remember-me" class="text-sm dark:text-white">{{ __('Remember me') }}</label>
                  </div>
                </div>
                <!-- End Checkbox -->

                <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-[#D4AF37] text-white hover:bg-[#b08d26] disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    {{ __('Login') }}
                </button>
              </div>
            </form>
            <!-- End Form -->
          </div>
        </div>
      </div>
    </main>
  </div>
</div>
