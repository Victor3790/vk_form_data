<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/*
** In case the "key" does not exist in
** $_POST the value passed in "default"
** will be returned.
*/

final class DefaultTest extends TestCase
{
    protected $input;

    protected function setUp() : void
    {
        $_POST = array( 'key'=>'value' );
        $this->input = new vk_form_data\input\Input();
    }

    //A value in "default" is passed and "key" does not exist (int)
    public function testADefaultIntValueWasPassed(): void
    {
        $value = $this->input->get_string( 'key1','post', false, -1 );

        $this->assertEquals( -1, $value );
    }

    //A value in "default" is passed and "key" does not exist (string)
    public function testADefaultStringValueWasPassed(): void
    {
        $value = $this->input->get_string( 'key1','post', false, 'No value' );

        $this->assertEquals( 'No value', $value );
    }

    //A value in "default" is not passed and "key" does not exist
    public function testADefaultValueWasNotPassed(): void
    {
        $value = $this->input->get_string( 'key1','post', false );

        $this->assertEquals( null, $value );
    }
}
