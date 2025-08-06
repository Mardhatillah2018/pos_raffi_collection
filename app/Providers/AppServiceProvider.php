<?php

namespace App\Providers;

use App\Models\LogStok;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
        App::setLocale('id');
        Carbon::setLocale('id');
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $kodeCabang = Auth::user()->kode_cabang;

                $jumlahPendingPengurangan = LogStok::where('jenis', 'keluar')
                    ->where('status', 'menunggu')
                    ->where('sumber', 'pengurangan')
                    ->where('kode_cabang', $kodeCabang)
                    ->count();

                $view->with('jumlahPendingPengurangan', $jumlahPendingPengurangan);
            }
        });
    }
}
