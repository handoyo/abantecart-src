<?php

/*------------------------------------------------------------------------------
  $Id$

  AbanteCart, Ideal OpenSource Ecommerce Solution
  http://www.AbanteCart.com

  Copyright © 2011-2021 Belavier Commerce LLC

  This source file is subject to Open Software License (OSL 3.0)
  License details is bundled with this package in the file LICENSE.txt.
  It is also available at this URL:
  <http://www.opensource.org/licenses/OSL-3.0>

 UPGRADE NOTE:
   Do not edit or add to this file if you wish to upgrade AbanteCart to newer
   versions in the future. If you wish to customize AbanteCart for your
   needs please refer to http://www.AbanteCart.com for more information.
------------------------------------------------------------------------------*/
if (!defined('DIR_CORE')) {
    header('Location: static_pages/');
}

/**
 * Class ControllerResponsesCheckoutFastCheckoutSummary
 *
 */
class ControllerResponsesCheckoutFastCheckoutSummary extends AController
{

    public function __construct($registry, $instance_id, $controller, $parent_controller = '')
    {
        parent::__construct($registry, $instance_id, $controller, $parent_controller);
        $cart_key = $registry->get('session')->data['fc']['cart_key'];
        //if cart key must be present in the FC session data anyway!
        if (!$cart_key) {
            return;
        }

        //swap cart in the registry to replace default cart data with FC cart data
        $cart_class_name = get_class($this->cart);
        $registry->set('cart', new $cart_class_name($registry, $this->session->data['fc']));
    }

    public function main()
    {
        //init controller data
        $this->extensions->hk_InitData($this, __FUNCTION__);
        $this->loadLanguage('fast_checkout/fast_checkout');

        $this->buildCartProductDetails();

        $this->view->batchAssign($this->data);
        $this->extensions->hk_UpdateData($this, __FUNCTION__);
        $this->response->setOutput($this->view->fetch('responses/checkout/fast_checkout_summary.tpl'));
    }

    protected function buildCartProductDetails()
    {
        $qty = 0;
        $resource = new AResource('image');
        $products = [];
        $mSizes = [
            'main'  =>
                [
                    'width'  => $this->config->get('config_image_cart_width'),
                    'height' => $this->config->get('config_image_cart_height'),
                ],
            'thumb' => [
                'width'  => $this->config->get('config_image_cart_width'),
                'height' => $this->config->get('config_image_cart_height'),
            ],
        ];

        foreach ($this->cart->getProducts() as $result) {
            $option_data = [];
            $option = [];
            foreach ($result['option'] as $option) {
                $value = $option['value'];
                // hide binary value for checkbox
                if ($option['element_type'] == 'C' && in_array($value, [0, 1], true)) {
                    $value = '';
                }
                $title = '';
                // strip long textarea value
                if ($option['element_type'] == 'T') {
                    $title = strip_tags($value);
                    $title = str_replace('\r\n', "\n", $title);

                    $value = str_replace('\r\n', "\n", $value);
                    if (mb_strlen($value) > 64) {
                        $value = mb_substr($value, 0, 64).'...';
                    }
                }

                $option_data[] = [
                    'name'  => $option['name'],
                    'value' => $value,
                    'title' => $title,
                ];
            }

            $qty += $result['quantity'];

            //get main image
            $thumbnail = $resource->getMainImage(
                'products',
                $result['product_id'],
                $this->config->get('config_image_grid_width'),
                $this->config->get('config_image_grid_height')
            );

            $main_image = $resource->getResourceAllObjects(
                'product_option_value',
                $option['product_option_value_id'],
                $mSizes,
                1,
                false
            );

            if (!empty($main_image)) {
                $thumbnail['origin'] = $main_image['origin'];
                $thumbnail['title'] = $main_image['title'];
                $thumbnail['description'] = $main_image['description'];
                $thumbnail['thumb_html'] = $main_image['thumb_html'];
                $thumbnail['thumb_url'] = $main_image['thumb_url'];
                $thumbnail['main_url'] = $main_image['main_url'];
            }

            $products[] = [
                'key'       => $result['key'],
                'name'      => $result['name'],
                'thumbnail' => $thumbnail,
                'option'    => $option_data,
                'quantity'  => $result['quantity'],
                'stock'     => $result['stock'],
                'price'     => $this->currency->format(
                    $this->tax->calculate(
                        $result['price'],
                        $result['tax_class_id'],
                        $this->config->get('config_tax')
                    )
                ),
                'href'      => $this->html->getSEOURL(
                    'product/product',
                    '&product_id='.$result['product_id'],
                    true
                ),
            ];
        }

        $this->data['products'] = $products;
        $display_totals = $this->cart->buildTotalDisplay(true);

        $this->data['totals'] = $display_totals['total_data'];
        $this->data['total'] = $display_totals['total'];
        $this->data['total_string'] = $this->currency->format($display_totals['total']);
        return ($this->data['totals']);
    }
}
