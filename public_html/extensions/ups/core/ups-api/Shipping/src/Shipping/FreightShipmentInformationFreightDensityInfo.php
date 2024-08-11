<?php
/**
 * FreightShipmentInformationFreightDensityInfo
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
 * Do not edit the class manually.
 */

namespace UPS\Shipping\Shipping;

use \ArrayAccess;
use \UPS\Shipping\ObjectSerializer;

/**
 * FreightShipmentInformationFreightDensityInfo Class Doc Comment
 *
 * @category Class
 * @description Freight Density Info container.  Required if DensityEligibleIndicator is present.
 * @package  UPS\Shipping
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class FreightShipmentInformationFreightDensityInfo implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'FreightShipmentInformation_FreightDensityInfo';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'adjusted_height_indicator' => 'string',
        'adjusted_height' => '\UPS\Shipping\Shipping\FreightDensityInfoAdjustedHeight',
        'handling_units' => '\UPS\Shipping\Shipping\FreightDensityInfoHandlingUnits[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'adjusted_height_indicator' => null,
        'adjusted_height' => null,
        'handling_units' => null
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
        'adjusted_height_indicator' => 'AdjustedHeightIndicator',
        'adjusted_height' => 'AdjustedHeight',
        'handling_units' => 'HandlingUnits'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'adjusted_height_indicator' => 'setAdjustedHeightIndicator',
        'adjusted_height' => 'setAdjustedHeight',
        'handling_units' => 'setHandlingUnits'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'adjusted_height_indicator' => 'getAdjustedHeightIndicator',
        'adjusted_height' => 'getAdjustedHeight',
        'handling_units' => 'getHandlingUnits'
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
        $this->container['adjusted_height_indicator'] = isset($data['adjusted_height_indicator']) ? $data['adjusted_height_indicator'] : null;
        $this->container['adjusted_height'] = isset($data['adjusted_height']) ? $data['adjusted_height'] : null;
        $this->container['handling_units'] = isset($data['handling_units']) ? $data['handling_units'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

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
     * Gets adjusted_height_indicator
     *
     * @return string
     */
    public function getAdjustedHeightIndicator()
    {
        return $this->container['adjusted_height_indicator'];
    }

    /**
     * Sets adjusted_height_indicator
     *
     * @param string $adjusted_height_indicator The presence of the AdjustedHeightIndicator indicates that allow the height reduction adjustment for density based rate request.
     *
     * @return $this
     */
    public function setAdjustedHeightIndicator($adjusted_height_indicator)
    {
        $this->container['adjusted_height_indicator'] = $adjusted_height_indicator;

        return $this;
    }

    /**
     * Gets adjusted_height
     *
     * @return \UPS\Shipping\Shipping\FreightDensityInfoAdjustedHeight
     */
    public function getAdjustedHeight()
    {
        return $this->container['adjusted_height'];
    }

    /**
     * Sets adjusted_height
     *
     * @param \UPS\Shipping\Shipping\FreightDensityInfoAdjustedHeight $adjusted_height adjusted_height
     *
     * @return $this
     */
    public function setAdjustedHeight($adjusted_height)
    {
        $this->container['adjusted_height'] = $adjusted_height;

        return $this;
    }

    /**
     * Gets handling_units
     *
     * @return \UPS\Shipping\Shipping\FreightDensityInfoHandlingUnits[]
     */
    public function getHandlingUnits()
    {
        return $this->container['handling_units'];
    }

    /**
     * Sets handling_units
     *
     * @param \UPS\Shipping\Shipping\FreightDensityInfoHandlingUnits[] $handling_units handling_units
     *
     * @return $this
     */
    public function setHandlingUnits($handling_units)
    {
        $this->container['handling_units'] = $handling_units;

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
