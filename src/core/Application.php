<?php

namespace app\core;

use app\models\User;

class Application
{

    const AUTH_USER_SESSION_KEY = 'authUser';

    public static string $ROOT_PATH;
    public string $userClass;
    public Database $database;
    public Router $router;
    public Request $request;
    public Session $session;
    public Response $response;
    public DbModel|null $user = null;
    public static array $config;

    public static Application $app;

    public function __construct(string $rootPath)
    {
        self::$app = $this;
        self::$ROOT_PATH = $rootPath;
        self::$config = [
            "db" => [
                "host" => $_ENV["DB_HOST"],
                "name" => $_ENV["DB_NAME"],
                "port" => $_ENV["DB_PORT"],
                "user" => $_ENV["DB_USER"],
                "password" => $_ENV["DB_PASSWORD"]
            ]
        ];

        $this->session = new Session();
        $this->database = new Database();
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);

        $this->userClass = User::class;

        $primaryValueOfUser = $this->session->get(self::AUTH_USER_SESSION_KEY);
        if ($primaryValueOfUser) {
            $primaryKeyOfUser = $this->userClass::$primaryKey;
            $this->user = $this->userClass::find([$primaryKeyOfUser => $primaryValueOfUser]);
        }
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            echo View::view('error', [
                'exception' => $e
            ]);
        }
    }

    public static function isLogged()
    {
        return self::$app->user;
    }

    public static function isGuest()
    {
        return !self::isLogged();
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKeyOfUser = $user::$primaryKey;
        $primaryValueOfUser = $user->{$primaryKeyOfUser};

        $this->session->set(self::AUTH_USER_SESSION_KEY, $primaryValueOfUser);
    }

    public function logout()
    {
        $this->user = null;
        $this->session->unset(self::AUTH_USER_SESSION_KEY);
    }
}