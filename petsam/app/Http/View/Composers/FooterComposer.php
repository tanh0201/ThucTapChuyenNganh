<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\SiteInfo;

class FooterComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $siteInfo = SiteInfo::first();
        
        if (!$siteInfo) {
            $siteInfo = new SiteInfo([
                'name' => 'PetSam',
                'address' => '123 Đường Pet, TP. HCM',
                'phone' => '(+84) 987 654 321',
                'email' => 'support@petsam.vn',
                'description' => 'Cung cấp phụ kiện và sản phẩm chăm sóc thú cưng chất lượng cao. Giao hàng nhanh toàn quốc.',
            ]);
        }
        
        $view->with('siteInfo', $siteInfo);
    }
}
