<?php

class FormSanitizer{

    //static function prefered because there is no need to create a new instance of the class in order to use this function.
    public static function sanitizeFormString($inputText){
        $inputText = strip_tags($inputText); //remove html or php tags.
        $inputText = trim($inputText); //Remove space from the front and back
        $inputText = strtolower($inputText);
        $inputText = ucfirst($inputText); //change the first character to uppercase

        return $inputText;
    }

    public static function sanitizeFormUsername($inputText){
        $inputText = strip_tags($inputText);
        $inputText = trim($inputText); 
        $inputText = str_replace(" ","",$inputText);//Remove space from username

        return $inputText;
    }

    public static function sanitizeFormPassword($inputText){
        $inputText = strip_tags($inputText);

        return $inputText;
    }

    public static function sanitizeFormEmail($inputText){
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ","",$inputText);
       
        return $inputText;
    }
}

?>