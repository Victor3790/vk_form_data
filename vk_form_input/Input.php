<?php
/*
**  This class handles data sent using http requests (POST and GET).
**  It should be used to get data from html forms.
*/

namespace vk_form_input;

class Input
{
    public function get_string( $key = null, $default = null, $escape = false, $request = null )
    {
        $string = $this->get_data( $key, $default, $request );

        return $this->escape_text_field( $string, $escape );
    }

    public function get_numeric( $key = null, $default = null, $escape = false, $request = null )
    {
        $raw_numeric = $this->get_data( $key, $default, $request );

        $numeric =  $this->escape_text_field( $raw_numeric, $escape );

        if( !is_numeric( $numeric ) )
            throw new \Exception("VK_input: The value is not numeric", 1);

        return $numeric;
    }

    private function get_data( $key = null, $default = null, $request = null )
    {
        if( empty( $key ) )
            throw new \Exception("VK_input: No key passed or the key is not valid", 1);

        if( !is_string( $key ) || is_numeric( $key ) )
            throw new \Exception("VK_input: The key must be a string", 1);

        if( empty( $request ) )
            throw new \Exception("VK_input: No request parameter passed or it is not valid", 1);

        if( !is_string( $request ) || is_numeric( $request ) )
            throw new \Exception("VK_input: The request parameter must be a string", 1);

        $lower_request = strtolower( $request );

        switch ( $lower_request ) {
            case 'post':
                $value = (isset($_POST[$key])) ? $_POST[$key] : false;
                $value = (!empty($value)) ? $value : $default;
                break;

            case 'get':
                $value = (isset($_GET[$key])) ? $_GET[$key] : false;
                $value = (!empty($value)) ? $value : $default;
                break;
            
            default:
                throw new \Exception("VK_input: The http request is not valid", 1);
                break;
        }

        return $value;
    }

    private function escape_text_field( $string = null, $escape = false )
    {
        if( !is_bool( $escape ) )
            throw new \Exception("VK_input: Escape must be boolean", 1);

        return (!$escape) ? $string : sanitize_text_field( $string );
    }
}
