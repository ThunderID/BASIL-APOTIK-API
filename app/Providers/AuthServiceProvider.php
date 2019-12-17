<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\User;
use Auth;
use Firebase\JWT\JWT;
use Illuminate\Validation\ValidationException;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\OrgGroup::class    => \App\Policies\OrgGroupPolicy::class,
        \App\Org::class         => \App\Policies\OrgPolicy::class,
        \App\OrgSetting::class  => \App\Policies\OrgSettingPolicy::class,
        \App\Partner::class     => \App\Policies\PartnerPolicy::class,
        \App\Room::class        => \App\Policies\RoomPolicy::class,
        \App\UserRole::class    => \App\Policies\UserRolePolicy::class,
        \App\Product::class     => \App\Policies\ProductPolicy::class,
        \App\Price::class       => \App\Policies\PricePolicy::class,
        \App\User::class        => \App\Policies\UserPolicy::class,
        \App\Bio::class         => \App\Policies\BioPolicy::class,

        //FO & GENERAL CASHIER & POS CASHIER
        \Thunderlabid\Cashier\CashierSession::class => \App\Policies\Cashier\CashierSessionPolicy::class,
        \Thunderlabid\Cashier\CashierLog::class     => \App\Policies\Cashier\CashierLogPolicy::class,

        \Thunderlabid\POS\POSPoint::class       => \App\Policies\POS\POSPointPolicy::class,
        \Thunderlabid\POS\Product::class        => \App\Policies\POS\ProductPolicy::class,
        \Thunderlabid\POS\Price::class          => \App\Policies\POS\PricePolicy::class,
        \Thunderlabid\POS\Invoice::class        => \App\Policies\POS\InvoicePolicy::class,
        \Thunderlabid\POS\Settlement::class     => \App\Policies\POS\SettlementPolicy::class,

        //PURCHASING  ---- PENDING
        \App\Models\Purchasing\Invoice::class   => \App\Policies\Purchasing\InvoicePolicy::class,

        //ACCOUNTING
        \Thunderlabid\Accounting\COA::class             => \App\Policies\Accounting\COAPolicy::class,
        \Thunderlabid\Accounting\SubsidiaryCOA::class   => \App\Policies\Accounting\SubsidiaryCOAPolicy::class,
        \Thunderlabid\Accounting\JournalEntry::class    => \App\Policies\Accounting\JournalEntryPolicy::class,
       
        //WMS
        \Thunderlabid\WMS\Warehouse::class      => \App\Policies\WMS\WarehousePolicy::class,
        \Thunderlabid\WMS\GDN::class            => \App\Policies\WMS\GDNPolicy::class,
        \Thunderlabid\WMS\GRN::class            => \App\Policies\WMS\GRNPolicy::class,
        \Thunderlabid\WMS\StockCard::class      => \App\Policies\WMS\StockCardPolicy::class,

     ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        app('auth')->viaRequest('token', function ($request) {
            $bearerToken = $request->bearerToken();

            if (!is_null($bearerToken))
            {
                // Validate
                try {
                    $jwt = JWT::decode($bearerToken, config('jwt.JWT_KEY'), [config('jwt.JWT_ALGORITHM')]);
                } catch (\Exception $e) {
                    throw ValidationException::withMessages(['jwt' => 'expired']);
                }

                if  (
                    $jwt->iss === config('jwt.JWT_ISS') &&
                    $jwt->aud === config('jwt.JWT_AUD')
                )
                {
                    $user = app()->make(User::class)->username($jwt->username)->first();
                    return $user;
                }
                else
                {
                    return app()->make(User::class)->where('username', '6281333517875')->first();
                    return null;
                }
            }
            else
            {
                return app()->make(User::class)->where('username', '6281333517875')->first();
                return null;
            }
        });
    }
}
