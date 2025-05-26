@extends('layouts.admin')

@section('title', 'Chỉnh sửa nhà cho thuê')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Chỉnh sửa nhà cho thuê</h1>
        <a href="{{ route('admin.houses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại
        </a>
    </div>

    <!-- Thông báo thành công -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <form action="{{ route('admin.houses.update', $house) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Thông tin cơ bản -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Thông tin cơ bản</h3>
                        <p class="mt-1 text-sm text-gray-500">Nhập các thông tin cơ bản của nhà cho thuê</p>
                    </div>

                    <div>
                        <label for="name" class="form-label">Tên nhà <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $house->name) }}" 
                            class="input-field @error('name') border-red-500 @enderror" 
                            placeholder="Nhập tên nhà cho thuê">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="form-label">Địa chỉ <span class="text-red-500">*</span></label>
                        <input type="text" name="address" id="address" value="{{ old('address', $house->address) }}" 
                            class="input-field @error('address') border-red-500 @enderror" 
                            placeholder="Nhập địa chỉ đầy đủ">
                        @error('address')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="form-label">Vị trí</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $house->location) }}" 
                            class="input-field @error('location') border-red-500 @enderror" 
                            placeholder="Ví dụ: Gần trường đại học, chợ,...">
                        @error('location')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="user_id" class="form-label">Chủ nhà <span class="text-red-500">*</span></label>
                        <select name="user_id" id="user_id" class="input-field @error('user_id') border-red-500 @enderror">
                            <option value="">-- Chọn chủ nhà --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ (old('user_id', $house->user_id) == $user->id) ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Thông tin giá và chi tiết -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Thông tin giá và chi tiết</h3>
                        <p class="mt-1 text-sm text-gray-500">Nhập thông tin giá và chi tiết khác</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="rent_price" class="form-label">Giá thuê <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                    VND
                                </span>
                                <input type="number" name="rent_price" id="rent_price" value="{{ old('rent_price', $house->rent_price) }}" 
                                    class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300 @error('rent_price') border-red-500 @enderror"
                                    placeholder="Nhập giá thuê">
                            </div>
                            @error('rent_price')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="deposit_price" class="form-label">Tiền đặt cọc</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                    VND
                                </span>
                                <input type="number" name="deposit_price" id="deposit_price" value="{{ old('deposit_price', $house->deposit_price) }}" 
                                    class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300 @error('deposit_price') border-red-500 @enderror"
                                    placeholder="Nhập tiền đặt cọc">
                            </div>
                            @error('deposit_price')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="house_type" class="form-label">Loại nhà <span class="text-red-500">*</span></label>
                            <select name="house_type" id="house_type" class="input-field @error('house_type') border-red-500 @enderror">
                                <option value="">-- Chọn loại nhà --</option>
                                <option value="1r" {{ (old('house_type', $house->house_type) == '1r') ? 'selected' : '' }}>1r</option>
                                <option value="1k" {{ (old('house_type', $house->house_type) == '1k') ? 'selected' : '' }}>1k</option>
                                <option value="1DK" {{ (old('house_type', $house->house_type) == '1DK') ? 'selected' : '' }}>1DK</option>
                                <option value="2K" {{ (old('house_type', $house->house_type) == '2K') ? 'selected' : '' }}>2K</option>
                                <option value="2DK" {{ (old('house_type', $house->house_type) == '2DK') ? 'selected' : '' }}>2DK</option>
                                <option value="3DK" {{ (old('house_type', $house->house_type) == '3DK') ? 'selected' : '' }}>3DK</option>
                            </select>
                            @error('house_type')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="form-label">Trạng thái <span class="text-red-500">*</span></label>
                            <select name="status" id="status" class="input-field @error('status') border-red-500 @enderror">
                                <option value="available" {{ (old('status', $house->status) == 'available') ? 'selected' : '' }}>Còn trống</option>
                                <option value="rented" {{ (old('status', $house->status) == 'rented') ? 'selected' : '' }}>Đã thuê</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="distance" class="form-label">Khoảng cách (m)</label>
                            <input type="number" name="distance" id="distance" value="{{ old('distance', $house->distance) }}" 
                                class="input-field @error('distance') border-red-500 @enderror" 
                                placeholder="Khoảng cách đến trung tâm (m)">
                            @error('distance')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="transportation" class="form-label">Phương tiện di chuyển</label>
                            <input type="text" name="transportation" id="transportation" value="{{ old('transportation', $house->transportation) }}" 
                                class="input-field @error('transportation') border-red-500 @enderror" 
                                placeholder="Ví dụ: Xe buýt, tàu điện,...">
                            @error('transportation')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="share_link" class="form-label">Link chia sẻ</label>
                        <input type="text" name="share_link" id="share_link" value="{{ old('share_link', $house->share_link) }}" 
                            class="input-field @error('share_link') border-red-500 @enderror" 
                            placeholder="Nhập link chia sẻ (nếu có)">
                        @error('share_link')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Mô tả và hình ảnh -->
            <div class="mt-8 space-y-6">
                <div>
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea name="description" id="description" rows="4" 
                        class="input-field @error('description') border-red-500 @enderror" 
                        placeholder="Nhập mô tả chi tiết về nhà cho thuê">{{ old('description', $house->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="form-label">Hình ảnh</label>
                    <div class="flex items-center space-x-4">
                        @if($house->image_path)
                            <div class="flex-shrink-0 h-20 w-20 rounded-md overflow-hidden bg-gray-100">
                                <img src="{{ asset('storage/' . $house->image_path) }}" alt="{{ $house->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 mb-2">Ảnh hiện tại: {{ basename($house->image_path) }}</p>
                        @endif
                                <input type="file" name="image" id="image" 
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <p class="mt-1 text-xs text-gray-500">Chấp nhận file JPG, PNG, GIF dưới 2MB</p>
                        @if($house->image_path)
                            </div>
                        @endif
                    </div>
                    @error('image')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.houses.show', $house) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
                    <i class="fas fa-eye mr-2"></i> Xem chi tiết
                </a>
                <a href="{{ route('admin.houses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
                    <i class="fas fa-list mr-2"></i> Danh sách nhà
                </a>
                <button type="submit" name="save_and_continue" value="1" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    <i class="fas fa-save mr-2"></i> Lưu và tiếp tục
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 