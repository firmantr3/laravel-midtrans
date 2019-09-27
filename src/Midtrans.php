<?php 

namespace Firmantr3\Midtrans;

use Exception;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\CoreApi;
use Midtrans\Notification;

class Midtrans {

    /**
     * Initialize Midtrans
     */
    public function __construct()
    {
        $this->registerMidtransConfig();
    }

    /**
     * Register all midtrans config
     *
     * @return void
     */
    public function registerMidtransConfig() {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isSanitized = config('midtrans.sanitize') == 'true';
        Config::$is3ds = config('midtrans.3ds') == 'true';
        Config::$curlOptions = config('midtrans.curl_options');
        Config::$isProduction = config('midtrans.env') == 'production';
    }

    /**
     * Create Snap payment page
     *
     * @param  array $params Payment options
     * @return string Snap token.
     * @throws Exception curl error or midtrans error
     */
    public function getSnapToken($params) {
        return Snap::getSnapToken($params);
    }

    /**
     * Create Snap payment page, with this version returning full API response
     *
     * @param  array $params Payment options
     * @return object Snap response (token and redirect_url).
     * @throws Exception curl error or midtrans error
     */
    public function createTransaction($params)
    {
        return Snap::createTransaction($params);
    }

    /**
     * Create transaction.
     *
     * @param mixed[] $params Transaction options
     */
    public function charge($params)
    {
        return CoreApi::charge($params);
    }

    /**
     * Capture pre-authorized transaction
     *
     * @param string $param Order ID or transaction ID, that you want to capture
     */
    public function capture($param)
    {
        return CoreApi::capture($param);
    }

    /**
     * Get incoming notification (web hook)
     *
     * @return Notification
     */
    public function notification($input_source = "php://input") {
        return new Notification($input_source);
    }

    /**
     * Get midtrans client key config value
     *
     * @return string
     */
    public function clientKey() {
        return config('midtrans.client_key');
    }

}
