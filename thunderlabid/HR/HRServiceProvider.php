<?php

namespace Thunderlabid\HR;

/*===============================
=            Laravel            =
===============================*/
use Illuminate\Support\ServiceProvider;
use Exception;
use Event;
use Validator;

use App\Observers\ModelValidationObserver;

/*=====  End of Laravel  ======*/

class HRServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application events.
	 */
	public function boot() {
		/*----------  MIGRATION  ----------*/
		$this->loadMigrationsFrom(__DIR__.'/migrations');

        Absent::observe(new ModelValidationObserver);
	}
}
