<?php

namespace App\Observers;

use Illuminate\Validation\ValidationException;
use DB;

use \Thunderlabid\Restaurant\OrderLine;
use \App\Events\RequestRestaurantService;

use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;
use FCM;

class NotificationForKitchen
{
    //
    public function saved(OrderLine $rs)
    {
    	$notificationBuilder = new PayloadNotificationBuilder('Update For Kitchen');
		$notificationBuilder->setBody(json_encode($rs->order))
						    ->setSound('default');

		$notification = $notificationBuilder->build();

		$topic = new Topics();
		$topic->topic('restaurant');

		$topicResponse = FCM::sendToTopic($topic, null, $notification, null);
        // event(new RequestRestaurantService($rs->order));
    }

    public function deleted(OrderLine $rs)
    {
    	$notificationBuilder = new PayloadNotificationBuilder('Update For Kitchen');
		$notificationBuilder->setBody(json_encode($rs->order))
						    ->setSound('default');

		$notification = $notificationBuilder->build();

		$topic = new Topics();
		$topic->topic('restaurant');

		$topicResponse = FCM::sendToTopic($topic, null, $notification, null);
		
        // event(new RequestRestaurantService($rs->order));
    }
}
