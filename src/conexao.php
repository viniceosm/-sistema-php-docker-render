<?php
$host = getenv("PGHOST");
$port = getenv("PGPORT");
$db   = getenv("PGDATABASE");
$user = getenv("PGUSER");
$pass = getenv("PGPASSWORD");

$connStr = "host=$host port=$port dbname=$db user=$user password=$pass";

$conn = pg_connect($connStr);

if (!$conn) {
    die("Falha na conexão com o PostgreSQL!");
}
?>
