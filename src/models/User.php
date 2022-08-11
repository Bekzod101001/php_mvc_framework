<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use app\enums\UserStatus;

class User extends DbModel
{
    public static string $tableName = 'users';
    public static string $primaryKey = 'id';
    public array $attributes = ['name', 'surname', 'email', 'password', 'status'];
    public string $name = '';
    public string $surname = '';
    public string $email = '';
    public string $password = '';
    public int $status = UserStatus::INACTIVE;

    public function create()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        parent::create();

        return true;
    }

    public function rules()
    {
        return [
            'name' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 32]],
            'surname' => [[self::RULE_MAX, 'max' => 32]],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE,
                'tableName' => self::$tableName
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 5]],
        ];
    }
}