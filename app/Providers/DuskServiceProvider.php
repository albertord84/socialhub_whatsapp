<?php

namespace App\Providers;

use Laravel\Dusk\Browser;
use Illuminate\Support\ServiceProvider;

class DuskServiceProvider extends ServiceProvider
{
    /**
     * Register the Dusk's browser macros.
     *
     * @return void
     */
    public function boot()
    {
        Browser::macro('scrollToElement', function ($element = null) {
            $this->script("$('html, body').animate({scrollTop:$('$element').offset().top }, 0);");
            // $this->driver->executeScript("$('html, body').animate({ scrollTop: $('$element').offset().top }, 0);");
            return $this;
        });

        // Browser::macro('scrollToElement', function($selector) {
        //     $this->driver->executeScript("$(\"html, body\").animate({scrollTop: $(\"$selector\").offset().top}, 0);");
        //     // $this->driver->executeScript("$('html, body').animate({scrollTop: $('$selector').offset().top}, 0);");
        //     return $this;
        // });

    }
}


