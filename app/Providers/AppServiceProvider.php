<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // التعريف بالمكون: المعامل الأول هو مسار المكون،
        //  والمعامل الثاني هو اسم المكون المزيف
        // حيث تم استخدام هذا المكون في ملف show.blade.php

        //يجب تسجيل جميع المكونات هنا
        //بحيث يكون المعامل الأول هو مسار المكون
        //والمعامل الثاني هو الاسم المزيف له
        //ويمكن لك حينها استدائه من جيمع المناظر 
        Blade::component('components.badge', 'badge');
        Blade::component('components.updated', 'updated');
        Blade::component('components.card', 'card');
        Blade::component('components.tags', 'tags');
        Blade::component('components.errors', 'errors');

        view()->composer(['posts.index', 'posts.show'], ActivityComposer::class);
    }
}
