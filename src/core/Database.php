<?php


namespace app\core;

use app\helpers\Helper;

class Database
{
    public \PDO $pdo;

    public function __construct()
    {
        $host = Application::$config['db']['host'];
        $port = Application::$config['db']['port'];
        $name = Application::$config['db']['name'];
        $user = Application::$config['db']['user'];
        $password = Application::$config['db']['password'];

        $dsn = "mysql:host=$host;port=$port;dbname=$name";

        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function runMigrations()
    {
        $this->createMigrationsTable();

        $migrations = Helper::getFilesOfDirectory(Application::$ROOT_PATH . '/migrations');
        $loadedMigrations = $this->getLoadedMigrations();
        $migrationsToRun = array_diff($migrations, $loadedMigrations);
        foreach($migrationsToRun as $migration){
            require_once Application::$ROOT_PATH . '/migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();

            echo "Running migration: $migration" . PHP_EOL;
            $instance->up();
            echo "Finished migration: $migration" . PHP_EOL;

        }

        if(empty($migrationsToRun)){
            echo 'All migrations are applied';
        }else{
            $this->saveMigrations($migrationsToRun);
        }
    }

    public function prepare(string $sql)
    {
        return $this->pdo->prepare($sql);
    }
    public function prepareAndExec(string $sql)
    {
        $statement = $this->pdo->prepare($sql);
        return $statement->execute();
    }

    private function createMigrationsTable(): void
    {
        $this->pdo->exec("
           CREATE TABLE IF NOT EXISTS migrations (
               id INT AUTO_INCREMENT PRIMARY KEY,
               name VARCHAR(255),
               created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
           ) ENGINE=INNODB;
        ");
    }

    private function getLoadedMigrations()
    {
        $statement = $this->pdo->prepare("SELECT name from migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    private function saveMigrations(array $migrations = [])
    {
        $migrationsForInsert = implode(',', array_map(fn($migration) => "('$migration')", $migrations));
        $statement = $this->pdo->prepare("
            INSERT INTO migrations (name) VALUES $migrationsForInsert
        ");
        $statement->execute();
    }

}