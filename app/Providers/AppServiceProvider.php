<?php

namespace App\Providers;

use App\Models\LogStok;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
        $jumlahPendingPengurangan = LogStok::where('jenis', 'keluar')
            ->where('status', 'menunggu')
            ->where('sumber', 'pengurangan')
            ->count();

        $view->with('jumlahPendingPengurangan', $jumlahPendingPengurangan);
    });
    }
}
