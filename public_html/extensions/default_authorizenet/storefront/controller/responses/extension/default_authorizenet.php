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

class ControllerResponsesExtensionDefaultAuthorizeNet extends AController
{
    public function main()
    {
        //init controller data
        $this->extensions->hk_InitData($this, __FUNCTION__);

        $this->loadLanguage('default_authorizenet/default_authorizenet');

        $this->buildForm();

        $this->data['callback_url'] = $this->html->getSecureURL('r/extension/default_authorizenet/send');
        $this->data['acceptUiUrl'] = $this->config->get('default_authorizenet_test_mode')
            ? 'https://jstest.authorize.net/v3/AcceptUI.js'
            : 'https://js.authorize.net/v3/AcceptUI.js';

        $this->data['error_unknown'] = $this->language->get('error_unknown');
        $this->view->batchAssign($this->data);
        $this->processTemplate('responses/default_authorizenet.tpl');
        //update controller data
        $this->extensions->hk_UpdateData($this, __FUNCTION__);
    }

    public function buildForm()
    {
        $orderId = (int) $this->session->data['order_id'];

        /** @var ModelCheckoutOrder $mdl */
        $mdl = $this->loadModel('checkout/order');
        $this->data['order_info'] = $orderInfo = $mdl->getOrder($orderId);

        $this->data['payment_address'] = $orderInfo['payment_address_1'] . " " . $orderInfo['payment_address_2'];
        $this->data['text_wait'] = $this->language->get('text_wait');

        $form = new AForm();
        $form->setForm(
            [
                'form_name' => 'authorizenet',
            ]
        );

        $this->data['form_open'] = $form->getFieldHtml(
            [
                'type' => 'form',
                'name' => 'authorizenet',
                'attr' => 'class = "validate-creditcard"',
                'csrf' => true,
            ]
        );

        $this->data['submit'] = HtmlElementFactory::create(
            [
                'type'  => 'button',
                'name'  => 'authorizenet_button',
                'text'  => $this->language->get('button_confirm'),
                'style' => 'button btn-primary',
                'icon'  => 'icon-ok icon-white',
            ]
        );

        $this->data['button_back'] = HtmlElementFactory::create(
            [
                'type'  => 'button',
                'name'  => 'authorizenet_back',
                'text'  => $this->language->get('button_back'),
                'style' => 'button btn-default',
                'icon'  => 'icon-arrow-left',
            ]
        );
    }

    public function send()
    {
        if (!$this->csrftoken->isTokenValid()) {
            $output['error_text'] = $this->language->get('error_unknown');
            $err = new AError('');
            $err->toJSONResponse(
                'VALIDATION_ERROR_406',
                $output
            );
        }

        $this->loadLanguage('default_authorizenet/default_authorizenet');
        //init controller data
        $this->extensions->hk_InitData($this, __FUNCTION__);

        $post = $this->request->post;

        /** @var ModelCheckoutOrder $mdl */
        $mdl = $this->loadModel('checkout/order');

        $orderId = (int) $this->session->data['order_id'];
        $orderInfo = $mdl->getOrder($orderId);
        if (!$orderInfo || !$orderId) {
            $output['error_text'] = 'Order not found';
            $err = new AError('');
            $err->toJSONResponse(
                'VALIDATION_ERROR_402',
                $output
            );
        }
        // currency code
        $currency = $this->currency->getCode();
        // order amount without decimal delimiter
        $amount = round((float) $orderInfo['total'], 2);

        ADebug::checkpoint('AuthorizeNet Payment: Order ID ' . $orderId);

        try {
            $paymentData = array_merge(
                $orderInfo,
                [
                    'amount'             => $amount,
                    'currency'           => $currency,
                    'cc_owner_firstname' => html_entity_decode($orderInfo['payment_firstname'], ENT_QUOTES, 'UTF-8'),
                    'cc_owner_lastname'  => html_entity_decode($orderInfo['payment_lastname'], ENT_QUOTES, 'UTF-8'),
                    'dataDescriptor'     => $post['dataDescriptor'],
                    'dataValue'          => $post['dataValue'],
                ],
                //allow passing data from hooks
                (array) $this->data['payment_data']
            );
            $this->data['payment_data'] = $paymentData;

            /** @var ModelExtensionDefaultAuthorizenet $anetMdl */
            $anetMdl = $this->loadModel('extension/default_authorizenet');
            $transactionDetails = $this->data['transaction_details'] = $anetMdl->processPayment($paymentData);
            $output['success'] = $this->html->getSecureURL('checkout/finalize');
            ADebug::variable('Processing payment result: ', $this->data['transaction_details']);

            //update transaction details in the order table
            $paymentMethodData = array_merge($transactionDetails, $post);
            $this->db->query(
                "UPDATE " . $this->db->table('orders') . "
                SET payment_method_data = '" . $this->db->escape(serialize($paymentMethodData)) . "'
                WHERE order_id = '" . $orderId . "'"
            );

            $responseCode = $transactionDetails['responseCode'];
            //we allow only 1 = Approved & 4 = Held for Review
            if (in_array((int) $responseCode, [1, 4])) {
                $orderStatusId =
                    $responseCode == 4
                        //when hold for review
                        ? $this->order_status->getStatusByTextId('pending')
                        : $this->config->get('default_authorizenet_status_success_settled');

                $comment = str_contains($paymentData['shipping_method_key'], 'pickup')
                    ? 'You will be contacted by an account representative '
                    . 'when your order is available for pickup.'
                    : '';
                $output['paid'] = true;
                $mdl->confirm($orderId, $orderStatusId, $comment);
            } else {
                // Some other error, assume payment declined
                $output['error_text'] = $transactionDetails['description'] . '(ResponseCode:' . $responseCode . ')';
            }
        } catch (Exception $e) {
            $output['error_text'] = $e->getMessage();
            $errorCode = $e->getCode();
            if ($errorCode) {
                $output['error_text'] .= ' (' . $errorCode . ')';
            }
            $this->log->write($output['error_text'] . PHP_EOL . $e->getTraceAsString());
        }

        //update controller data
        $this->extensions->hk_UpdateData($this, __FUNCTION__);

        if (isset($output['error_text']) && $output['error_text']) {
            $csrftoken = $this->registry->get('csrftoken');
            $output['csrfinstance'] = $csrftoken->setInstance();
            $output['csrftoken'] = $csrftoken->setToken();
            $err = new AError('');
            $err->toJSONResponse(
                'APP_ERROR_402',
                $output
            );
        }
        $this->load->library('json');
        $this->response->addJSONHeader();
        $this->response->setOutput(AJson::encode($output));
    }
}
