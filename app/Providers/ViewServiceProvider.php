<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use App\Traits\GetDataTrait;
use App\Models\CategoryProduct;
use App\Models\CategoryPost;

class ViewServiceProvider extends ServiceProvider
{
    use GetDataTrait;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $setting = new Setting();

            $giatriLenHangDaiLy = optional($setting->find(87))->value;
            $statusTransaction = config('web_default.statusTransaction');
            $shareFrontend = [];
            $shareFrontend['noImage'] = config('web_default.frontend.noImage');
            $shareFrontend['userNoImage'] = config('web_default.frontend.userNoImage');
            $shareFrontend['logo'] = config('web_default.frontend.logo');
            $shareFrontend['favicon'] = config('web_default.frontend.favicon');
            $view->with('shareFrontend', $shareFrontend)
                ->with('statusTransaction', $statusTransaction)
                ->with('giatriLenHangDaiLy', $giatriLenHangDaiLy);
        });
        view()->composer(
            [
                'frontend.pages.home',
                'frontend.pages.notification',
                'frontend.pages.create-post',
                'frontend.pages.edit-post',
                'frontend.pages.list-post',
                'frontend.pages.socialNetwork',
                'frontend.pages.product',
                'frontend.pages.product-detail',
                'frontend.pages.post',
                'frontend.pages.post-detail',
                'frontend.pages.product-new',
                'frontend.pages.product-sale',
                'frontend.pages.cart',
                'frontend.pages.order-sucess',
                'frontend.pages.contact',
                'frontend.pages.about-us',
                'frontend.pages.search',
                'frontend.pages.profile*',
                'auth.*',
                // 'frontend.pages.profile-create-member',
                // 'frontend.pages.profile-edit-info',
                // 'frontend.pages.profile-history',
                // 'frontend.pages.profile-list-member',
                // 'frontend.pages.profile-list-rose',
            ],
            function ($view) {
                $setting = new Setting();
                $header = $this->getDataHeaderTrait($setting);
                $footer = $this->getDataFooterTrait($setting);
                $view->with('header', $header)->with('footer', $footer);
            }
        );
        view()->composer(
            [
                'frontend.pages.product',
                'frontend.pages.product-detail',
                'frontend.pages.post',
                'frontend.pages.post-detail',
            ],
            function ($view) {
                $categoryPost = new CategoryPost();
                $categoryProduct = new CategoryProduct();
                $sidebar = $this->getDataSidebarTrait($categoryPost, $categoryProduct);
                $view->with('sidebar', $sidebar);
            }
        );
    }
}
