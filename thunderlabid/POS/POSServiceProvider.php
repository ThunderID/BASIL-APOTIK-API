<?php

namespace Thunderlabid\POS;

/*===============================
=            Laravel            =
===============================*/
use Illuminate\Support\ServiceProvider;
use Exception;
use Event;
use Validator;

/*=====  End of Laravel  ======*/

class POSServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application events.
	 */
	public function boot()
	{
		/*----------  MIGRATION  ----------*/
		$this->loadMigrationsFrom(__DIR__.'/Migration');


		/*----------  OBSERVER  ----------*/
		// Basic Observer
		app()->make(POSPoint::class)::observe(app()->make(Observer\ValidationObserver::class));
		app()->make(Product::class)::observe(app()->make(Observer\ValidationObserver::class));
		app()->make(Price::class)::observe(app()->make(Observer\ValidationObserver::class));
		app()->make(Invoice::class)::observe(app()->make(Observer\ValidationObserver::class));
		app()->make(Settlement::class)::observe(app()->make(Observer\ValidationObserver::class));

		// Model Observer
		app()->make(POSPoint::class)::observe(app()->make(Observer\POSPointObserver::class));
		app()->make(Product::class)::observe(app()->make(Observer\ProductObserver::class));
		app()->make(Price::class)::observe(app()->make(Observer\PriceObserver::class));
		app()->make(Invoice::class)::observe(app()->make(Observer\InvoiceObserver::class));
		app()->make(Settlement::class)::observe(app()->make(Observer\SettlementObserver::class));
	}

	/**
	 * Register the service provider.
	 */
	public function register()
	{
		$this->app->register(EventServiceProvider::class);
	}
}
