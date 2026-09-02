<?php
/*
 *   $Id$
 *
 *   AbanteCart, Ideal OpenSource Ecommerce Solution
 *   http://www.AbanteCart.com
 *
 *   Copyright © 2011-2026 Belavier Commerce LLC
 *
 *   This source file is subject to Open Software License (OSL 3.0)
 *   License details are bundled with this package in the file LICENSE.txt.
 *   It is also available at this URL:
 *   <http://www.opensource.org/licenses/OSL-3.0>
 *
 *  UPGRADE NOTE:
 *    Do not edit or add to this file if you wish to upgrade AbanteCart to newer
 *    versions in the future. If you wish to customize AbanteCart for your
 *    needs, please refer to http://www.AbanteCart.com for more information.
 */

use net\authorize\api\constants\ANetEnvironment;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\contract\v1\ANetApiResponseType;
use net\authorize\api\contract\v1\CreateTransactionRequest;
use net\authorize\api\contract\v1\CreateTransactionResponse;
use net\authorize\api\contract\v1\CustomerAddressType;
use net\authorize\api\contract\v1\CustomerDataType;
use net\authorize\api\contract\v1\CustomerProfilePaymentType;
use net\authorize\api\contract\v1\MerchantAuthenticationType;
use net\authorize\api\contract\v1\OpaqueDataType;
use net\authorize\api\contract\v1\OrderType;
use net\authorize\api\contract\v1\PaymentProfileType;
use net\authorize\api\contract\v1\PaymentType;
use net\authorize\api\contract\v1\SettingType;
use net\authorize\api\contract\v1\TransactionRequestType;
use net\authorize\api\contract\v1\TransactionResponseType;
use net\authorize\api\controller as AnetController;
use net\authorize\api\controller\CreateTransactionController;

/**
 * Class ModelExtensionAuthorizeNet
 *
 * @property ModelCheckoutOrder $model_checkout_order
 */
class ModelExtensionDefaultAuthorizeNet extends Model
{
    public $error = [];

    /**
     * @return MerchantAuthenticationType
     */
    protected function getAccess()
    {
        $merchantAuthentication = new MerchantAuthenticationType();
        $merchantAuthentication->setName($this->config->get('default_authorizenet_api_login_id'));
        $merchantAuthentication->setTransactionKey($this->config->get('default_authorizenet_api_transaction_key'));
        return $merchantAuthentication;
    }

    /**
     * @param $address
     *
     * @return array
     * @throws AException
     */
    public function getMethod($address)
    {
        //create new instance of language for case when model called from admin-side
        $language = new ALanguage($this->registry, $this->language->getLanguageCode(), 0);
        $language->load($language->language_details['directory']);
        $language->load('default_authorizenet/default_authorizenet');
        if ($this->config->get('default_authorizenet_status')) {
            $query = $this->db->query(
                "SELECT * 
                FROM `".$this->db->table("zones_to_locations")."` 
                WHERE location_id = '".(int)$this->config->get('default_authorizenet_location_id')."' 
                    AND country_id = '".(int)$address['country_id']."' 
                    AND (zone_id = '".(int)$address['zone_id']."' OR zone_id = '0')");

            if ( ! $this->config->get('default_authorizenet_location_id')) {
                $status = true;
            } elseif ($query->num_rows) {
                $status = true;
            } else {
                $status = false;
            }
        } else {
            $status = false;
        }

        $payment_data = [];
        if ($status) {
            $payment_data = [
                'id'         => 'default_authorizenet',
                'title'      => $language->get('text_title'),
                'sort_order' => $this->config->get('default_authorizenet_sort_order'),
            ];
        }

        return $payment_data;
    }

    /**
     * @param $paymentData
     *
     * @return array
     * @throws AException
     */
    public function processPayment($paymentData)
    {
        $output = [];
        /** @var \ModelCheckoutOrder $oMdl */
        $oMdl = $this->load->model('checkout/order');
        $this->load->language('default_authorizenet/default_authorizenet');

        //build charge data array
        $amount = round((float)$paymentData['amount'], 2);
        $orderId = (int)$paymentData['order_id'];
        $payload = array_merge(
            $paymentData,
            [
                'amount'               => $amount,
                'description'          => $this->config->get('store_name').' Order #'. $orderId,
                'statement_descriptor' => 'Order #'. $orderId,
                'receipt_email'        => $paymentData['email'],
                'capture'              => !($this->config->get('default_authorizenet_settlement') == 'auth'),
                //build cc details
                'first_name'           => $paymentData['cc_owner_firstname'],
                'last_name'            => $paymentData['cc_owner_lastname'],
                'address_line1'        => trim($paymentData['payment_address_1']),
                'address_line2'        => trim($paymentData['payment_address_2']),
                'address_city'         => $paymentData['payment_city'],
                'address_zip'          => $paymentData['payment_postcode'],
                'address_state'        => $paymentData['payment_zone'],
                'address_country'      => $paymentData['payment_iso_code_2'],
            ]
        );

        if ($paymentData['shipping_method']) {
            $payload['shipping'] = [
                'name'    => $paymentData['firstname'].' '.$paymentData['lastname'],
                'phone'   => $paymentData['telephone'],
                'address' => [
                    'line1'       => $paymentData['shipping_address_1'],
                    'line2'       => $paymentData['shipping_address_2'],
                    'city'        => $paymentData['shipping_city'],
                    'postal_code' => $paymentData['shipping_postcode'],
                    'state'       => $paymentData['shipping_zone'],
                    'country'     => $paymentData['shipping_iso_code_2'],
                ],
            ];
        }

        $payload['metadata'] = [];
        $payload['metadata']['order_id'] = $orderId;
        if ($payload['customer_id']) {
            $payload['metadata']['customer_id'] = $payload['customer_id'];
        }

        return $this->processPaymentByToken($payload, $amount);
    }

    /**
     * @param array $paymentData
     * @param float $amount
     *
     * @return array
     * @throws Exception
     */
    protected function processPaymentByToken(array $paymentData, float $amount): array
    {
        $merchantAuthentication = $this->getAccess();
        // Set the transaction's refId
        $refId = $paymentData['refId'] ?: 'abc-'. $paymentData['order_id'];

        // Create the payment object for a payment nonce
        $opaqueData = new OpaqueDataType();
        $opaqueData->setDataDescriptor($paymentData['dataDescriptor']);
        $opaqueData->setDataValue($paymentData['dataValue']);

        // Add the payment data to a paymentType object
        $paymentOne = new PaymentType();
        $paymentOne->setOpaqueData($opaqueData);
        // Create order information
        $order = new OrderType();
        $order->setInvoiceNumber($paymentData['invoice_number'] ?: $paymentData['order_id']);
        $order->setDescription($paymentData['description']);
        // Set the customer's Bill To address
        $customerAddress = new CustomerAddressType();
        $customerAddress->setFirstName($paymentData['first_name']);
        $customerAddress->setLastName($paymentData['last_name']);
        $customerAddress->setAddress(mb_substr($paymentData['address_line1'].' '. $paymentData['address_line2'], 0, 60));
        $customerAddress->setCity($paymentData['payment_city']);
        $customerAddress->setState($paymentData['payment_zone']);
        $customerAddress->setZip($paymentData['payment_postcode']);
        $customerAddress->setCountry($paymentData['payment_iso_code_2']);
        $customerAddress->setPhoneNumber($paymentData['telephone']);

        // Set the customer's Ship To address
        $shippingAddress = new AnetAPI\CustomerAddressType();
        $shippingAddress->setFirstName($paymentData['first_name']);
        $shippingAddress->setLastName($paymentData['last_name']);
        $shippingAddress->setAddress(mb_substr($paymentData['shipping_address_1'].' '. $paymentData['shipping_address_2'], 0, 60));
        $shippingAddress->setCity($paymentData['shipping_city']);
        $shippingAddress->setState($paymentData['shipping_zone']);
        $shippingAddress->setZip($paymentData['shipping_postcode']);
        $shippingAddress->setCountry($paymentData['shipping_iso_code_2']);
        // Set the customer's identifying information
        $customerData = new CustomerDataType();
        $customerData->setType("individual");
        $customerData->setId($paymentData['customer_id']);
        $customerData->setEmail($paymentData['email']);
        // Add values for transaction settings
        $duplicateWindowSetting = new SettingType();
        $duplicateWindowSetting->setSettingName("duplicateWindow");
        $duplicateWindowSetting->setSettingValue("4");
        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new TransactionRequestType();
        $transactionType = $this->config->get('default_authorizenet_settlement') == 'authcapture'
                    ? "authCaptureTransaction"
                    : 'authOnlyTransaction';
        $transactionRequestType->setTransactionType($transactionType);
        $transactionRequestType->setAmount($amount);
        $transactionRequestType->setOrder($order);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setBillTo($customerAddress);
        $transactionRequestType->setShipTo($shippingAddress);
        $transactionRequestType->setCustomer($customerData);
        $transactionRequestType->addToTransactionSettings($duplicateWindowSetting);
        $solutionID = $this->config->get('default_authorizenet_test_mode') ? 'AAA100302' : 'AAA179397';
        $solution = new AnetAPI\SolutionType();
        $solution->setId($solutionID);
        $transactionRequestType->setSolution($solution);

        if($paymentData['custom_fields'] && is_array($paymentData['custom_fields'])){
            foreach($paymentData['custom_fields'] as $key => $value){
                if(!$key || !isset($value)){
                    continue;
                }
                $merchantDefinedField = new AnetAPI\UserFieldType();
                $merchantDefinedField->setName($key);
                $merchantDefinedField->setValue($value);
                $transactionRequestType->addToUserFields($merchantDefinedField);
            }
        }
        // Assemble the complete transaction request
        $request = new CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequestType);
        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($request);
        $endpointUrl = $this->config->get('default_authorizenet_test_mode')
            ? ANetEnvironment::SANDBOX
            : ANetEnvironment::PRODUCTION;
        /** @var CreateTransactionResponse $apiResponse */
        $apiResponse = $controller?->executeWithApiResponse($endpointUrl);
        
        if (!$apiResponse) {
            throw new Exception(
                __FUNCTION__.': Empty API response: '. var_export($apiResponse, true)
            );
        }

        // Check to see if the API request was successfully received and acted upon
        $transactionResponse = $apiResponse->getTransactionResponse();
        if ( !$transactionResponse ) {
            throw new Exception(
                __FUNCTION__.': Empty transaction response: '. var_export($apiResponse, true)
            );
        }
        
        if ($apiResponse->getMessages()->getResultCode() == 'Ok') {
            // Since the API request was successful, look for a transaction response
            // and parse it to display the results of authorizing the card
            $messageObj = $transactionResponse?->getMessages();
            if ($messageObj) {
                $output = $transactionResponse->jsonSerialize();
                return array_merge(
                    $output,
                    [
                        'refId'        => $refId,
                        'message_code' => $messageObj[0]?->getCode(),
                        'description'  => $messageObj[0]?->getDescription(),
                    ]
                );
            }                
        }
        $errorsObj = $transactionResponse?->getErrors();
        if ($errorsObj) {
            throw new Exception((string)$errorsObj[0]?->getErrorText(), (int)$errorsObj[0]?->getErrorCode());
        } else {
            $errorMessage = '';
            $messages = $transactionResponse?->getMessages();
            if ( $messages && $messages[0]) {
                $errorMessage = $messages[0]?->getMessage();
            }
            if ($errorMessage) {
                throw new Exception($errorMessage);
            }
        }

        return ['error' => 'Error: Method '.__METHOD__.' result. No response returned.'];
    }

    /**
     * @param TransactionResponseType | AnetApiResponseType $apiResponse
     * @param string $mode
     *
     * @return array
     * @throws AException
     */
    protected function processApiResponse($apiResponse, $mode = 'exception')
    {
        $output = [];

        if (method_exists($apiResponse, 'getErrors') && $apiResponse->getErrors() != null) {
            $errors = $apiResponse->getErrors();
            $output['error'] = $errors[0]->getErrorText();
            $output['code'] = $errors[0]->getErrorCode();
        } else {
            $messages = $apiResponse->getMessages();
            if ( ! is_array($messages)) {
                $messages = $messages->getMessage();
            }
            if ($messages) {
                $output['error'] = $messages[0]->getText();
                $output['code'] = $messages[0]->getCode();
            }
        }

        if ($output) {
            $err = new AError('Authorize.net:'.var_export($output, true));
            $err->toDebug()->toLog();
        }

        if ($output && $mode == 'exception') {
            throw new AException (AC_ERR_LOAD, 'Error: '.$output['error']);
        }

        return $output;
    }
}
