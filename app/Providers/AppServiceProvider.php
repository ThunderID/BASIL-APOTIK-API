<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Observers\ModelValidationObserver;
use Illuminate\Support\Facades\Blade;


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
        $this->loadMigrationsFrom(database_path('migrations\purchasing'));

        /*------------------------------------------------------------------------------------------------------------------------------*/
        /* PRE VALIDATE */
        /*------------------------------------------------------------------------------------------------------------------------------*/
        \App\Bio::observe(new \App\Observers\User\CreateUser);
        \App\User::observe(new \App\Observers\User\CreateBio);

        /*------------------------------------------------------------------------------------------------------------------------------*/
        /* VALIDATE */
        /*------------------------------------------------------------------------------------------------------------------------------*/
        // GLOBAL
        \App\User::observe(new ModelValidationObserver);
        \App\Bio::observe(new ModelValidationObserver);
        \App\UserRole::observe(new ModelValidationObserver);
        \App\UserToken::observe(new ModelValidationObserver);
        \App\Org::observe(new ModelValidationObserver);
        \App\OrgSetting::observe(new ModelValidationObserver);
        \App\OrgGroup::observe(new ModelValidationObserver);
        \App\Partner::observe(new ModelValidationObserver);
        \App\Product::observe(new ModelValidationObserver);
        \App\Price::observe(new ModelValidationObserver);
        
        // PURCHASING
        \App\Models\Purchasing\Invoice::observe(new ModelValidationObserver);
       
        /*------------------------------------------------------------------------------------------------------------------------------*/
        /* POST VALIDATE */
        /*------------------------------------------------------------------------------------------------------------------------------*/
        \App\User::observe(new \App\Observers\User\PasswordObserver);
        // \App\User::observe(new \App\Observers\User\NewUserObserver);
        // \App\UserToken::observe(new \App\Observers\User\UserTokenCreatedObserver);
        // Cannot change org
        \App\Org::observe(new \App\Observers\Org\CannotChangeOrgGroup);
        // \App\Org::observe(new \App\Observers\Org\SetDefaultOrgSetting);
        \App\Org::observe(new \App\Observers\WMS\Warehouse\SetDefaultWarehouse);

        // POS CASHIER
        \Thunderlabid\POS\Invoice::observe(new \App\Observers\POS\Invoice\SetNo);
        \Thunderlabid\POS\Invoice::observe(new \Thunderlabid\POS\Observer\InvoiceObserver);
        \Thunderlabid\POS\Invoice::observe(new \App\Observers\POS\Invoice\SetTax);
        \Thunderlabid\POS\Settlement::observe(new \App\Observers\POS\Settlement\SetNo);
        \Thunderlabid\POS\Settlement::observe(new \App\Observers\POS\CashierLogFromSettlement);

        // PURCHASING
        \App\Models\Purchasing\Invoice::observe(new \App\Observers\Purchasing\Invoice\SetNo);
        \App\Models\Purchasing\Invoice::observe(new \App\Observers\WMS\GRN\UpdateGRN);

        // AUTH - APPROVAL
        /*=============================
        =            Blade            =
        =============================*/
        Blade::include('admin.components.template.input', 'input');
        Blade::include('admin.components.template.button', 'button');
        Blade::include('admin.components.template.stats', 'stats');
        Blade::include('admin.components.common.alerts', 'alerts');
        /*=====  End of Blade  ======*/
        
    }
}
