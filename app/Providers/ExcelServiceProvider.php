<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Excel;

class ExcelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('excel', function($app) {
            return new Excel($app['phpexcel'], $app['creator'], $app['reader'], $app['writer'], $app['phpexcel.writer.excel5'], $app['phpexcel.writer.excel2007'], $app['phpexcel.writer.csv']);
        });
    }
}
