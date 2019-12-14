<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Authentication Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines are used during authentication for various
	| messages that we need to display to the user. You are free to modify
	| these language lines according to your application's requirements.
	|
	*/

	'NoRole'									=> 'Tenant harus sedikitnya berupa \'principle\' dan atau \'distributor\', atau \'store\' dan atau \'warehouse\' dan atau \'pickup_point\'',
	'InvalidRole'							=> 'Tenant hanya bisa berupa [\'principle\' dan atau \'distributor\'], atau [\'store\' dan atau \'warehouse\' dan atau \'pickup_point\']',
	'linkToInvalidTenantType'	=> 'Tenant store hanya bisa dilink ke tenant warehouse tapi bukan store',
	'noLinkSelf'							=> 'Tenant tidak bisa dilink dengan dirinya sendiri',
	'noSwitchType'						=> 'Tenant principle/distributor tidak bisa berubah menjadi store/warehouse/pickup_point dan sebaliknya',

];
