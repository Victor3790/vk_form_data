<?php
/*
**  This class handles data sent using http requests (POST and GET).
**  It should be used to get data from html forms.
*/

namespace vk_form_input;

class Input
{
    public function get_string_post( $key = null, $default = null, $escape = false )
    {
        $post_string = $this->get_post_data( $key, $default );
        return $post_string;
    }

    private function get_post_data( $key = null, $default = null, $escape = false )
    {
        if( empty( $key ) )
            throw new \Exception("VK_input: No key passed or the key is not valid", 1);

        if( !is_string( $key ) || is_numeric( $key ) )
            throw new \Exception("VK_input: The key must be a string", 1);
            
        $value = (isset($_POST[$key])) ? $_POST[$key] : false;
        $value = (!empty($value)) ? $value : $default;

        sanitize_text_field($value);

        return $value;
    }
}
