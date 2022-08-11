<?php

namespace app\core\interfaces;

interface MigrationInterface {
    public function up ();
    public function down ();
}