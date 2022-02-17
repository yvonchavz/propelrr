<?php
class Validation {

    public $errors = [];

    public function input($field) {
        if($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'post')
            return strip_tags(trim($_POST[$field]));
        else if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'get')
            return strip_tags(trim($_GET[$field]));
    }

    public function validate($field, $label, $rules) {

        //Split rule string on pipe sign
        $allRules = explode("|", $rules);
        $inputField = $this->input($field);
        // Check required rule in the array
        if(in_array("required", $allRules)) {
            if(empty($inputField)) {
                return $this->errors[$field][] = $label . " is required";
            }
        }
        
        if(in_array("name", $allRules)) {
            if (!preg_match("/^[a-zA-Z., ]+$/", $inputField)) {
                return $this->errors[$field][] = $label . " is invalid";
            }
        }
        
        if(in_array("email", $allRules)) {
            if (!filter_var($inputField, FILTER_VALIDATE_EMAIL)) {
                return $this->errors[$field][] = $label . " is invalid";
            }
        }
        
        if(in_array("number", $allRules)) {
            if (!filter_var($inputField, FILTER_VALIDATE_INT)) {
                return $this->errors[$field][] = $label . " is invalid";
            }
        }
        
        if(in_array("mobile", $allRules)) {
            if (!preg_match('(^(09)(\d){9}$)', $inputField)) {
                return $this->errors[$field][] = $label . " is invalid";
            }
        }
        
        if(in_array("date", $allRules)) {
            $arr  = explode('/', $inputField);
            
            if (count($arr) == 3) {
                if (!checkdate($arr[0], $arr[1], $arr[2])) {
                    return $this->errors[$field][] = $label . " is invalid";
                }
            } else {
                return $this->errors[$field][] = $label . " is invalid";
            }
        }

    }

    public function run() {
        if(empty($this->errors)) {
            return true;
        } else {
            return false;
        }
    }

}
