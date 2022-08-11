<?php


namespace app\core;

use app\helpers\Helper;

class Session
{
    private const KEY_FOR_FLASH_MESSAGES = 'flashMessages';
    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::KEY_FOR_FLASH_MESSAGES] ?? [];
        foreach($flashMessages as &$flashMessage){
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::KEY_FOR_FLASH_MESSAGES] = $flashMessages;

    }

    public function flashMessageExists($key): bool
    {
        return (bool) $this->getFlashMessage($key);
    }

    public function getFlashMessage($key)
    {
        return $_SESSION[self::KEY_FOR_FLASH_MESSAGES][$key]['value'] ?? false;
    }

    public function setFlashMessage($key, $value): void
    {
        $_SESSION[self::KEY_FOR_FLASH_MESSAGES][$key] = [
            'remove' => false,
            'value' => $value
        ];
    }

    public function get(string $key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function exists(string $key)
    {
        return (bool) $this->get($key);
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function unset(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function __destruct()
    {
        $flashMessages = $_SESSION[self::KEY_FOR_FLASH_MESSAGES] ?? [];
        if(count($flashMessages) > 0){
            foreach($flashMessages as $key => &$flashMessage){
                if($flashMessage['remove']){
                    unset($flashMessages[$key]);
                }
            }
            $_SESSION[self::KEY_FOR_FLASH_MESSAGES] = $flashMessages;
        }

    }

}