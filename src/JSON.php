<?php

/**
 * @copyright 2016 David Zurborg
 * @author    David Zurborg <zurborg@cpan.org>
 * @link      https://github.com/zurborg/liblog-gelfsocket-php
 * @license   https://opensource.org/licenses/ISC The ISC License
 */

namespace Wrap;

use Wrap\JSON\EncodeException;
use Wrap\JSON\DecodeException;

/**
 * This class is just a bundle of public static functions
 */
class JSON
{
    /**
     * Encode data to JSON
     *
     * This is a wrapper around `json_encode()` with following options enabled by default:
     * + `JSON_UNESCAPED_UNICODE` - All unicode characters are printed as they are
     * + `JSON_PRESERVE_ZERO_FRACTION` - float numbers are printed as float numbers, even when their fractional part is zero
     * + `JSON_UNESCAPED_SLASHES` - slashes in strings will not be escaped
     *
     * If there is any error, an execption will be thrown, so you don't have to check the return value any longer.
     *
     * @param mixed $data Data to be encoded as JSON
     * @param int $options JSON constants
     * @throw \Wrap\JSON\EncodeException
     * @return string JavaScript Object Notation
     */
    public static function encode($data, int $options = 0)
    {
        $json = \json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION | JSON_UNESCAPED_SLASHES | $options);
        if (\json_last_error() !== JSON_ERROR_NONE) {
            throw new EncodeException(\json_last_error_msg(), \json_last_error());
        }
        return $json;
    }

    /**
     * Encode data to JSON with pretty printing
     *
     * Same as `encode`, but with `JSON_PRETTY_PRINT` option.
     *
     * @param mixed $data Data to be encoded as JSON
     * @param int $options JSON constants
     * @throw \Wrap\JSON\EncodeException
     * @return string (pretty) JavaScript Object Notation
     */
    public static function encodePretty($data, int $options = 0)
    {
        return self::encode($data, JSON_PRETTY_PRINT | $options);
    }

    /**
     * @internal
     */
    protected static function decode(string $json, bool $assoc, int $depth, int $options)
    {
        $data = \json_decode($json, $assoc, $depth, $options);
        if (\json_last_error() !== JSON_ERROR_NONE) {
            throw new DecodeException(\json_last_error_msg(), \json_last_error());
        }
        return $data;
    }

    /**
     * Decode a JSON string to an array
     *
     * This is a wrapper around `json_decode`.
     *
     * If there is any error, an execption will be thrown, so you don't have to check the return value any longer.
     *
     * @param string $json JSON string
     * @param int $depth Maximum array depth
     * @param int $options Decode options
     * @throw \Wrap\JSON\DecodeException
     * @return array|mixed Decoded data
     */
    public static function decodeArray(string $json, int $depth = 512, int $options = 0)
    {
        return self::decode($json, true, $depth, $options);
    }

    /**
     * Decode a JSON string to a stdClass object
     *
     * This is a wrapper around `json_decode`.
     *
     * If there is any error, an execption will be thrown, so you don't have to check the return value any longer.
     *
     * @param string $json JSON string
     * @param int $depth Maximum array depth
     * @param int $options Decode options
     * @throw \Wrap\JSON\DecodeException
     * @return stdClass|mixed Decoded data
     */
    public static function decodeObject(string $json, int $depth = 512, int $options = 0)
    {
        return self::decode($json, false, $depth, $options);
    }
}
