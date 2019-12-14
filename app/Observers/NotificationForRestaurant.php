<?php

namespace App\Observers;

use Illuminate\Validation\ValidationException;
use DB;

use \Thunderlabid\Restaurant\Order;
use \App\Events\RequestRestaurantService;

use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;
use FCM;

class NotificationForRestaurant
{
    //
    public function saved(Order $rs)
    {
    	$notificationBuilder = new PayloadNotificationBuilder('Update For Kitchen');
		$notificationBuilder->setBody(json_encode($rs))
						    ->setSound('default');

		$notification = $notificationBuilder->build();

		$topic = new Topics();
		$topic->topic('restaurant');

		$topicResponse = FCM::sendToTopic($topic, null, $notification, null);
        // event(new RequestRestaurantService($rs));
    }

    public function deleted(Order $rs)
    {
    	$notificationBuilder = new PayloadNotificationBuilder('Update For Kitchen');
		$notificationBuilder->setBody(json_encode($rs))
						    ->setSound('default');

		$notification = $notificationBuilder->build();

		$topic = new Topics();
		$topic->topic('restaurant');

		$topicResponse = FCM::sendToTopic($topic, null, $notification, null);
        // event(new RequestRestaurantService($rs));
    }
}
