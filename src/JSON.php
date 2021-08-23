<?php

declare(strict_types=1);

/**
 * @copyright 2016-2021 David Zurborg
 * @author    David Zurborg <zurborg@cpan.org>
 * @link      https://github.com/zurborg/liblog-gelfsocket-php
 * @license   https://opensource.org/licenses/ISC The ISC License
 */

namespace Wrap;

use stdClass;
use Wrap\JSON\DecodeException;
use Wrap\JSON\EncodeException;
use function json_decode;
use function json_encode;
use function json_last_error;
use function json_last_error_msg;

/**
 * This class is just a bundle of public static functions
 */
class JSON
{
    const DEPTH = 512;

    /**
     * Encode data to JSON
     *
     * This is a wrapper around `json_encode()` with following options enabled by default:
     * + `JSON_UNESCAPED_UNICODE` - All unicode characters are printed as they are
     * + `JSON_PRESERVE_ZERO_FRACTION` - float numbers are printed as float numbers,
     *   even when their fractional part is zero.
     * + `JSON_UNESCAPED_SLASHES` - slashes in strings will not be escaped
     *
     * If there is any error, an execption will be thrown, so you don't have to check the return value any longer.
     *
     * @param mixed $data Data to be encoded as JSON
     * @param int $options JSON constants
     * @return string JavaScript Object Notation
     * @throws EncodeException
     * @see encodePretty() Same method but with pretty printing
     */
    public static function encode($data, int $options = 0): string
    {
        $json = json_encode(
            $data,
            JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION | JSON_UNESCAPED_SLASHES | $options
        );
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new EncodeException(json_last_error_msg(), json_last_error());
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
     * @return string (pretty) JavaScript Object Notation
     * @throws EncodeException
     * @see encode() Same method but without pretty printing
     */
    public static function encodePretty($data, int $options = 0): string
    {
        return self::encode($data, JSON_PRETTY_PRINT | $options);
    }

    /**
     * Decode a JSON string to an array or stdClass object
     *
     * This is a wrapper around `json_decode`.
     *
     * If there is any error, an execption will be thrown, so you don't have to check the return value any longer.
     *
     * @param string $json JSON string
     * @param bool $assoc
     * @param int $depth Maximum array depth
     * @param int $flags
     * @return array|mixed Decoded data
     * @see decodeArray() Output as an array directly
     * @see decodeObject() Output as stdClass directly
     */
    public static function decode(string $json, bool $assoc, int $depth = self::DEPTH, int $flags = 0)
    {
        $data = json_decode($json, $assoc, $depth, $flags);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new DecodeException(json_last_error_msg(), json_last_error());
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
     * @return array|mixed Decoded data
     * @throws DecodeException
     */
    public static function decodeArray(string $json, int $depth = self::DEPTH, int $options = 0)
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
     * @return stdClass|mixed Decoded data
     * @throws DecodeException
     */
    public static function decodeObject(string $json, int $depth = self::DEPTH, int $options = 0)
    {
        return self::decode($json, false, $depth, $options);
    }
}
