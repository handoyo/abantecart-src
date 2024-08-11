<?php
/**
 * ShipmentServiceOptionsLabelDeliveryTest
 *
 * PHP version 5
 *
 * @category Class
 * @package  UPS\Shipping
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Ship
 *
 * No description provided (generated by Swagger Codegen https://github.com/swagger-api/swagger-codegen)
 *
 * 
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 3.0.50
 */
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Please update the test case below to test the model.
 */

namespace UPS\Shipping;

use PHPUnit\Framework\TestCase;

/**
 * ShipmentServiceOptionsLabelDeliveryTest Class Doc Comment
 *
 * @category    Class
 * @description Container for the Label Delivery accessorial. Note - LabelDelivery is not applicable for GFP and Mail Innovations Forward shipment.  Required for shipments with either Electronic Return Label Return Service or ImportControl Electronic LabelMethod type. Optional for shipments with Print Return Label Return Service or ImportControl Print LabelMethod type or Forward movement.  If this container is present for shipments with either Electronic Return Label Return Service or ImportControl Electronic LabelMethod type, either of the LabelLinksIndicator or EMail container should be provided. For shipments with Print Return Label Return Service or ImportControl Print LabelMethod type or Forward movement, only LabelLinksIndicator is valid option for LabelDelivery container.
 * @package     UPS\Shipping
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class ShipmentServiceOptionsLabelDeliveryTest extends TestCase
{

    /**
     * Setup before running any test case
     */
    public static function setUpBeforeClass(): void
    {
    }

    /**
     * Setup before running each test case
     */
    public function setUp(): void
    {
    }

    /**
     * Clean up after running each test case
     */
    public function tearDown(): void
    {
    }

    /**
     * Clean up after running all test cases
     */
    public static function tearDownAfterClass(): void
    {
    }

    /**
     * Test "ShipmentServiceOptionsLabelDelivery"
     */
    public function testShipmentServiceOptionsLabelDelivery()
    {
    }

    /**
     * Test attribute "e_mail"
     */
    public function testPropertyEMail()
    {
    }

    /**
     * Test attribute "label_links_indicator"
     */
    public function testPropertyLabelLinksIndicator()
    {
    }
}
