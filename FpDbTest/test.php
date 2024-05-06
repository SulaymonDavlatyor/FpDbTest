<?php

use FpDbTest\Database;
use FpDbTest\DatabaseTest;

//I made small change here, since this function couldn't autoload classes from folders
spl_autoload_register(function ($class) {
    $a = array_filter(explode('\\', $class), function ($part) {
        return $part !== 'FpDbTest';
    });
    if (!$a) {
        throw new Exception();
    }
    $filename = implode('/', [__DIR__, ...$a]) . '.php';

    require_once $filename;
});

$mysqli = @new mysqli('localhost', 'root', 'password', 'database', 3306);
if ($mysqli->connect_errno) {
    throw new Exception($mysqli->connect_error);
}

$db = new Database($mysqli);
$test = new DatabaseTest($db);
$test->testBuildQuery();

exit('OK');
