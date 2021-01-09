<?php
/*
**  This class handles data sent using http requests (POST and GET).
**  It should be used to get data from html forms.
*/

namespace vk_form_input;

class Input
{
    public function get_string( $key = null, $default = null, $escape = false )
    {
        $string = $this->get_post_data( $key, $default, $escape );
        return $string;
    }

    private function get_post_data( $key = null, $default = null, $escape = false )
    {
        if( empty( $key ) )
            throw new \Exception("VK_input: No key passed or the key is not valid", 1);

        if( !is_string( $key ) || is_numeric( $key ) )
            throw new \Exception("VK_input: The key must be a string", 1);

        if( !is_bool( $escape ) )
            throw new \Exception("VK_input: Escape must be boolean", 1);
            
        $value = (isset($_POST[$key])) ? $_POST[$key] : false;
        $value = (!empty($value)) ? $value : $default;

        return (!$escape) ? $value : sanitize_text_field($value);
    }
}
