<?php

namespace Daan;

abstract class database
{
    protected $database;
    public function __construct()
    {
        $storage = new \Nette\Caching\Storages\FileStorage("C:\Users\Daan\\excel\src\cache");
        $connection = new \Nette\Database\Connection("mysql:host=localhost;dbname=uploadexcel", "root", "");
        $structure = new \Nette\Database\Structure($connection, $storage);
        $conventions = new \Nette\Database\Conventions\DiscoveredConventions($structure);
        $this->database = new \Nette\Database\Explorer($connection, $structure, $conventions, null);
    }
}
