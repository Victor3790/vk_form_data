<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Brain\Monkey;

/*
** The "get_array" function will
** either return a sanitized or 
** a non sanitized array.
*/

final class ArrayTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        Monkey\setUp();
        $_POST = array();
        $_GET = array();
    }

    //The value is not an array
    public function testNonArrayValue(): void
    {
        $this->expectExceptionCode(112);

        $_GET = [ 'test_array' => '3' ];

        $input = new vk_form_data\input\Input();

        $test_array = $input->get_array( 'test_array', 'get' );
    }

    //The value is not set
    public function testArrayNotSet(): void
    {
        $_GET = [ 'test_array' => '3' ];

        $input = new vk_form_data\input\Input();

        $test_array = $input->get_array( 'test_array_1', 'get' );

        $this->assertEquals( null, $test_array );
    }

    //Returns a sanitized array
    public function testEscapedArray() : void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
            ->returnArg();

        $_POST = array( 'test_array'=>['item_1', 'item_2', 'item_3'] );

        $input = new vk_form_data\input\Input();

        $test_array = $input->get_array( 'test_array', 'POST', true );

        $this->assertIsArray( $test_array );
        $this->assertEquals( 'item_1', $test_array[0] );
        $this->assertEquals( 'item_2', $test_array[1] );
        $this->assertEquals( 'item_3', $test_array[2] );
    }

    //Returns a non sanitized array
    public function testNonEscapedArray() : void
    {
        $_POST = array( 'test_array'=>['item_1', 'item_2', 'item_3'] );

        $input = new vk_form_data\input\Input();

        $test_array = $input->get_array( 'test_array', 'POST', (bool)0 );

        $this->assertIsArray( $test_array );
        $this->assertEquals( 'item_1', $test_array[0] );
        $this->assertEquals( 'item_2', $test_array[1] );
        $this->assertEquals( 'item_3', $test_array[2] );
    }

    protected function tearDown() : void
    {
        Monkey\tearDown();

        parent::tearDown();
    }
}