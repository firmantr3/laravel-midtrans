<?php

namespace Firmantr3\Midtrans;

use Firmantr3\Midtrans\Facade\Midtrans;

/**
 * Read raw post input and parse as JSON. Provide getters for fields in notification object
 *
 * Example:
 *
 * ```php
 *
 *   namespace Firmantr3\Midtrans;
 *
 *   $notif = new Notification();
 *   echo $notif->order_id;
 *   echo $notif->transaction_status;
 * ```
 */
class Notification
{
    private $response;

    public function __construct($input_source = "php://input")
    {
        $raw_notification = json_decode(Midtrans::input($input_source), true);
        $status_response = Midtrans::status($raw_notification['transaction_id']);
        $this->response = $status_response;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->response)) {
            return $this->response->$name;
        }
    }
}
