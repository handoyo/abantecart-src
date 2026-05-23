<?php
/** @noinspection PhpMultipleClassDeclarationsInspection */

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
if (!defined('DIR_CORE')) {
    header('Location: static_pages/');
}

class ModelCatalogCollection extends Model
{
    /**
     * @param int $collectionId
     *
     * @return array|false
     * @throws AException
     */
    public function getById(int $collectionId)
    {
        if (!$collectionId) {
            return false;
        }
        $languageId = $this->language->getLanguageID();
        $query = "SELECT c.*, cd.*, 
                    (SELECT keyword
                    FROM " . $this->db->table("url_aliases") . " 
                    WHERE query = 'collection_id=" . $collectionId . "'
                        AND language_id = '" . $languageId . "') as keyword 
                  FROM " . $this->db->table('collections') . " c 
                  LEFT JOIN " . $this->db->table('collection_descriptions') . " cd 
                      ON (cd.collection_id = c.id AND cd.language_id = " . $languageId . ")
                  WHERE c.id=" . $collectionId;

        $result = $this->db->query($query);
        if ($result->num_rows) {
            $output = $result->row;
            $output['conditions'] = json_decode($output['conditions'], true);
            return $output;
        }
        return [];
    }

    /**
     * @param int $collectionId
     * @param int $limit
     *
     * @return false|array
     * @throws AException
     */
    public function getListingBlockProducts(int $collectionId, int $limit)
    {
        if (!$collectionId) {
            return false;
        }
        $collection = $this->getById($collectionId);
        if ($collection && $collection['conditions']) {
            $sortOrder = $this->config->get('config_product_default_sort_order');
            list($sort, $order) = explode('-', $sortOrder);
            /** @var ModelCatalogProduct $mdl */
            $mdl = $this->load->model('catalog/product');
            $result = $mdl->getCollectionProducts(
                $collection['conditions'],
                $sort ? : 'date_modified',
                $order ? : 'DESC',
                0,
                $limit,
                $collectionId
            );
            return $result['items'];
        }
        return false;
    }

    /**
     * @param array $conditions
     * @param string $sort
     * @param string $order
     * @param int $start
     * @param int $limit
     * @param int $collectionId
     *
     * @return array
     * @throws AException
     * @deprecated since 1.4.5
     * @see
     *
     * @deprecated
     */
    public function getProducts(array $conditions, $sort, $order, $start, $limit, $collectionId)
    {
        /** @var ModelCatalogProduct $mdl */
        $mdl = $this->load->model('catalog/product');
        return $mdl->getCollectionProducts($conditions, $sort, $order, $start, $limit, $collectionId);
    }
}
