<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Thông tin cá nhân') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Cập nhật thông tin tài khoản và địa chỉ email của bạn.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Họ và tên')" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-user text-gray-400"></i>
                </div>
                <x-text-input id="name" name="name" type="text" class="pl-10 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="username" :value="__('Tên đăng nhập')" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-at text-gray-400"></i>
                </div>
                <x-text-input id="username" name="username" type="text" class="pl-10 block w-full" :value="old('username', $user->username)" required autocomplete="username" />
            </div>
            <p class="text-sm text-gray-500 mt-1">Tên đăng nhập sẽ được sử dụng trong URL cá nhân của bạn.</p>
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
                <x-text-input id="email" name="email" type="email" class="pl-10 block w-full" :value="old('email', $user->email)" required autocomplete="email" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Địa chỉ email của bạn chưa được xác minh.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Nhấn vào đây để gửi lại email xác minh.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Đã gửi một liên kết xác minh mới đến địa chỉ email của bạn.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="phone_number" :value="__('Số điện thoại')" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-phone text-gray-400"></i>
                </div>
                <x-text-input id="phone_number" name="phone_number" type="text" class="pl-10 block w-full" :value="old('phone_number', $user->phone_number)" autocomplete="tel" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                <i class="fas fa-save mr-2"></i>
                {{ __('Lưu thay đổi') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
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
