<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\House;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Hiển thị trang Dashboard
     */
    public function dashboard()
    {
        // Thống kê cơ bản
        $totalUsers = User::count();
        $totalHouses = House::count();
        
        // Top 5 người dùng có nhiều nhà nhất
        $topUsers = User::withCount('houses')
            ->orderBy('houses_count', 'desc')
            ->take(5)
            ->get();
        
        // Thống kê nhà theo loại
        $housesByType = House::select('house_type', DB::raw('count(*) as total'))
            ->groupBy('house_type')
            ->get();
            
        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalHouses', 
            'topUsers', 
            'housesByType'
        ));
    }
    
    /**
     * Hiển thị danh sách người dùng
     */
    public function users()
    {
        $users = User::withCount('houses')->paginate(15);
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Hiển thị form tạo người dùng mới
     */
    public function createUser()
    {
        return view('admin.users.create');
    }
    
    /**
     * Lưu người dùng mới
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone_number' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'is_admin' => 'boolean',
        ]);
        
        $validated['password'] = Hash::make($validated['password']);
        
        User::create($validated);
        
        return redirect()->route('admin.users')->with('success', 'Người dùng đã được tạo thành công');
    }
    
    /**
     * Hiển thị form chỉnh sửa người dùng
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    
    /**
     * Cập nhật thông tin người dùng
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'phone_number' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'is_admin' => 'boolean',
        ]);
        
        // Chỉ cập nhật mật khẩu nếu có nhập mới
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        $user->update($validated);
        
        return redirect()->route('admin.users')->with('success', 'Đã cập nhật thông tin người dùng');
    }
    
    /**
     * Xóa người dùng
     */
    public function destroyUser(User $user)
    {
        // Không cho xóa tài khoản đang đăng nhập
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Không thể xóa tài khoản đang sử dụng');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users')->with('success', 'Người dùng đã được xóa');
    }
    
    /**
     * Hiển thị danh sách nhà
     */
    public function houses()
    {
        $houses = House::with('user')->paginate(15);
        return view('admin.houses.index', compact('houses'));
    }
    
    /**
     * Hiển thị thống kê
     */
    public function statistics()
    {
        // Thống kê theo tháng
        $monthlyCounts = House::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('count(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        // Thống kê giá trung bình theo loại nhà
        $avgPriceByType = House::select(
                'house_type',
                DB::raw('AVG(rent_price) as avg_price')
            )
            ->whereNotNull('house_type')
            ->groupBy('house_type')
            ->get();
            
        return view('admin.statistics', compact('monthlyCounts', 'avgPriceByType'));
    }
}
