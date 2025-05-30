<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Cập nhật mật khẩu') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Đảm bảo tài khoản của bạn sử dụng mật khẩu dài và ngẫu nhiên để giữ an toàn.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Mật khẩu hiện tại')" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="pl-10 block w-full" autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Mật khẩu mới')" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-key text-gray-400"></i>
                </div>
                <x-text-input id="update_password_password" name="password" type="password" class="pl-10 block w-full" autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            <p class="text-sm text-gray-500 mt-1">Mật khẩu nên có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số.</p>
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Xác nhận mật khẩu mới')" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-check-double text-gray-400"></i>
                </div>
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="pl-10 block w-full" autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                <i class="fas fa-save mr-2"></i>
                {{ __('Lưu mật khẩu') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 bg-green-50 px-3 py-1 rounded-full"
                >
                    <i class="fas fa-check mr-1"></i>
                    {{ __('Đã lưu.') }}
                </p>
            @endif
        </div>
    </form>
</section>
