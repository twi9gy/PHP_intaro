<?php
$ini_array = parse_ini_file("../parameters.ini", true);
try {
    $connection = new PDO("pgsql:host={$ini_array['db']['host']};user={$ini_array['db']['user']};
    password={$ini_array['db']['password']};dbname={$ini_array['db']['dbname']}");
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}