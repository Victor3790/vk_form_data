<?php
/*
**
*/
namespace vk_form_data;

include_once 'vk_form_input/Input.php';

use vk_form_input;

class Data
{
    private $input;

    public function __construct( vk_form_input\Input $input )
    {
        $this->input = $input;
    }
}
