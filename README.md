# Google Analytics Measurement Protocol

This package is incomplete. Currently only supports 'event' hit types.

Usage is as follows:

```php
$hit_type = 'event';
$tracking_id = 'youranalyticstrackingid';
$client_id = 'uniqueuserid'; //can set to true and a random v4UUID will be generated for you
$user_agent = 'youruseragentinfo';

$HitFactory = new Notable\GaMeasurementProtocol\HitFactory();
$EventHitObject = $HitFactory->get($hit_type, $tracking_id, $client_id);
$EventHitObject
    ->setNonInteractionHit(true)
	->setUserId($User->userId) //just an example, different from $client_id above
	->setEventCategory('Account Events')
	->setEventAction('Subscription Deleted');
		
$PostRequest = new Notable\GaMeasurementProtocol\PostRequest($user_agent); //Optionally set second param to 'true' to make an SSL request
if(!$PostRequest->send($EventHitObject){
    $curl_info = $PostRequest->getCurlInfo();
}
```