<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteInfo;
use Illuminate\Http\Request;

class SiteInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siteInfo = SiteInfo::first();
        return view('admin.site-info.index', compact('siteInfo'));
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit()
    {
        $siteInfo = SiteInfo::first();
        if (!$siteInfo) {
            $siteInfo = SiteInfo::create([
                'name' => 'PetSam',
                'address' => '123 Đường Pet, TP. HCM',
                'phone' => '(+84) 987 654 321',
                'email' => 'support@petsam.vn',
            ]);
        }
        return view('admin.site-info.edit', compact('siteInfo'));
    }

    /**
     * Update the resource in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        $siteInfo = SiteInfo::first();
        if (!$siteInfo) {
            $siteInfo = new SiteInfo();
        }
        
        $siteInfo->update($validated);

        return redirect()->route('admin.site-info.edit')
            ->with('success', 'Cập nhật thông tin trang web thành công!');
    }
}
