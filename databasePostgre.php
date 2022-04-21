 <?php

$host = 'ec2-52-3-200-138.compute-1.amazonaws.com';
$port = '5432';
$username = 'csdgukdjzrpnvj';
$password = 'b7302b6c2c352669bae97f127ae61c6452529bd7fb8386df35b2b1c74181de0d';
$dbname = 'dchsh3e6qrjehn';
$connection_string = "host={$host} port={$port} dbname={$dbname} user={$username} password={$password}";

$conn = pg_connect($connection_string);

if (!$conn) {
    echo "<marquee>Not connected to db</marquee> \n";

///////////////////////////local///////////////////////////

// $host = 'localhost';
// $port = '5432';
// $username = 'kitkat';
// $password = '1234';
// $dbname = 'gonkart';
// $connection_string = "host={$host} port={$port} dbname={$dbname} user={$username} password={$password}";

// $conn = pg_connect($connection_string);

// if (!$conn) {
//     echo "<marquee>Not connected to db</marquee> \n";
}