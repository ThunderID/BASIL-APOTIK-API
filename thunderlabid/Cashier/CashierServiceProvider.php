<?php

namespace Thunderlabid\Cashier;

/*===============================
=            Laravel            =
===============================*/
use Illuminate\Support\ServiceProvider;
use Exception;
use Event;
use Validator;

use App\Observers\ModelValidationObserver;

/*=====  End of Laravel  ======*/

class CashierServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application events.
	 */
	public function boot() {
		/*----------  MIGRATION  ----------*/
		$this->loadMigrationsFrom(__DIR__.'/migrations');

        CashierSession::observe(new ModelValidationObserver);
        CashierLog::observe(new ModelValidationObserver);
	}
}
