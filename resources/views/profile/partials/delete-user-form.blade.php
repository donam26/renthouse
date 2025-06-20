<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Xóa tài khoản') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Khi tài khoản của bạn bị xóa, tất cả các dữ liệu liên quan sẽ bị xóa vĩnh viễn. Trước khi xóa tài khoản, vui lòng tải xuống bất kỳ dữ liệu hoặc thông tin nào bạn muốn giữ lại.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="flex items-center"
    >
        <i class="fas fa-trash-alt mr-2"></i>
        {{ __('Xóa tài khoản') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Bạn có chắc chắn muốn xóa tài khoản?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Khi tài khoản của bạn bị xóa, tất cả các dữ liệu liên quan sẽ bị xóa vĩnh viễn. Vui lòng nhập mật khẩu để xác nhận bạn muốn xóa vĩnh viễn tài khoản của mình.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Mật khẩu') }}" class="sr-only" />

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                        class="pl-10 mt-1 block w-3/4"
                        placeholder="{{ __('Mật khẩu') }}"
                />
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Hủy bỏ') }}
                </x-secondary-button>

                <x-danger-button class="ml-3 flex items-center">
                    <i class="fas fa-trash-alt mr-2"></i>
                    {{ __('Xác nhận xóa tài khoản') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
