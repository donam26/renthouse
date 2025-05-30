<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách người dùng
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Lọc theo vai trò
        if ($request->filled('role')) {
            $role = $request->role;
            if ($role === 'admin') {
                $query->where('is_admin', true);
            } elseif ($role === 'user') {
                $query->where('is_admin', false);
            }
        }
        
        // Sắp xếp và phân trang
        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Hiển thị form tạo người dùng mới
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Lưu người dùng mới vào database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'is_admin' => ['nullable', 'boolean'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'is_admin' => $request->has('is_admin') ? true : false,
            'username' => $this->generateUsername($request->name),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Người dùng đã được tạo thành công!');
    }

    /**
     * Hiển thị thông tin chi tiết người dùng
     */
    public function show(User $user)
    {
        // Lấy danh sách nhà của người dùng
        $houses = $user->houses()->paginate(5);
        
        return view('admin.users.show', compact('user', 'houses'));
    }

    /**
     * Hiển thị form chỉnh sửa người dùng
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Cập nhật thông tin người dùng
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'is_admin' => ['nullable', 'boolean'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        // Nếu có mật khẩu mới, kiểm tra và cập nhật
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            
            $user->password = Hash::make($request->password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->is_admin = $request->has('is_admin') ? true : false;
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Thông tin người dùng đã được cập nhật!');
    }

    /**
     * Xóa người dùng
     */
    public function destroy(User $user)
    {
        // Không cho phép xóa chính mình
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Bạn không thể xóa tài khoản của chính mình!');
        }
        
        // Xóa người dùng
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Người dùng đã được xóa thành công!');
    }
    
    /**
     * Tạo username từ tên người dùng
     */
    private function generateUsername($name)
    {
        $username = Str::slug($name);
        $count = User::where('username', 'like', $username . '%')->count();
        
        return $count ? "{$username}-{$count}" : $username;
    }
} 