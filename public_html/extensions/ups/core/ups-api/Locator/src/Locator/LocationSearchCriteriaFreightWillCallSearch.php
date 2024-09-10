<?php
/**
 * LocationSearchCriteriaFreightWillCallSearch
 *
 * PHP version 5
 *
 * @category Class
 * @package  UPS\Locator
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Locator
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

namespace UPS\Locator\Locator;

use \ArrayAccess;
use \UPS\Locator\ObjectSerializer;

/**
 * LocationSearchCriteriaFreightWillCallSearch Class Doc Comment
 *
 * @category Class
 * @description Freight Will Call Search Container. Required if SearchOption is &#x27;05-Freight Will Call Search&#x27;
 * @package  UPS\Locator
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class LocationSearchCriteriaFreightWillCallSearch implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'LocationSearchCriteria_FreightWillCallSearch';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'freight_will_call_request_type' => 'string',
        'facility_address' => '\UPS\Locator\Locator\FreightWillCallSearchFacilityAddress[]',
        'origin_or_destination' => 'string',
        'format_postal_code' => 'string',
        'day_of_week_code' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'freight_will_call_request_type' => null,
        'facility_address' => null,
        'origin_or_destination' => null,
        'format_postal_code' => null,
        'day_of_week_code' => null
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
        'freight_will_call_request_type' => 'FreightWillCallRequestType',
        'facility_address' => 'FacilityAddress',
        'origin_or_destination' => 'OriginOrDestination',
        'format_postal_code' => 'FormatPostalCode',
        'day_of_week_code' => 'DayOfWeekCode'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'freight_will_call_request_type' => 'setFreightWillCallRequestType',
        'facility_address' => 'setFacilityAddress',
        'origin_or_destination' => 'setOriginOrDestination',
        'format_postal_code' => 'setFormatPostalCode',
        'day_of_week_code' => 'setDayOfWeekCode'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'freight_will_call_request_type' => 'getFreightWillCallRequestType',
        'facility_address' => 'getFacilityAddress',
        'origin_or_destination' => 'getOriginOrDestination',
        'format_postal_code' => 'getFormatPostalCode',
        'day_of_week_code' => 'getDayOfWeekCode'
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
        $this->container['freight_will_call_request_type'] = isset($data['freight_will_call_request_type']) ? $data['freight_will_call_request_type'] : null;
        $this->container['facility_address'] = isset($data['facility_address']) ? $data['facility_address'] : null;
        $this->container['origin_or_destination'] = isset($data['origin_or_destination']) ? $data['origin_or_destination'] : null;
        $this->container['format_postal_code'] = isset($data['format_postal_code']) ? $data['format_postal_code'] : null;
        $this->container['day_of_week_code'] = isset($data['day_of_week_code']) ? $data['day_of_week_code'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['freight_will_call_request_type'] === null) {
            $invalidProperties[] = "'freight_will_call_request_type' can't be null";
        }
        if ($this->container['facility_address'] === null) {
            $invalidProperties[] = "'facility_address' can't be null";
        }
        if ($this->container['origin_or_destination'] === null) {
            $invalidProperties[] = "'origin_or_destination' can't be null";
        }
        if ($this->container['format_postal_code'] === null) {
            $invalidProperties[] = "'format_postal_code' can't be null";
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
     * Gets freight_will_call_request_type
     *
     * @return string
     */
    public function getFreightWillCallRequestType()
    {
        return $this->container['freight_will_call_request_type'];
    }

    /**
     * Sets freight_will_call_request_type
     *
     * @param string $freight_will_call_request_type Valid values are:  1 - Postal Code 2 - Delivery SLIC 3 - Delivery City/State. 1: Freight Will Call Search based on Postal Code, this search is valid for Postal code countries. 2: Freight Will Call Search based on SLIC. 3: Freight Will Call Search based on City and/or State. This Search is valid for non-postal code Countries
     *
     * @return $this
     */
    public function setFreightWillCallRequestType($freight_will_call_request_type)
    {
        $this->container['freight_will_call_request_type'] = $freight_will_call_request_type;

        return $this;
    }

    /**
     * Gets facility_address
     *
     * @return \UPS\Locator\Locator\FreightWillCallSearchFacilityAddress[]
     */
    public function getFacilityAddress()
    {
        return $this->container['facility_address'];
    }

    /**
     * Sets facility_address
     *
     * @param \UPS\Locator\Locator\FreightWillCallSearchFacilityAddress[] $facility_address facility_address
     *
     * @return $this
     */
    public function setFacilityAddress($facility_address)
    {
        $this->container['facility_address'] = $facility_address;

        return $this;
    }

    /**
     * Gets origin_or_destination
     *
     * @return string
     */
    public function getOriginOrDestination()
    {
        return $this->container['origin_or_destination'];
    }

    /**
     * Sets origin_or_destination
     *
     * @param string $origin_or_destination OriginOrDestination is required for FreightWillCallRequestType 1 and type 3 . Valid values: 01-Origin facilities 02-Destination facilities.
     *
     * @return $this
     */
    public function setOriginOrDestination($origin_or_destination)
    {
        $this->container['origin_or_destination'] = $origin_or_destination;

        return $this;
    }

    /**
     * Gets format_postal_code
     *
     * @return string
     */
    public function getFormatPostalCode()
    {
        return $this->container['format_postal_code'];
    }

    /**
     * Sets format_postal_code
     *
     * @param string $format_postal_code FormatPostalCode would be required in the request when FreightWillCallRequestType is 1. Valid values are: NFR-No format requested FR-format requested FS-format and search NVR-No validation requested.
     *
     * @return $this
     */
    public function setFormatPostalCode($format_postal_code)
    {
        $this->container['format_postal_code'] = $format_postal_code;

        return $this;
    }

    /**
     * Gets day_of_week_code
     *
     * @return string
     */
    public function getDayOfWeekCode()
    {
        return $this->container['day_of_week_code'];
    }

    /**
     * Sets day_of_week_code
     *
     * @param string $day_of_week_code Day Of week Code. Valid Values are 1 to 7.  1-Sunday 2-Monday  3-Tuesday  4-Wednesday 5-Thursday 6-Friday 7-Saturday.
     *
     * @return $this
     */
    public function setDayOfWeekCode($day_of_week_code)
    {
        $this->container['day_of_week_code'] = $day_of_week_code;

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