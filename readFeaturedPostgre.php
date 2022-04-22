<?php
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST,GET");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Headers: *");
// header('Access-Control-Allow-Methods: *');
// header("Content-Type: application/json");
// header('Access-Control-Allow-Credentials: false');

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
// header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
// header("Content-Type: application/json");
// $method = $_SERVER["REQUEST_METHOD"];
// if ($method == "OPTIONS") {
// header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers", "Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
// header("Content-Type: application/json");
// header("HTTP/1.1 200 OK");
// exit();
// }

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}


// response.setHeader("Access-Control-Allow-Origin", "*");
// response.setHeader("Access-Control-Allow-Credentials", "true");
// response.setHeader("Access-Control-Allow-Methods", "GET,HEAD,OPTIONS,POST,PUT");
// response.setHeader("Access-Control-Allow-Headers", "Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");

// header('Access-Control-Allow-Origin: *');
// header('Content-Type: application/json; charset=UTF-8');
// header('Access-Control-Allow-Methods: *');
// header('Access-Control-Allow-Headers: *');

// if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
//   header('HTTP/1.1 200 OK');
//   exit();
// }

// header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X- 
// Request-Withds djllen');


// header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X- 
// Request-With');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') :
    http_response_code(405);
    echo json_encode([
        'success' => 0,
        'message' => 'Invalid Request Method. HTTP method should be GET',
    ]);
    exit;
endif;

require 'databasePostgre.php';

global $conn;


$query = "SELECT * FROM product WHERE featured = 'yes' ORDER BY ratings ASC";
$result = pg_query($conn, $query);

    if (!$result) {
    echo "Error when mining data!";
    exit;
}

while ($row = pg_fetch_assoc($result)) {
    $results[] = $row;
}
http_response_code(200);
echo json_encode([
    'success' => 1,
    'data' => $results,
]);

?>