<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Brain\Monkey;


/*
** Validations to consider when the 
** data to get is date time
*/

final class DateTimeTypeTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        Monkey\setUp();
        $_POST = array();
        $_GET = array();
    }

    //Non sanitized string returned
    public function testGetNonSanitizedDateTimeString(): void
    {
        $_GET = [ 'date' => '01/21/2021' ];

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            [
                'input_name' => 'date',
                'type' => 'date_time',
                'validation' => ['m/d/Y']
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();

        $this->assertIsArray( $input_values );
        $this->assertEquals( '01/21/2021', $input_values['date'] );
    }

    //Sanitized string returned
    public function testGetSanitizedDateTimeString(): void
    {
        Brain\Monkey\Functions\When( 'sanitize_text_field' )
                    ->returnArg();

        $_GET = [ 'date' => '01/21/2021' ];

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            [
                'input_name' => 'date',
                'type' => 'date_time',
                'validation' => ['m/d/Y'],
                'sanitize' => true
            ]
        ];

        $form_data->set_options( $options, 'get' );

        $input_values = $form_data->get();

        $this->assertIsArray( $input_values );
        $this->assertEquals( '01/21/2021', $input_values['date'] );
    }

    protected function tearDown() : void
    {
        Monkey\tearDown();

        parent::tearDown();
    }
}