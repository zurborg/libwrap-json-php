<?php

use Wrap\JSON;

class WrapJsonTest extends PHPUnit_Framework_TestCase
{
    public function testEncode()
    {
        $this->assertSame(JSON::encode(0), '0');
        $this->assertSame(JSON::encode(123), '123');
        $this->assertSame(JSON::encode(0.0), '0.0');
        $this->assertSame(JSON::encode(123.456), '123.456');
        $this->assertSame(JSON::encode(-0), '0');
        $this->assertSame(JSON::encode(-123), '-123');
        $this->assertSame(JSON::encode(-123.456), '-123.456');
        $this->assertSame(JSON::encode('foobar'), '"foobar"');
        $this->assertSame(JSON::encode('foo/bar'), '"foo/bar"');
        $this->assertSame(JSON::encode('æßðđŋħĸł'), '"æßðđŋħĸł"');
        $this->assertSame(JSON::encode(null), 'null');
        $this->assertSame(JSON::encode((array)[]), '[]');
        $this->assertSame(JSON::encode((object)[]), '{}');
        $this->assertSame(JSON::encode([1,2,3]), '[1,2,3]');
        $this->assertSame(JSON::encode(['foo'=>'bar']), '{"foo":"bar"}');
    }

    /**
     * @expectedException Wrap\JSON\EncodeException
     * @expectedExceptionMessage Inf and NaN cannot be JSON encoded
     */
    public function testEncodeException()
    {
        JSON::encode(log(0));
    }

    public function testEncodePretty()
    {
        $this->assertSame(JSON::encodePretty(0), '0');
        $this->assertSame(JSON::encodePretty(123), '123');
        $this->assertSame(JSON::encodePretty(0.0), '0.0');
        $this->assertSame(JSON::encodePretty(123.456), '123.456');
        $this->assertSame(JSON::encodePretty(-0), '0');
        $this->assertSame(JSON::encodePretty(-123), '-123');
        $this->assertSame(JSON::encodePretty(-123.456), '-123.456');
        $this->assertSame(JSON::encodePretty('foobar'), '"foobar"');
        $this->assertSame(JSON::encodePretty('foo/bar'), '"foo/bar"');
        $this->assertSame(JSON::encodePretty('æßðđŋħĸł'), '"æßðđŋħĸł"');
        $this->assertSame(JSON::encodePretty(null), 'null');
        $this->assertSame(JSON::encodePretty((array)[]), '[]');
        $this->assertSame(JSON::encodePretty((object)[]), '{}');
        $this->assertSame(JSON::encodePretty([1,2,3]), "[\n    1,\n    2,\n    3\n]");
        $this->assertSame(JSON::encodePretty(['foo'=>'bar']), "{\n    \"foo\": \"bar\"\n}");
    }

    public function testDecodeArray()
    {
        $this->assertSame(0, JSON::decodeArray('0'));
        $this->assertSame(123, JSON::decodeArray('123'));
        $this->assertSame(0.0, JSON::decodeArray('0.0'));
        $this->assertSame(123.456, JSON::decodeArray('123.456'));
        $this->assertSame(-0, JSON::decodeArray('0'));
        $this->assertSame(-123, JSON::decodeArray('-123'));
        $this->assertSame(-123.456, JSON::decodeArray('-123.456'));
        $this->assertSame('foobar', JSON::decodeArray('"foobar"'));
        $this->assertSame('foo/bar', JSON::decodeArray('"foo/bar"'));
        $this->assertSame('æßðđŋħĸł', JSON::decodeArray('"æßðđŋħĸł"'));
        $this->assertSame(null, JSON::decodeArray('null'));
        $this->assertSame([], JSON::decodeArray('[]'));
        $this->assertSame([], JSON::decodeArray('{}'));
        $this->assertSame([1,2,3], JSON::decodeArray('[1,2,3]'));
        $this->assertSame(['foo'=>'bar'], JSON::decodeArray('{"foo":"bar"}'));
    }

    public function testDecodeObject()
    {
        $this->assertSame(0, JSON::decodeObject('0'));
        $this->assertSame(123, JSON::decodeObject('123'));
        $this->assertSame(0.0, JSON::decodeObject('0.0'));
        $this->assertSame(123.456, JSON::decodeObject('123.456'));
        $this->assertSame(-0, JSON::decodeObject('0'));
        $this->assertSame(-123, JSON::decodeObject('-123'));
        $this->assertSame(-123.456, JSON::decodeObject('-123.456'));
        $this->assertSame('foobar', JSON::decodeObject('"foobar"'));
        $this->assertSame('foo/bar', JSON::decodeObject('"foo/bar"'));
        $this->assertSame('æßðđŋħĸł', JSON::decodeObject('"æßðđŋħĸł"'));
        $this->assertSame(null, JSON::decodeObject('null'));
        $this->assertSame([], JSON::decodeObject('[]'));
        $this->assertEquals(new stdClass((object)[]), JSON::decodeObject('{}'));
        $this->assertEquals([1,2,3], JSON::decodeObject('[1,2,3]'));
        $obj = new stdClass((object)[]);
        $obj->foo = 'bar';
        $this->assertEquals($obj, JSON::decodeObject('{"foo":"bar"}'));
    }

    public function testPHP5()
    {
        if (version_compare(PHP_VERSION, '7.0.0') < 0) {
            $this->assertSame(JSON::encode(0.0), '0.0');
            $this->assertSame(JSON::encodePretty(0.0), '0.0');
            $this->assertSame(0.0, JSON::decodeObject('0.0'));
            $this->assertSame(0.0, JSON::decodeArray('0.0'));
        }
    }

    public function testPHP7()
    {
        if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
            $this->assertSame(JSON::encode(-0.0), '-0.0');
            $this->assertSame(JSON::encodePretty(-0.0), '-0.0');
            $this->assertSame(-0.0, JSON::decodeObject('-0.0'));
            $this->assertSame(-0.0, JSON::decodeArray('-0.0'));
        }
    }

    /**
     * @expectedException Wrap\JSON\DecodeException
     */
    public function testDecodeException()
    {
        JSON::decodeArray('{["');
    }
}
