<?php

namespace App\Policies;

use App\Models\House;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HousePolicy
{
    /**
     * Xác định xem người dùng có thể xem danh sách nhà hay không.
     */
    public function viewAny(User $user): bool
    {
        return true; // Mọi người dùng đã đăng nhập đều có thể xem danh sách nhà của họ
    }

    /**
     * Xác định xem người dùng có thể xem chi tiết nhà hay không.
     */
    public function view(User $user, House $house): bool
    {
        // Cho phép xem nếu là chủ sở hữu hoặc nếu nhà này có share_link
        return $user->id === $house->user_id || !empty($house->share_link);
    }

    /**
     * Xác định xem người dùng có thể tạo nhà mới hay không.
     */
    public function create(User $user): bool
    {
        return true; // Mọi người dùng đã đăng nhập đều có thể tạo nhà mới
    }

    /**
     * Xác định xem người dùng có thể cập nhật nhà hay không.
     */
    public function update(User $user, House $house): bool
    {
        return $user->id === $house->user_id;
    }

    /**
     * Xác định xem người dùng có thể xóa nhà hay không.
     */
    public function delete(User $user, House $house): bool
    {
        return $user->id === $house->user_id;
    }

    /**
     * Xác định xem người dùng có thể khôi phục nhà hay không.
     */
    public function restore(User $user, House $house): bool
    {
        return $user->id === $house->user_id;
    }

    /**
     * Xác định xem người dùng có thể xóa vĩnh viễn nhà hay không.
     */
    public function forceDelete(User $user, House $house): bool
    {
        return $user->id === $house->user_id;
    }
}
