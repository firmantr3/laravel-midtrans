<?php

namespace Firmantr3\Midtrans\Test;

use Firmantr3\Midtrans\Facade\Midtrans;
use Midtrans\Notification;
use Midtrans\VT_Tests;

class NotificationTest extends TestCase
{
    const TEST_CAPTURE_JSON = '{
        "status_code" : "200",
        "status_message" : "Midtrans payment notification",
        "transaction_id" : "826acc53-14e0-4ae7-95e2-845bf0311579",
        "order_id" : "2014040745",
        "payment_type" : "credit_card",
        "transaction_time" : "2014-04-07 16:22:36",
        "transaction_status" : "capture",
        "fraud_status" : "accept",
        "masked_card" : "411111-1111",
        "gross_amount" : "2700"
    }';

    public function testCanWorkWithJSON()
    {
        $tmpfname = tempnam(sys_get_temp_dir(), "midtrans_test");
        file_put_contents($tmpfname, self::TEST_CAPTURE_JSON);

        VT_Tests::$stubHttp = true;
        VT_Tests::$stubHttpResponse = self::TEST_CAPTURE_JSON;

        $notif = Midtrans::notification($tmpfname);

        $this->assertTrue($notif instanceof Notification);

        $this->assertEquals($notif->transaction_status, "capture");
        $this->assertEquals($notif->payment_type, "credit_card");
        $this->assertEquals($notif->order_id, "2014040745");
        $this->assertEquals($notif->gross_amount, "2700");

        unlink($tmpfname);
    }
}
