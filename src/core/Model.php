<?php

namespace app\core;

use app\helpers\Helper;

class Model
{

    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_UNIQUE = 'unique';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';

    const ERROR_MESSAGES = [
        self::RULE_REQUIRED => "this is field is required",
        self::RULE_EMAIL => "this is field contains invalid email address",
        self::RULE_MAX => "Max length is {max}",
        self::RULE_MIN => "Min length is {min}",
        self::RULE_UNIQUE => "Entered data must be unique",
    ];

    public array $errors = [];

    public function loadData(array $payload)
    {
        foreach($payload as $key => $value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

    public function validate()
    {

        foreach($this->rules() as $key => $rules){
            $value = $this->{$key};
            foreach($rules as $rule){
                $ruleName = is_array($rule) ? $rule[0] : $rule;
                if($ruleName === self::RULE_REQUIRED && strlen($value) === 0){
                    $this->addErrorForRule($key, self::RULE_REQUIRED);
                }
                if($ruleName === self::RULE_EMAIL && !Helper::emailIsValid($value))
                {
                    $this->addErrorForRule($key, self::RULE_EMAIL);
                }
                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min'])
                {
                    $this->addErrorForRule($key, self::RULE_MIN, $rule);
                }
                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max'])
                {
                    $this->addErrorForRule($key, self::RULE_MAX, $rule);
                }
                if($ruleName === self::RULE_UNIQUE)
                {
                    $columnToCheck = $rule['column'] ?? $key;
                    $tableName = $rule['tableName'];

                    $statement = Application::$app->database->prepare("SELECT * FROM $tableName WHERE $columnToCheck = :value");
                    $statement->bindValue(':value', $value);
                    $statement->execute();
                    $record = $statement->fetchObject();

                    if($record){
                        $this->addErrorForRule($key, self::RULE_UNIQUE, $rule);
                    }

                }
            }

        }

        return empty($this->errors);
    }

    public function addCustomError(string $key, string $message)
    {
        $this->errors[$key][] = $message;
    }

    private function addErrorForRule(string $key, string $erroredRule, $params = [])
    {
        $message = self::ERROR_MESSAGES[$erroredRule];

        if(!empty($params)){
            foreach($params as $paramKey => $param){
                $message = str_replace("{{$paramKey}}", $param, $message);
            }
        }

        $this->errors[$key][] = $message;
    }

    public function hasError($key)
    {

        return array_key_exists($key, $this->errors);
    }

    public function getFirstError($key)
    {
        return $this->hasError($key) ? $this->errors[$key][0] : false;
    }
}