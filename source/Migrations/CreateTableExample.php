<?php

namespace Source\Migrations;

use Source\Migrations\Core\DDL;
use Source\Models\Example;

require dirname(dirname(__DIR__)) . "/vendor/autoload.php";

/**
 * CreateTableExample Migrations
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Migrations
 */
class CreateTableExample extends DDL
{
    /**
     * CreateTableExample constructor
     */
    public function __construct()
    {
        parent::__construct(Example::class);
    }

    public function defineTable()
    {
        $this->setClassProperties();
        $this->setKeysToProperties([
            "BIGINT AUTO_INCREMENT PRIMARY KEY",
            "VARCHAR(255) NOT NULL"
        ]);
        $this->setForeignKeyChecks(0)->dropTableIfExists()->createTableQuery()->setForeignKeyChecks(1)->executeQuery();
    }
}
executeMigrations(CreateTableExample::class);
