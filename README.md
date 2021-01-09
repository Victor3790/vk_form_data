Vk Form Data.

This library gets data from html forms from http requests. It was made for using 
in Wordpress plugins and themes.

Required parameters: 

      input_name (string): The "name" attribute in an HTML input (The identifier in the $_POST or $_GET global)
      type (string):       The data type, it could be one of the following values:
                                1.- string:     Evaluates using is_string()
                                2.- numeric:    Evaluates using is_numeric() (strings with numbers)
                                3.- date:       Evaluates using is_string() and checkdate()
                                4.- int:        Evaluates using is_numeric() and is_int() 
                                                   (min and max are the minimum and maximum decimal value
                                                    rather than the minimum and maximum lenght of a string)
       min (int):           The minimun length the value must have
                            Note: if no "max" parameter is specified, the length of the value must equal "min"
Optional parameters:
   
       max (int):              The maximum length the value must have
                               Note: if no "max" parameter is specified, the length of the value must equal "min"
       sanitize (boolean):     Whether to sanitize the input value, true by default.
       specific (string):      The specific type, it could be one of the following values:
                                1.- mail:     Gets using sanitize_email()    