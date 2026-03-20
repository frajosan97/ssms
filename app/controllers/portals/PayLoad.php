<?php

class PayLoad
{
    private $consumerKey = 'rRblUMGV7tG0Ym5uuHUvs9SynGfcJkIB';
    private $consumerSecret = '1OUCuCmle001AOLT';
    private $passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
    private $shortcode = '174379';
    private $callBackUrl = 'https://payload.frajosantech.co.ke/callback_url.php';
    private $confirmationUrl = 'https://payload.frajosantech.co.ke/confirmation_url.php';
    private $validationUrl = 'https://payload.frajosantech.co.ke/validation_url.php';

    public function index()
    {
        $phoneNumber = '254796594366'; // Customer's phone number
        $amount = 1; // Amount to be paid
        $callbackUrl = $this->callBackUrl; // Call back url
        $response = $this->initiateMpesaSTKPush($phoneNumber, $amount, $callbackUrl);
        // $response['ResponseCode'] = 0;
        return $response;
    }

    public function registerUrl()
    {
        $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';

        $curl_post_data = [
            'ShortCode' => $this->shortcode,
            'ResponseType' => 'Completed',
            'ConfirmationURL' => $this->confirmationUrl,
            'ValidationURL' => $this->validationUrl
        ];

        $response = $this->sendRequest($url, $curl_post_data);

        return $response;
    }

    public function b2c()
    {

    }

    public function initiateMpesaSTKPush($phoneNumber, $amount, $callbackUrl)
    {
        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $curl_post_data = [
            'BusinessShortCode' => $this->shortcode,
            'Password' => $this->generatePassword(),
            'Timestamp' => date('YmdHis'),
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phoneNumber,
            'PartyB' => $this->shortcode,
            'PhoneNumber' => $phoneNumber,
            'CallBackURL' => $callbackUrl,
            'AccountReference' => 'YourReference',
            'TransactionDesc' => 'Payment for something',
        ];

        $response = $this->sendRequest($url, $curl_post_data);

        return $response;
    }

    public function sendRequest($url, $postData)
    {
        $token = $this->generateAccessToken();

        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
        ];

        $postData = json_encode($postData);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    private function generateAccessToken()
    {
        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);

        $headers = [
            'Authorization: Basic ' . $credentials,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        $data = json_decode($response, true);

        return $data['access_token'];
    }

    private function generatePassword()
    {
        $timestamp = date('YmdHis');
        $passkey = $this->passkey;
        $shortcode = $this->shortcode;

        return base64_encode($shortcode . $passkey . $timestamp);
    }
}
