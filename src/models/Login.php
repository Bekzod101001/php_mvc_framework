<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use app\enums\UserStatus;

class Login extends DbModel
{
    public static string $tableName = 'users';
    public array $attributes = ['email', 'password'];
    public string $email = '';
    public string $password = '';

    public function rules()
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 5]],
        ];
    }

    public function handle()
    {
        $user = User::find([
            'email' => $this->email
        ]);

        if (!$user) {
            $this->addCustomError("email", "Email doesn't exists");
        }

        if (!password_verify($this->password, $user->password)) {
            $this->addCustomError("password", "Incorrect password");
        }

        Application::$app->login($user);

        return true;
    }
}