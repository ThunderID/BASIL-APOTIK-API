<?php

namespace Thunderlabid\WMS;

/*===============================
=            Laravel            =
===============================*/
use Illuminate\Support\ServiceProvider;
use Exception;
use Event;
use Validator;

/*=====  End of Laravel  ======*/

class WMSServiceProvider extends ServiceProvider
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
		app()->make(Warehouse::class)::observe(app()->make(Observer\ValidationObserver::class));
		app()->make(Product::class)::observe(app()->make(Observer\ValidationObserver::class));
		app()->make(GRN::class)::observe(app()->make(Observer\ValidationObserver::class));
		app()->make(GDN::class)::observe(app()->make(Observer\ValidationObserver::class));
		app()->make(StockCard::class)::observe(app()->make(Observer\ValidationObserver::class));

		// Model Observer
		app()->make(Warehouse::class)::observe(app()->make(Observer\WarehouseObserver::class));
		app()->make(Product::class)::observe(app()->make(Observer\ProductObserver::class));
		app()->make(GRN::class)::observe(app()->make(Observer\GRNObserver::class));
		app()->make(GDN::class)::observe(app()->make(Observer\GDNObserver::class));
		app()->make(StockCard::class)::observe(app()->make(Observer\StockCardObserver::class));
	}

	/**
	 * Register the service provider.
	 */
	public function register()
	{
		$this->app->register(EventServiceProvider::class);
	}
}
