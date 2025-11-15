<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Toggle theme mode
     */
    public function toggleTheme(Request $request)
    {
        $currentTheme = session('admin_theme', 'light');
        $newTheme = $currentTheme === 'light' ? 'dark' : 'light';
        
        session(['admin_theme' => $newTheme]);
        
        return response()->json([
            'success' => true,
            'theme' => $newTheme,
            'message' => 'Theme changed to ' . $newTheme . ' mode'
        ]);
    }

    /**
     * Get current theme
     */
    public function getTheme()
    {
        $theme = session('admin_theme', 'light');
        
        return response()->json([
            'success' => true,
            'theme' => $theme
        ]);
    }

    /**
     * Set theme
     */
    public function setTheme(Request $request)
    {
        $theme = $request->get('theme', 'light');
        
        if (!in_array($theme, ['light', 'dark'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid theme'
            ], 400);
        }
        
        session(['admin_theme' => $theme]);
        
        return response()->json([
            'success' => true,
            'theme' => $theme
        ]);
    }
}
