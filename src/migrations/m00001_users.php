<?php


use app\core\Migration;

class m00001_users extends Migration {

    public function up()
    {
        $this->db->pdo->exec("
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                surname VARCHAR(255) NULL,
                email VARCHAR(255) NOT NULL,
                status TINYINT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;
        ");
    }

    public function down()
    {
        $this->db->pdo->exec("
            DROP TABLE users;
        ");
    }

}