Vk Form Data.

This library gets data from html forms from http requests. It was made for using 
in Wordpress plugins and themes.

Required parameters: 

      input_name (string): The "name" attribute in an HTML input (The identifier in the $_POST or $_GET global)
      type (string):       The data type, it could be one of the following values:
                                1.- string:     Evaluates using is_string()
                                2.- numeric:    Evaluates using is_numeric() 
                                                      (strings with numbers either int or     float types) 
                                3.- date_time:  Evaluates using is_string() and functions from 
                                                      the DateTime  object
                                4.- digit:      Evaluates using is_string() and ctype_digit()
      validation:          The validation option is an array that contains the conditions to evaluate the input.

Optional parameters:

       sanitize (boolean):     Whether to sanitize the input value, true by default.
  