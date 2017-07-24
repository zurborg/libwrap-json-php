Wrap\JSON
===============

This class is just a bundle of public static functions




* Class name: JSON
* Namespace: Wrap







Methods
-------


### encode

    string Wrap\JSON::encode(mixed $data, integer $options)

Encode data to JSON

This is a wrapper around `json_encode()` with following options enabled by default:
+ `JSON_UNESCAPED_UNICODE` - All unicode characters are printed as they are
+ `JSON_PRESERVE_ZERO_FRACTION` - float numbers are printed as float numbers, even when their fractional part is zero (only available if php version >= 5.6.6)
+ `JSON_UNESCAPED_SLASHES` - slashes in strings will not be escaped

If there is any error, an execption will be thrown, so you don't have to check the return value any longer.

* Visibility: **public**
* This method is **static**.


#### Arguments
* $data **mixed** - &lt;p&gt;Data to be encoded as JSON&lt;/p&gt;
* $options **integer** - &lt;p&gt;JSON constants&lt;/p&gt;



### encodePretty

    string Wrap\JSON::encodePretty(mixed $data, integer $options)

Encode data to JSON with pretty printing

Same as `encode`, but with `JSON_PRETTY_PRINT` option.

* Visibility: **public**
* This method is **static**.


#### Arguments
* $data **mixed** - &lt;p&gt;Data to be encoded as JSON&lt;/p&gt;
* $options **integer** - &lt;p&gt;JSON constants&lt;/p&gt;



### decodeArray

    array|mixed Wrap\JSON::decodeArray(string $json, integer $depth, integer $options)

Decode a JSON string to an array

This is a wrapper around `json_decode`.

If there is any error, an execption will be thrown, so you don't have to check the return value any longer.

* Visibility: **public**
* This method is **static**.


#### Arguments
* $json **string** - &lt;p&gt;JSON string&lt;/p&gt;
* $depth **integer** - &lt;p&gt;Maximum array depth&lt;/p&gt;
* $options **integer** - &lt;p&gt;Decode options&lt;/p&gt;



### decodeObject

    \Wrap\stdClass|mixed Wrap\JSON::decodeObject(string $json, integer $depth, integer $options)

Decode a JSON string to a stdClass object

This is a wrapper around `json_decode`.

If there is any error, an execption will be thrown, so you don't have to check the return value any longer.

* Visibility: **public**
* This method is **static**.


#### Arguments
* $json **string** - &lt;p&gt;JSON string&lt;/p&gt;
* $depth **integer** - &lt;p&gt;Maximum array depth&lt;/p&gt;
* $options **integer** - &lt;p&gt;Decode options&lt;/p&gt;


