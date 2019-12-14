<?php

namespace Thunderlabid\Accounting;

/*===============================
=            Laravel            =
===============================*/
use Illuminate\Support\ServiceProvider;
use Exception;
use Event;
use Validator;

/*=====  End of Laravel  ======*/


class AccountingServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application events.
	 */
	public function boot()
	{
		/*----------  MIGRATION  ----------*/
		$this->loadMigrationsFrom(__DIR__.'/Migration');

		/*----------  OBSERVER  ----------*/
		app()->make(COA::class)::observe(app()->make(Observer\COAObserver::class));
		app()->make(SubsidiaryCOA::class)::observe(app()->make(Observer\SubsidiaryCOAObserver::class));
		app()->make(JournalEntry::class)::observe(app()->make(Observer\JournalEntryObserver::class));
		app()->make(JournalEntryLine::class)::observe(app()->make(Observer\JournalEntryLineObserver::class));
	}

	/**
	 * Register the service provider.
	 */
	public function register()
	{
		$this->app->register(EventServiceProvider::class);
	}
}
