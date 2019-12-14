<?php

namespace App\Models\Pricing;

use \App\Product as Model;
use Illuminate\Validation\Rule;
use DB;

class RoomItem extends Model
{
	/**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new \App\Scopes\RoomItemScope);
    }

	public function price() {
		return $this->hasOne(RoomItemPrice::class, 'room_item_id')->where('started_at', '<=', now())->orderby('started_at', 'desc')->orderby('created_at', 'desc');
	}

	public function prices() {
		return $this->hasMany(RoomItemPrice::class, 'room_item_id');
	}
}
