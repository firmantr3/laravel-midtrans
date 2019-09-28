<?php 

namespace Firmantr3\Midtrans;

use Exception;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\CoreApi;
use Midtrans\Notification;
use Midtrans\Transaction;

class Midtrans {

    /**
     * Initialize Midtrans
     */
    public function __construct()
    {
        self::registerMidtransConfig();
    }

    /**
     * Register all midtrans config
     *
     * @return void
     */
    public static function registerMidtransConfig() {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isSanitized = config('midtrans.sanitize') == 'true';
        Config::$is3ds = config('midtrans.3ds') == 'true';
        Config::$curlOptions = config('midtrans.curl_options');
        $configEnv = config('midtrans.env');
        Config::$isProduction = ($configEnv === '' ? app()->environment() : $configEnv) == 'production';
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
     * Retrieve transaction status
     * 
     * @param string $id Order ID or transaction ID
     * 
     * @return mixed[]
     */
    public function status($id) {
        return Transaction::status($id);
    }

    /**
     * Approve challenge transaction
     * 
     * @param string $id Order ID or transaction ID
     * 
     * @return string
     */
    public function approve($id)
    {
        return Transaction::approve($id);
    }

    /**
     * Cancel transaction before it's settled
     * 
     * @param string $id Order ID or transaction ID
     * 
     * @return string
     */
    public function cancel($id)
    {
        return Transaction::cancel($id);
    }

    /**
     * Expire transaction before it's setteled
     * 
     * @param string $id Order ID or transaction ID
     * 
     * @return mixed[]
     */
    public function expire($id)
    {
        return Transaction::expire($id);
    }

    /**
     * Transaction status can be updated into refund
     * if the customer decides to cancel completed/settlement payment.
     * The same refund id cannot be reused again.
     * 
     * @param string $id Order ID or transaction ID
     * 
     * @return mixed[]
     */
    public function refund($id)
    {
        return Transaction::refund($id);
    }

    /**
     * Deny method can be triggered to immediately deny card payment transaction
     * in which fraud_status is challenge.
     * 
     * @param string $id Order ID or transaction ID
     * 
     * @return mixed[]
     */
    public function deny($id)
    {
        return Transaction::deny($id);
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
