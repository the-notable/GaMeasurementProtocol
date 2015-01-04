# Google Analytics Measurement Protocol

This package is incomplete. Currently only supports 'event' hit types.

Usage is as follows:

```php
$hit_type = 'event';
$tracking_id = 'youranalyticstrackingid';
$client_id = 'uniqueuserid'; //can set to true and a random v4UUID will be generated for you
$user_agent = 'youruseragentinfo';

$HitFactory = new Notable\GaMeasurementProtocol\HitFactory();
$HitObject = $HitFactory->get($hit_type, $tracking_id, $client_id);

$Uri = new Notable\GaMeasurementProtocol\Uri();
$Uri->setUseSsl(true); //if you dont want ssl ignore this step, default value is false

$PostRequest = new Notable\GaMeasurementProtocol\PostRequest($Uri, $user_agent);
if(!$PostRequest->send($HitObject){
    $curl_info = $PostRequent->getCurlInfo();
}
```