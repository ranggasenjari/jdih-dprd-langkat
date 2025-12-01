<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use App\Models\Visitor;
use App\Models\Post;
use App\View\Composers\FooterComposer;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ================================
        // PROTECT QUERY: ONLY IF TABLE EXISTS
        // ================================
        $settings = [];

        if (Schema::hasTable('settings')) {
            $settings = Setting::pluck('value', 'key')->toArray();

            $settings['appLogoUrl'] = isset($settings['appLogo'])
                ? (Storage::disk('public')->exists($settings['appLogo'])
                    ? Storage::url($settings['appLogo'])
                    : '/assets/admin/images/logo_icon.svg')
                : '/assets/admin/images/logo_icon.svg';

            $settings['jdihnLogoUrl'] = isset($settings['jdihnLogo'])
                ? (Storage::disk('public')->exists($settings['jdihnLogo'])
                    ? Storage::url($settings['jdihnLogo'])
                    : '/assets/admin/images/jdihn-logo-web.png')
                : '/assets/admin/images/jdihn-logo-web.png';

            // Hindari implode error jika field belum ada
            $settings['fullAddress'] = implode(', ', array_filter([
                $settings['address'] ?? null,
                $settings['city'] ?? null,
                $settings['district'] ?? null,
                $settings['regency'] ?? null,
                $settings['province'] ?? null,
            ]));
        }

        View::share($settings);


        // Footer composer aman selama table pengunjung dan post ada
        View::composer(
            ['jdih.layouts.footer', 'jdih.legislation.leftbar'],
            FooterComposer::class
        );

        // ================================
        // PROTECT VIEW COMPOSER DATABASE QUERIES
        // ================================
        View::composer('jdih.layouts.footer', function ($view) {

            $todayVisitor = $yesterdayVisitor = $lastWeekVisitor = $lastMonthVisitor = $allVisitor = 0;
            $welcome = null;

            if (Schema::hasTable('visitors')) {
                $todayVisitor = Visitor::countDaily()->count();
                $yesterdayVisitor = Visitor::countDaily(1)->count();
                $lastWeekVisitor = Visitor::countWeekly()->count();
                $lastMonthVisitor = Visitor::countMonthly()->count();
                $allVisitor = Visitor::countAll()->count();
            }

            if (Schema::hasTable('posts')) {
                $welcome = Post::whereSlug('selamat-datang')->first();
            }

            return $view
                ->with('todayVisitor', $todayVisitor)
                ->with('yesterdayVisitor', $yesterdayVisitor)
                ->with('lastWeekVisitor', $lastWeekVisitor)
                ->with('lastMonthVisitor', $lastMonthVisitor)
                ->with('allVisitor', $allVisitor)
                ->with('welcome', $welcome);
        });
    }
}
