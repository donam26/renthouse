<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Hiển thị trang dashboard cho admin
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalHouses = House::count();
        
        // Lấy các hoạt động gần đây (đây chỉ là ví dụ, bạn cần điều chỉnh theo mô hình Activity của bạn)
        $recentActivities = collect([]); // Thay thế bằng mô hình Activity nếu có
        
        return view('admin.dashboard', compact('totalUsers', 'totalHouses', 'recentActivities'));
    }
} 