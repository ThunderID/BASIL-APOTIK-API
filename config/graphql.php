<?php

use example\Type\ExampleType;
use example\Query\ExampleQuery;
use example\Mutation\ExampleMutation;
use example\Type\ExampleRelationType;

return [

    // The prefix for routes
    'prefix' => 'graphql',

    // The routes to make GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Route
    //
    // Example:
    //
    // Same route for both query and mutation
    //
    // 'routes' => 'path/to/query/{graphql_schema?}',
    //
    // or define each route
    //
    // 'routes' => [
    //     'query' => 'query/{graphql_schema?}',
    //     'mutation' => 'mutation/{graphql_schema?}',
    // ]
    //
    'routes' => '{graphql_schema?}',

    // The controller to use in GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Controller and method
    //
    // Example:
    //
    // 'controllers' => [
    //     'query' => '\Rebing\GraphQL\GraphQLController@query',
    //     'mutation' => '\Rebing\GraphQL\GraphQLController@mutation'
    // ]
    //
    'controllers' => \Rebing\GraphQL\GraphQLController::class.'@query',

    // Any middleware for the graphql route group
    'middleware' => [],

    // Additional route group attributes
    //
    // Example:
    //
    // 'route_group_attributes' => ['guard' => 'api']
    //
    'route_group_attributes' => [],

    // The name of the default schema used when no argument is provided
    // to GraphQL::schema() or when the route is used without the graphql_schema
    // parameter.
    'default_schema' => 'default',

    // The schemas for query and/or mutation. It expects an array of schemas to provide
    // both the 'query' fields and the 'mutation' fields.
    //
    // You can also provide a middleware that will only apply to the given schema
    //
    // Example:
    //
    //  'schema' => 'default',
    //
    //  'schemas' => [
    //      'default' => [
    //          'query' => [
    //              'users' => 'App\GraphQL\Query\UsersQuery'
    //          ],
    //          'mutation' => [
    //
    //          ]
    //      ],
    //      'user' => [
    //          'query' => [
    //              'profile' => 'App\GraphQL\Query\ProfileQuery'
    //          ],
    //          'mutation' => [
    //
    //          ],
    //          'middleware' => ['auth'],
    //      ],
    //      'user/me' => [
    //          'query' => [
    //              'profile' => 'App\GraphQL\Query\MyProfileQuery'
    //          ],
    //          'mutation' => [
    //
    //          ],
    //          'middleware' => ['auth'],
    //      ],
    //  ]
    //
    'schemas' => [
        'default' => [
            'query' => [
                // GLOBAL
                'Users'             => App\GraphQL\Query\Users::class,
                'OrgGroups'         => App\GraphQL\Query\OrgGroups::class,
                'Orgs'              => App\GraphQL\Query\Orgs::class,
                'OrgSettings'       => App\GraphQL\Query\OrgSettings::class,
                'Partners'          => App\GraphQL\Query\Partners::class,
                'UserRoles'         => App\GraphQL\Query\UserRoles::class,
                'Products'          => App\GraphQL\Query\Products::class,

                // PURCHASING
                'PurchasingInvoices'    => App\GraphQL\Query\Purchasing\PurchasingInvoices::class,
                
                ///////////////////////CASHIER///////////////////////
                // GLOBAL
                'CashierSessions'   => Thunderlabid\Cashier\GraphQL\Query\CashierSessions::class,
                // POS
                'POSPoints'         => App\GraphQL\Query\POS\POSPoint::class,
                'POSProducts'       => App\GraphQL\Query\POS\Product::class,
                'POSInvoices'       => App\GraphQL\Query\POS\Invoice::class,
                'POSSettlements'    => App\GraphQL\Query\POS\Settlement::class,
                ///////////////////////CHECKER///////////////////////
                'CheckToken'            => App\GraphQL\Query\CheckToken::class,
                ///////////////////////ACCOUNTANT///////////////////////
                'COAs'                  => App\GraphQL\Query\Accounting\COA::class,
                'SubsidiaryCOAs'        => App\GraphQL\Query\Accounting\SubsidiaryCOA::class,
                'JournalEntrys'         => App\GraphQL\Query\Accounting\JournalEntry::class,

                // STATISTICS
            ],
            'mutation' => [
                // GLOBAL
                // AUTH
                'Authenticate'           => App\GraphQL\Mutation\User\Authenticate::class,
                'ForgetPassword'         => App\GraphQL\Mutation\User\ForgetPassword::class,
                'ResetPasswordWithToken' => App\GraphQL\Mutation\User\ResetPasswordWithToken::class,
                'UpdateMyProfile'        => App\GraphQL\Mutation\User\UpdateMyProfile::class,
                'UpdateMyPassword'       => App\GraphQL\Mutation\User\UpdateMyPassword::class,
                'Register'               => App\GraphQL\Mutation\User\Register::class,
                'StoreBio'               => App\GraphQL\Mutation\User\StoreBio::class,
                // ORG
                'StoreOrgGroup'             => App\GraphQL\Mutation\StoreOrgGroup::class,
                'StoreOrg'                  => App\GraphQL\Mutation\StoreOrg::class,
                'StoreProduct'              => App\GraphQL\Mutation\StoreProduct::class,
                'DeleteProduct'             => App\GraphQL\Mutation\DeleteProduct::class,
                
                'StorePartner'              => App\GraphQL\Mutation\StorePartner::class,
                'DeletePartner'             => App\GraphQL\Mutation\DeletePartner::class,
                'StoreUserRole'             => App\GraphQL\Mutation\StoreUserRole::class,
                'DeleteUserRole'            => App\GraphQL\Mutation\DeleteUserRole::class,
                'StoreOrgSetting'           => App\GraphQL\Mutation\StoreOrgSetting::class,
                //  PURCHASING
                'StorePurchasingInvoice'    => App\GraphQL\Mutation\Purchasing\StorePurchasingInvoice::class,
                ///////////////////////CASHIER///////////////////////
                // GLOBAL
                'OpenCashierSession'    => Thunderlabid\Cashier\GraphQL\Mutation\OpenCashierSession::class,
                'CloseCashierSession'   => Thunderlabid\Cashier\GraphQL\Mutation\CloseCashierSession::class,
                // POS
                'POSStorePoint'         => App\GraphQL\Mutation\POS\POSPoint\Store::class,
                'POSDeletePoint'        => App\GraphQL\Mutation\POS\POSPoint\Delete::class,
                'POSStoreProduct'       => App\GraphQL\Mutation\POS\Product\Store::class,
                'POSDeleteProduct'      => App\GraphQL\Mutation\POS\Product\Delete::class,
                'POSAddPrice'           => App\GraphQL\Mutation\POS\Product\Price\Add::class,
                'POSRemovePrice'        => App\GraphQL\Mutation\POS\Product\Price\Delete::class,
                'POSStoreInvoice'       => App\GraphQL\Mutation\POS\Invoice\Store::class,
                'POSDeleteInvoice'      => App\GraphQL\Mutation\POS\Invoice\Delete::class,
                'POSStoreSettlement'    => App\GraphQL\Mutation\POS\Settlement\Store::class,
                'POSDeleteSettlement'   => App\GraphQL\Mutation\POS\Settlement\Delete::class,
                // RESTO
                // WMS
                ///////////////////////HK///////////////////////
                ///////////////////////CHECKER///////////////////////
                ///////////////////////ACCOUNTANT///////////////////////
                'StoreCOA'              => App\GraphQL\Mutation\Accounting\COA\Store::class,
                'DeleteCOA'             => App\GraphQL\Mutation\Accounting\COA\Delete::class,
                'StoreSubsidiaryCOA'    => App\GraphQL\Mutation\Accounting\SubsidiaryCOA\Store::class,
                'DeleteSubsidiaryCOA'   => App\GraphQL\Mutation\Accounting\SubsidiaryCOA\Delete::class,
                'StoreJournalEntry'     => App\GraphQL\Mutation\Accounting\JournalEntry\Store::class,
                'CancelJournalEntry'    => App\GraphQL\Mutation\Accounting\JournalEntry\Cancel::class,
                ///////////////////////AUTH///////////////////////
                
            ],
            'middleware' => [],
            'method'     => ['get', 'post'],
        ],
    ],

    // The types available in the application. You can then access it from the
    // facade like this: GraphQL::type('user')
    //
    // Example:
    //
    // 'types' => [
    //     'user' => 'App\GraphQL\Type\UserType'
    // ]
    //
    'types' => [
        // GLOBAL
        'OrgSetting'          => App\GraphQL\Type\OrgSetting::class,
        'OrgSettingPOS'       => App\GraphQL\Type\OrgSettingPOS::class,
        'OrgGroup'            => App\GraphQL\Type\OrgGroup::class,
        'Org'                 => App\GraphQL\Type\Org::class,
        'Geolocation'         => App\GraphQL\Type\Geolocation::class,
        'Partner'             => App\GraphQL\Type\Partner::class,
        'Login'               => App\GraphQL\Type\Login::class,
        'User'                => App\GraphQL\Type\User::class,
        'Bio'                 => App\GraphQL\Type\Bio::class,
        'Role'                => App\GraphQL\Type\Role::class,
        'Product'             => App\GraphQL\Type\Product::class,

        // PURCHASING
        'PurchasingInvoice'     => App\GraphQL\Type\Purchasing\PurchasingInvoice::class,
        'PurchasingInvoiceLine' => App\GraphQL\Type\Purchasing\PurchasingInvoiceLine::class,
        'IPurchasingInvoiceLine'=> App\GraphQL\Type\Purchasing\IPurchasingInvoiceLine::class,
        'PurchasingInvoiceTax'  => App\GraphQL\Type\Purchasing\PurchasingInvoiceTax::class,
        'IPurchasingInvoiceTax' => App\GraphQL\Type\Purchasing\IPurchasingInvoiceTax::class,
       ///////////////////////CASHIER///////////////////////
        // GLOBAL
        'CashierSession'      => Thunderlabid\Cashier\GraphQL\Type\CashierSession::class,
        'CashierLog'          => Thunderlabid\Cashier\GraphQL\Type\CashierLog::class,
        // POS
        'POSPoint'            => Thunderlabid\POS\GraphQL\POSPoint\Type\POSPointType::class,
        'POSPointSetting'     => Thunderlabid\POS\GraphQL\POSPoint\Type\POSPointSettingType::class,
        'POSProduct'          => Thunderlabid\POS\GraphQL\Product\Type\ProductType::class,
        'POSPrice'            => Thunderlabid\POS\GraphQL\Product\Type\PriceType::class,
        'POSInvoice'          => Thunderlabid\POS\GraphQL\Invoice\Type\InvoiceType::class,
        'POSInvoiceLine'      => Thunderlabid\POS\GraphQL\Invoice\Type\InvoiceLineType::class,
        'POSIInvoiceLine'     => Thunderlabid\POS\GraphQL\Invoice\Type\IInvoiceLineType::class,
        'POSSettlement'       => Thunderlabid\POS\GraphQL\Settlement\Type\SettlementType::class,
        // RESTO
        // WMS
        ///////////////////////HK///////////////////////
        ///////////////////////REPORT///////////////////////
        ///////////////////////ACCOUNTANT///////////////////////
        'COA'                 => Thunderlabid\Accounting\GraphQL\COA\Type\COAType::class,
        'SubsidiaryCOA'       => Thunderlabid\Accounting\GraphQL\SubsidiaryCOA\Type\SubsidiaryCOAType::class,
        'JournalEntry'        => Thunderlabid\Accounting\GraphQL\JournalEntry\Type\JournalEntryType::class,
        'JournalEntryLine'    => Thunderlabid\Accounting\GraphQL\JournalEntry\Type\JournalEntryLineType::class,
        'IJournalEntryLine'   => Thunderlabid\Accounting\GraphQL\JournalEntry\Type\IJournalEntryLineType::class,
        // STATISTICS
    ],

    // This callable will be passed the Error object for each errors GraphQL catch.
    // The method should return an array representing the error.
    // Typically:
    // [
    //     'message' => '',
    //     'locations' => []
    // ]
    // 'error_formatter' => ['\Rebing\GraphQL\GraphQL', 'formatError'],
    'error_formatter' => ['\App\GraphQL\GQLErrorFormatter', 'formatError'],

    /*
     * Custom Error Handling
     *
     * Expected handler signature is: function (array $errors, callable $formatter): array
     *
     * The default handler will pass exceptions to laravel Error Handling mechanism
     */
    'errors_handler' => ['\Rebing\GraphQL\GraphQL', 'handleErrors'],

    // You can set the key, which will be used to retrieve the dynamic variables
    'params_key'    => 'variables',

    /*
     * Options to limit the query complexity and depth. See the doc
     * @ https://github.com/webonyx/graphql-php#security
     * for details. Disabled by default.
     */
    'security' => [
        'query_max_complexity'  => null,
        'query_max_depth'       => null,
        'disable_introspection' => false,
    ],

    /*
     * You can define your own pagination type.
     * Reference \Rebing\GraphQL\Support\PaginationType::class
     */
    'pagination_type' => \Rebing\GraphQL\Support\PaginationType::class,

    /*
     * Config for GraphiQL (see (https://github.com/graphql/graphiql).
     */
    'graphiql' => [
        'prefix'     => '/graphiql/{graphql_schema?}',
        'controller' => \Rebing\GraphQL\GraphQLController::class.'@graphiql',
        'middleware' => [],
        'view'       => 'graphql::graphiql',
        'display'    => env('ENABLE_GRAPHIQL', true),
    ],

    /*
     * Overrides the default field resolver
     * See http://webonyx.github.io/graphql-php/data-fetching/#default-field-resolver
     *
     * Example:
     *
     * ```php
     * 'defaultFieldResolver' => function ($root, $args, $context, $info) {
     * },
     * ```
     * or
     * ```php
     * 'defaultFieldResolver' => [SomeKlass::class, 'someMethod'],
     * ```
     */
    'defaultFieldResolver' => null,

    /*
     * Any headers that will be added to the response returned by the default controller
     */
    'headers' => [],

    /*
     * Any JSON encoding options when returning a response from the default controller
     * See http://php.net/manual/function.json-encode.php for the full list of options
     */
    'json_encoding_options' => 0,
];
