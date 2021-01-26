<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Brain\Monkey;


/*
** Validations to consider when the 
** data to get is an array
*/

final class ArrayTypeTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        Monkey\setUp();
        $_POST = array();
        $_GET = array();
    }

    //"Validation" must be an array of strings
    public function testValidationMustBeAnArrayOfStrings(): void
    {
        $this->expectExceptionCode(401);

        $_POST = array( 'test_array'=>['item_1', 'item_2', 'item_3'] );

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            [
                'input_name' => 'test_array',
                'type' => 'array',
                'validation' => [ 'item', 2, true ]
            ]
        ];

        $form_data->set_options( $options, 'post' );

        $form_data->get();
    }

    //One of the values is not in the validation array
    public function testAValueIsNotInTheValidationArray(): void
    {
        $this->expectExceptionCode(402);

        $_POST = array( 'test_array'=>['item_1', 'item_2', 'item_3'] );

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            [
                'input_name' => 'test_array',
                'type' => 'array',
                'validation' => [ 'item_1', 'item_2' ]
            ]
        ];

        $form_data->set_options( $options, 'post' );

        $form_data->get();
    }

    //The function works corectly
    public function testTheFunctionWorksCorrectly(): void
    {
        $_POST = array( 'test_array'=>['item_1', 'item_2', 'item_3'] );

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            [
                'input_name' => 'test_array',
                'type' => 'array',
                'validation' => [ 'item_1', 'item_2', 'item_3' ]
            ]
        ];

        $form_data->set_options( $options, 'post' );

        $test_array = $form_data->get();

        $this->assertIsArray( $test_array );
        $this->assertEquals( 'item_1', $test_array['test_array'][0] );
        $this->assertEquals( 'item_2', $test_array['test_array'][1] );
        $this->assertEquals( 'item_3', $test_array['test_array'][2] );
    }

    protected function tearDown() : void
    {
        Monkey\tearDown();

        parent::tearDown();
    }
}