<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Brain\Monkey;


/*
** Validations to consider when the 
** data to get is string
*/

final class NumericTypeTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        Monkey\setUp();
        $_POST = array();
        $_GET = array();
    }

    //Non sanitized numeric returned
    public function testGetNonSanitizedNumeric(): void
    {
        $_GET = [ 'amount' => '200' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'amount',
                'type' => 'numeric',
                'validation' => [1,500]
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();

        $this->assertIsArray( $input_values );
        $this->assertEquals( '200', $input_values['amount'] );
    }

    //Sanitized string returned
    public function testGetSanitizedNumeric(): void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
                    ->returnArg();

        $_GET = [ 'amount' => '200' ];

        $form_data = new vk_form_data\Data( new vk_form_input\Input );

        $options = [
            [
                'input_name' => 'amount',
                'type' => 'string',
                'validation' => [1, 500],
                'sanitize' => true
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();

        $this->assertIsArray( $input_values );
        $this->assertEquals( '200', $input_values['amount'] );
    }

    protected function tearDown() : void
    {
        Monkey\tearDown();

        parent::tearDown();
    }
}