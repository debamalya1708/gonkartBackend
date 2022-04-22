<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: access");
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Headers: Origin, Content-Type, Access-Control-Allow-Headers,Accept, Authorization, X-Requested-With");

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
$category =null;
$query=null;
if(isset($_GET['category'])){
    $category = $_GET['category'];
    $query = "SELECT * FROM product WHERE category LIKE %Gifts% ORDER BY ratings ASC";
} else {
    $query = "SELECT * FROM product";
}

// $query = "SELECT * FROM product";
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