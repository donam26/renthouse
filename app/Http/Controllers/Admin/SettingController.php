<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Hiển thị trang cài đặt hệ thống
     */
    public function index()
    {
        // Lấy tất cả cài đặt từ database (nếu sử dụng model Setting)
        // Hoặc lấy từ file config nếu dự án sử dụng file config
        
        // Giả sử sử dụng model Setting
        $settings = $this->getSettings();
        
        return view('admin.settings', compact('settings'));
    }

    /**
     * Cập nhật cài đặt hệ thống
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'footer_text' => 'nullable|string',
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|string|max:10',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|string|in:tls,ssl,null',
            'mail_from_address' => 'nullable|email|max:255',
            'registration_enabled' => 'nullable|boolean',
            'maintenance_mode' => 'nullable|boolean',
            'max_upload_size' => 'nullable|integer|min:1|max:100',
            'items_per_page' => 'nullable|integer|min:5|max:100',
        ]);

        // Lưu các cài đặt vào database
        foreach ($request->except('_token') as $key => $value) {
            $this->updateSetting($key, $value);
        }

        // Áp dụng chế độ bảo trì nếu được bật
        if ($request->has('maintenance_mode')) {
            if ($request->maintenance_mode == '1') {
                Artisan::call('down');
            } else {
                Artisan::call('up');
            }
        }

        // Xóa cache của hệ thống để áp dụng cài đặt mới
        Artisan::call('config:cache');
        
        return redirect()->route('admin.settings')
            ->with('success', 'Cài đặt hệ thống đã được cập nhật thành công!');
    }

    /**
     * Lấy tất cả cài đặt từ database
     */
    private function getSettings()
    {
        // Kiểm tra nếu model Setting tồn tại
        if (class_exists('App\Models\Setting')) {
            // Lấy tất cả cài đặt và chuyển thành collection có key và value
            $settings = Setting::all()->pluck('value', 'key');
            return (object) $settings->toArray();
        }
        
        // Trả về object rỗng nếu không có model Setting
        return (object) [];
    }

    /**
     * Cập nhật cài đặt vào database
     */
    private function updateSetting($key, $value)
    {
        // Kiểm tra nếu model Setting tồn tại
        if (class_exists('App\Models\Setting')) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
} 