<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/*
** The Form_Data class gets data from
** html forms through the Input class
*/

final class ObjectCreationTest extends TestCase
{
    //Form_Data object creation
    public function testForm_DataObjectCreation(): void
    {
        $form_data = new vk_form_data\Data( new vk_form_data\input\Input );

        $this->assertInstanceOf( 'vk_form_data\Data', $form_data );
    }

}