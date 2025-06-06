<?php

namespace App\Http\Controllers;

use App\Models\UserMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserMediaController extends Controller
{
    /**
     * Hiển thị danh sách media của người dùng
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Lọc theo loại media
        $mediaType = $request->get('type', 'all');
        
        if ($mediaType === 'all') {
            $media = $user->media()->orderBy('media_type')->orderBy('sort_order')->get();
        } else {
            $media = $user->media()->where('media_type', $mediaType)->orderBy('sort_order')->get();
        }
        
        return view('media.index', compact('media', 'mediaType'));
    }
    
    /**
     * Hiển thị form tạo media mới
     */
    public function create()
    {
        return view('media.create');
    }
    
    /**
     * Lưu media mới
     */
    public function store(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'media_type' => ['required', Rule::in(['video', 'license', 'interaction'])],
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'file' => 'required|file|max:20480', // Giới hạn 20MB
        ]);
        
        // Lưu file
        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $mediaType = $validated['media_type'];
            
            // Kiểm tra định dạng file theo loại media
            if ($mediaType === 'video') {
                $request->validate([
                    'file' => 'mimes:mp4,mov,avi,wmv|max:20480', // Video định dạng phổ biến, max 20MB
                ]);
                $filePath = $file->store('media/videos', 'public');
            } else {
                $request->validate([
                    'file' => 'mimes:jpeg,png,jpg,gif|max:5120', // Ảnh định dạng phổ biến, max 5MB
                ]);
                $filePath = $file->store('media/images', 'public');
            }
        }
        
        // Lấy sort_order cao nhất của loại media hiện tại
        $maxSortOrder = Auth::user()->media()
            ->where('media_type', $validated['media_type'])
            ->max('sort_order') ?? 0;
        
        // Tạo bản ghi media mới
        Auth::user()->media()->create([
            'media_type' => $validated['media_type'],
            'file_path' => $filePath,
            'title' => $validated['title'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
            'sort_order' => $maxSortOrder + 1,
        ]);
        
        return redirect()->route('media.index', ['type' => $validated['media_type']])
            ->with('success', 'Đã tải lên thành công');
    }
    
    /**
     * Hiển thị form chỉnh sửa media
     */
    public function edit(UserMedia $media)
    {
        // Kiểm tra quyền sở hữu
        $this->authorize('update', $media);
        
        return view('media.edit', compact('media'));
    }
    
    /**
     * Cập nhật thông tin media
     */
    public function update(Request $request, UserMedia $media)
    {
        // Kiểm tra quyền sở hữu
        $this->authorize('update', $media);
        
        // Validate dữ liệu
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'file' => 'nullable|file|max:20480', // Giới hạn 20MB
        ]);
        
        // Cập nhật file nếu có
        if ($request->hasFile('file')) {
            // Xóa file cũ
            if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }
            
            // Kiểm tra định dạng file theo loại media
            if ($media->media_type === 'video') {
                $request->validate([
                    'file' => 'mimes:mp4,mov,avi,wmv|max:20480', // Video định dạng phổ biến, max 20MB
                ]);
                $filePath = $request->file('file')->store('media/videos', 'public');
            } else {
                $request->validate([
                    'file' => 'mimes:jpeg,png,jpg,gif|max:5120', // Ảnh định dạng phổ biến, max 5MB
                ]);
                $filePath = $request->file('file')->store('media/images', 'public');
            }
            
            $media->file_path = $filePath;
        }
        
        // Cập nhật thông tin khác
        $media->title = $validated['title'] ?? $media->title;
        $media->description = $validated['description'] ?? $media->description;
        $media->is_active = $validated['is_active'] ?? $media->is_active;
        $media->save();
        
        return redirect()->route('media.index', ['type' => $media->media_type])
            ->with('success', 'Cập nhật thành công');
    }
    
    /**
     * Xóa media
     */
    public function destroy(UserMedia $media)
    {
        // Kiểm tra quyền sở hữu
        $this->authorize('delete', $media);
        
        // Xóa file
        if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }
        
        $mediaType = $media->media_type;
        $media->delete();
        
        return redirect()->route('media.index', ['type' => $mediaType])
            ->with('success', 'Đã xóa thành công');
    }
    
    /**
     * Cập nhật thứ tự sắp xếp
     */
    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:user_media,id',
            'items.*.order' => 'required|integer|min:0',
        ]);
        
        // Cập nhật sort_order cho từng item
        foreach ($validated['items'] as $item) {
            $media = UserMedia::find($item['id']);
            
            // Kiểm tra quyền sở hữu
            if ($media && $media->user_id === Auth::id()) {
                $media->sort_order = $item['order'];
                $media->save();
            }
        }
        
        return response()->json(['success' => true]);
    }
} 