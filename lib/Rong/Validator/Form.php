<?php

require_once 'Rong/Validator/Required.php';
require_once 'Rong/Validator/Email.php';
require_once 'Rong/Validator/Length.php';
require_once 'Rong/Validator/Number.php';

class Rong_Validator_Form {

    public $required_rules = array();
    public $email_rules = array();
    public $length_rules = array();
    public $number_rules = array();
    
    public $messages = array();
    public $errorClassName = "validator_error";
    public $successClassName = "validator_success";
    public $initialClassName = "validator_initial";
    public $isValid;

    /**
     * 
     * @param type $fieldName
     * @param array $config initialMessage errorMessage successMessage
     */
    public function requiredField($fieldName, $config) {
        $this->required_rules[$fieldName] = $config;
    }

    public function emailField($fieldName, $config) {
        $this->email_rules[$fieldName] = $config;
    }
    //minLength maxLength
    public function length($fieldName, $config) {
        $this->length_rules[$fieldName] = $config;
    }
    
     public function number($fieldName, $config) {
        $this->number_rules[$fieldName] = $config;
    }
    
    public function isValid() {
        $this->isValid = true;
        $this->validate("Required");
        $this->validate("Email");
        $this->validate("Length");
        $this->validate("Number");
        return $this->isValid;
    }

    public function validate($type) {
        $rules = array();
        if ($type == "Required") {
            $rules = $this->required_rules;
        } elseif ($type == "Email") {
            $rules = $this->email_rules;
        }
        elseif( $type == "Length" )
        {
            $rules = $this->length_rules;
        }elseif( $type == "Number" )
        {
            $rules = $this->number_rules;
        }

        foreach ($rules as $fieldName => $config) {
            if (isset($_POST[$fieldName])) {
                if( !isset( $this->messages[$fieldName] ) )
                {
                    $this->messages[$fieldName] = "";
                }
                $validator = null;
                if ($type == "Required") {
                    $validator = new Rong_Validator_Required($_POST[$fieldName]);
                } elseif ($type == "Email") {
                    $validator = new Rong_Validator_Email($_POST[$fieldName]);
                }
                elseif( $type == "Length" )
                {
                    $validator = new Rong_Validator_Length( $_POST[$fieldName] );
                    $validator->minLength = $config["minLength"];
                    $validator->maxLength = $config["maxLength"];
                }
                elseif( $type == "Number" )
                {
                    $validator = new Rong_Validator_Number($_POST[$fieldName] );
                }
                $className = $this->errorClassName;
                $message = $config["errorMessage"];
                if ($validator->isValid()) {
                    $className = $this->successClassName;
                    $message = $config["successMessage"];
                } else {
                    $this->isValid = false;
                }
                $this->messages[$fieldName] .= "<span class=\"" . $className . "\">" . $message . "</span>";
            } else {
                if( !isset( $this->messages[$fieldName] ) )
                {
                    $this->messages[$fieldName] = "";
                }
                $this->messages[$fieldName] .= "<span class=\"" . $this->initialClassName . "\">" . $config["initialMessage"] . "</span>";
            }
        }
    }

    public function clearMessage() {
        foreach ($this->messages as $fieldName => $message) {
            $this->messages[$fieldName] = "";
        }
    }

    public function getMessage($fieldName) {
        return $this->messages[$fieldName];
    }

}

?>
