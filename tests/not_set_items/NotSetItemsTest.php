<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/*
** Manages inputs that are not set
** e.g. checkboxes
*/

final class NotSetItemsTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $_POST = array();
    }

    //Not all items were set
    public function testNotAllItemsSet()
    {
        $_POST = [
            'string_1' => 'string_1',
            'numeric_1' => '42.3',
            'date_time_1' => '24/12/2020',
            'digit_1' => '55060'
        ];

        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $options = [
            [
                'input_name' => 'string_1',
                'type' => 'string',
                'validation' => ['string_1']
            ],
            [
                'input_name' => 'string_2',
                'type' => 'string',
                'validation' => ['string_2']
            ],
            [
                'input_name' => 'numeric_1',
                'type' => 'numeric',
                'validation' => [ 42, 43 ]
            ],
            [
                'input_name' => 'numeric_2',
                'type' => 'numeric',
                'validation' => [ 42, 43 ]
            ],
            [
                'input_name' => 'date_time_1',
                'type' => 'date_time',
                'validation' => ['d/m/Y']
            ],
            [
                'input_name' => 'date_time_2',
                'type' => 'date_time',
                'validation' => ['d/m/Y']
            ],
            [
                'input_name' => 'digit_1',
                'type' => 'digit',
                'validation' => [ 5 ]
            ],
            [
                'input_name' => 'digit_2',
                'type' => 'digit',
                'validation' => [ 2 ]
            ]
        ];

        $form_data->set_options( $options, 'post' );

        $input_values = $form_data->get();

        $this->assertIsArray( $input_values );

        $this->assertEquals( 'string_1', $input_values['string_1'] );

        $this->assertEquals( '42.3', $input_values['numeric_1'] );

        $this->assertEquals( '24/12/2020', $input_values['date_time_1'] );

        $this->assertEquals( '55060', $input_values['digit_1'] );

        $this->assertArrayNotHasKey( 'string_2', $input_values );

        $this->assertArrayNotHasKey( 'numeric_2', $input_values );

        $this->assertArrayNotHasKey( 'date_time_2', $input_values );

        $this->assertArrayNotHasKey( 'digit_2', $input_values );
    }
}