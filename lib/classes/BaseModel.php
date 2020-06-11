<?php
namespace portfolio;

use portfolio\Database;

abstract class BaseModel
{
    function __construct()
    {
        $this->db = new Database(
            DB_SERVER,
            DB_USER,
            DB_PASSWORD,
            DB_NAME
        );
    }
}
