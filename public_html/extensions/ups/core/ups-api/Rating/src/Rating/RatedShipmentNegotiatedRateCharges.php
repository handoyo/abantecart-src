<?php
/**
 * RatedShipmentNegotiatedRateCharges
 *
 * PHP version 5
 *
 * @category Class
 * @package  UPS\Rating
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Rate
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
 * Do not edit the class manually.
 */

namespace UPS\Rating\Rating;

use \ArrayAccess;
use \UPS\Rating\ObjectSerializer;

/**
 * RatedShipmentNegotiatedRateCharges Class Doc Comment
 *
 * @category Class
 * @description Negotiated Rate Charges Container.  For tiered rates and promotional discounts, if a particular shipment based on zone, origin, destination or even shipment size doesn&#x27;t qualify for the existing discount then no negotiated rates container will be returned. Published rates will be the applicable rate.
 * @package  UPS\Rating
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class RatedShipmentNegotiatedRateCharges implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'RatedShipment_NegotiatedRateCharges';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'itemized_charges' => '\UPS\Rating\Rating\NegotiatedRateChargesItemizedCharges[]',
        'tax_charges' => '\UPS\Rating\Rating\NegotiatedRateChargesTaxCharges[]',
        'total_charge' => '\UPS\Rating\Rating\NegotiatedRateChargesTotalCharge',
        'total_charges_with_taxes' => '\UPS\Rating\Rating\NegotiatedRateChargesTotalChargesWithTaxes'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'itemized_charges' => null,
        'tax_charges' => null,
        'total_charge' => null,
        'total_charges_with_taxes' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'itemized_charges' => 'ItemizedCharges',
        'tax_charges' => 'TaxCharges',
        'total_charge' => 'TotalCharge',
        'total_charges_with_taxes' => 'TotalChargesWithTaxes'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'itemized_charges' => 'setItemizedCharges',
        'tax_charges' => 'setTaxCharges',
        'total_charge' => 'setTotalCharge',
        'total_charges_with_taxes' => 'setTotalChargesWithTaxes'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'itemized_charges' => 'getItemizedCharges',
        'tax_charges' => 'getTaxCharges',
        'total_charge' => 'getTotalCharge',
        'total_charges_with_taxes' => 'getTotalChargesWithTaxes'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }



    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['itemized_charges'] = isset($data['itemized_charges']) ? $data['itemized_charges'] : null;
        $this->container['tax_charges'] = isset($data['tax_charges']) ? $data['tax_charges'] : null;
        $this->container['total_charge'] = isset($data['total_charge']) ? $data['total_charge'] : null;
        $this->container['total_charges_with_taxes'] = isset($data['total_charges_with_taxes']) ? $data['total_charges_with_taxes'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['total_charge'] === null) {
            $invalidProperties[] = "'total_charge' can't be null";
        }
        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets itemized_charges
     *
     * @return \UPS\Rating\Rating\NegotiatedRateChargesItemizedCharges[]
     */
    public function getItemizedCharges()
    {
        return $this->container['itemized_charges'];
    }

    /**
     * Sets itemized_charges
     *
     * @param \UPS\Rating\Rating\NegotiatedRateChargesItemizedCharges[] $itemized_charges Itemized Charges are returned only when the subversion element is present and greater than or equal to '1601'.  These charges would be returned only when subversion is greater than or equal to 1601.  **NOTE:** For versions >= v2403, this element will always be returned as an array. For requests using versions < v2403, this element will be returned as an array if there is more than one object and a single object if there is only 1.
     *
     * @return $this
     */
    public function setItemizedCharges($itemized_charges)
    {
        $this->container['itemized_charges'] = $itemized_charges;

        return $this;
    }

    /**
     * Gets tax_charges
     *
     * @return \UPS\Rating\Rating\NegotiatedRateChargesTaxCharges[]
     */
    public function getTaxCharges()
    {
        return $this->container['tax_charges'];
    }

    /**
     * Sets tax_charges
     *
     * @param \UPS\Rating\Rating\NegotiatedRateChargesTaxCharges[] $tax_charges TaxCharges container are returned only when TaxInformationIndicator is present in request. TaxCharges container contains Tax information for a given shipment.  **NOTE:** For versions >= v2403, this element will always be returned as an array. For requests using versions < v2403, this element will be returned as an array if there is more than one object and a single object if there is only 1.
     *
     * @return $this
     */
    public function setTaxCharges($tax_charges)
    {
        $this->container['tax_charges'] = $tax_charges;

        return $this;
    }

    /**
     * Gets total_charge
     *
     * @return \UPS\Rating\Rating\NegotiatedRateChargesTotalCharge
     */
    public function getTotalCharge()
    {
        return $this->container['total_charge'];
    }

    /**
     * Sets total_charge
     *
     * @param \UPS\Rating\Rating\NegotiatedRateChargesTotalCharge $total_charge total_charge
     *
     * @return $this
     */
    public function setTotalCharge($total_charge)
    {
        $this->container['total_charge'] = $total_charge;

        return $this;
    }

    /**
     * Gets total_charges_with_taxes
     *
     * @return \UPS\Rating\Rating\NegotiatedRateChargesTotalChargesWithTaxes
     */
    public function getTotalChargesWithTaxes()
    {
        return $this->container['total_charges_with_taxes'];
    }

    /**
     * Sets total_charges_with_taxes
     *
     * @param \UPS\Rating\Rating\NegotiatedRateChargesTotalChargesWithTaxes $total_charges_with_taxes total_charges_with_taxes
     *
     * @return $this
     */
    public function setTotalChargesWithTaxes($total_charges_with_taxes)
    {
        $this->container['total_charges_with_taxes'] = $total_charges_with_taxes;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}
