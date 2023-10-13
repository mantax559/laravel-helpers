<?php

namespace Mantax559\LaravelHelpers\Test\Unit;

use Orchestra\Testbench\TestCase;

class HelpersTest extends TestCase
{
    public function test_mb_ucfirst()
    {
        $this->assertEquals('Aceis aceis', mb_ucfirst('aceis aceis'));
        $this->assertEquals('Ąčęėįš ąčęėįš', mb_ucfirst('ąčęėįš ąčęėįš'));
        $this->assertEquals('Ктуальная ктуальнаЯ', mb_ucfirst('ктуальная ктуальнаЯ'));
    }

    public function test_mb_ucwords()
    {
        $this->assertEquals('Aceis Aceis Aceis', mb_ucwords('aceis aceis aceis'));
        $this->assertEquals('Ąčęėįš Ąčęėįš Ąčęėįš', mb_ucwords('ąčęėįš ąčęėįš ąčęėįš'));
        $this->assertEquals('Ктуальная Ктуальная Ктуальная', mb_ucwords('ктуальная ктуальная ктуальная'));
    }

    public function test_external_code()
    {
        $this->assertEquals('dGVzdMSFxI3EmcSXxK/FocSFxI3EmcSXxK/FocSFxI3EmcSXxK/FoQ==', external_code('Ąčęėįš Ąčęėįš Ąčęėįš', 'test'));
        $this->assertEquals('216f91e6f3a645c1c411fb2da528b042', external_code('Ąčęėįš Ąčęėįš Ąčęėįš', 'test', 'md5'));
    }

    public function test_external_code_decode()
    {
        $this->assertEquals('testąčęėįšąčęėįšąčęėįš', external_code_decode('dGVzdMSFxI3EmcSXxK/FocSFxI3EmcSXxK/FocSFxI3EmcSXxK/FoQ=='));
    }

    public function test_price()
    {
        $this->assertEquals('123456789.5432€', price(123456789.54321));
        $this->assertEquals('123456789.54€', price(123456789.54321, 2));
    }

    public function seconds()
    {
        $this->assertEquals('123456789.5432s', seconds(123456789.54321));
        $this->assertEquals('123456789.54s', seconds(123456789.54321, 2));
    }

    public function test_percentage()
    {
        $this->assertEquals('123456789.5432%', percentage(123456789.54321, 4));
        $this->assertEquals('123456789.54%', percentage(123456789.54321));
    }

    public function test_slugify()
    {
        $this->assertEquals('test-ktual-naa-eec-235', slugify('Test Ктуальная ėęč 235'));
    }

    public function test_escape_html()
    {
        $this->assertEquals('test test', escape_html('test&nbsp;test'));
        $this->assertEquals('test&test', escape_html('test&amp;test'));
        $this->assertEquals('test<test', escape_html('test&lt;test'));
        $this->assertEquals('test>test', escape_html('test&gt;test'));
        $this->assertEquals('test"test', escape_html('test&quot;test'));
        $this->assertEquals('test\'test', escape_html('test&#039;test'));
    }

    public function test_trim_ean()
    {
        $this->assertEquals(8453512165, trim_ean('  TeSt 00 845351 21  ęėč - 65'));
        $this->assertEquals([8453512165, 8453513265], trim_ean(['  TeSt 00 845351 21  ęėč - 65', '  TeSt 00 845351 32 ęėč - 65']));
        $this->assertEquals(null, trim_ean([]));
        $this->assertEquals(null, trim_ean([], true));
        $this->assertEquals(null, trim_ean(null));
        $this->assertEquals(null, trim_ean(null), true);
    }

    public function test_format_string()
    {
        $string = '  TeSt 00 845351 " 21  ęėč - 65';

        $this->assertEquals('Test 00 845351 " 21 ęėč - 65', format_string($string, 1));
        $this->assertEquals('Test 00 845351 " 21 Ęėč - 65', format_string($string, 2));
        $this->assertEquals('test 00 845351 " 21 ęėč - 65', format_string($string, 3));
        $this->assertEquals('TEST 00 845351 " 21 ĘĖČ - 65', format_string($string, 4));
        $this->assertEquals('008453512165', format_string($string, 5));
        $this->assertEquals('TeSt 00 845351 21 ęėč - 65', format_string($string, 6));
        $this->assertEquals('TeSt00845351"21ęėč-65', format_string($string, 7));
    }

    public function test_str_pad_left()
    {
        $this->assertEquals('11abc', str_pad_left('abc', 5, '1'));
    }

    public function test_array_to_string()
    {
        $this->assertEquals('one. two. three.', array_to_string(['one', 'two', 'three']));
    }

    public function test_code_format()
    {
        $this->assertEquals('ORD-TWO2', code_format('app.prefix.order', 'TWO2'));
    }

    public function test_bytes_conversion()
    {
        $this->assertEquals('1.00 B', bytes_conversion(1));
        $this->assertEquals('1000.00 B', bytes_conversion(1000));
        $this->assertEquals('976.56 kB', bytes_conversion(1000000));
        $this->assertEquals('953.67 MB', bytes_conversion(1000000000));
        $this->assertEquals('931.32 GB', bytes_conversion(1000000000000));
        $this->assertEquals('909.49 TB', bytes_conversion(1000000000000000));
        $this->assertEquals('888.18 PB', bytes_conversion(1000000000000000000));
        $this->assertEquals('867.36 EB', bytes_conversion(1000000000000000000000));
        $this->assertEquals('847.03 ZB', bytes_conversion(1000000000000000000000000));
        $this->assertEquals('827.18 YB', bytes_conversion(1000000000000000000000000000));
    }

    public function test_file_size()
    {
        // TODO: Create logic
    }

    public function test_unique_multidim_array()
    {
        $array = [
            ['product_id' => 1, 'category_id' => 2],
            ['product_id' => 1, 'category_id' => 2],
            ['product_id' => 1, 'category_id' => 2],
            ['product_id' => 2, 'category_id' => 1],
            ['product_id' => 2, 'category_id' => 1],
        ];

        $expected_array = [
            ['product_id' => 1, 'category_id' => 2],
            ['product_id' => 2, 'category_id' => 1],
        ];

        $this->assertEquals($expected_array, unique_multidim_array($array, 'product_id', 'category_id'));
    }
}
