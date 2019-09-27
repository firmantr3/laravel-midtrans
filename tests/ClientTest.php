<?php 

namespace Firmantr3\Midtrans\Test;

use Firmantr3\Midtrans\Facade\Midtrans;

class ClientTest extends TestCase {

    public function testClientKey() {
        config([
            'midtrans.client_key' => 'My Client Key',
        ]);

        $this->assertEquals('My Client Key', Midtrans::clientKey());
    }

}
