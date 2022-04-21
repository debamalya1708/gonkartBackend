<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function cors() {
    
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
        exit(0);
    }
    
    echo "You have CORS!";
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') :
    http_response_code(405);
    echo json_encode([
        'success' => 0,
        'message' => 'Invalid Request Method. HTTP method should be POST',
    ]);
    exit;
endif;



require 'databasePostgre.php';
// $database = new Database();
// $conn = $database->dbConnection();
global $conn;
$data = json_decode(file_get_contents("php://input"));
if (!isset($data->title) || !isset($data->description) 
|| !isset($data->images) || !isset($data->price) 
|| !isset($data->link) || !isset($data->category) || !isset($data->subCategory)
|| !isset($data->featured) || !isset($data->ratings) || !isset($data->occasions) || !isset($data->brand)) :

    echo json_encode([
        'success' => 0,
        'message' => 'Please fill all the fields | title , description , country, images, price , link , category , age section , featured , ratings , occasions , brand.',
    ]);
    exit;

    // titile , description , country, images, price , link , category , subCategory , featured , ratings , occasions , brand.

elseif (empty(trim($data->title)) || empty(trim($data->description)) || empty(trim($data->images))
|| empty(trim($data->price))|| empty(trim($data->link))|| empty(trim($data->category))|| empty(trim($data->subCategory))
|| empty(trim($data->featured)) || empty(trim($data->ratings)) || empty(trim($data->occasions))|| empty(trim($data->brand))) :

    echo json_encode([
        'success' => 0,
        'message' => 'Oops! empty field detected. Please fill all the fields.',
    ]);
    exit;

endif;

try {

    $title = htmlspecialchars(trim($data->title));
    $description = htmlspecialchars(trim($data->description));
    // $country = htmlspecialchars(trim($data->country));
    $images = htmlspecialchars(trim($data->images));
    $price = htmlspecialchars(trim($data->price));
    $link = htmlspecialchars(trim($data->link));
    $category = htmlspecialchars(trim($data->category));
    $subCategory = htmlspecialchars(trim($data->subCategory));
    $featured = htmlspecialchars(trim($data->featured));
    $ratings = htmlspecialchars(trim($data->ratings));
    $occasions = htmlspecialchars(trim($data->occasions));
    $brand = htmlspecialchars(trim($data->brand));

    $query = "INSERT INTO product(title,description,images,price,link,category,subCategory,featured,ratings,occasions,brand)
     VALUES('$title','$description','$images','$price','$link','$category','$subCategory','$featured','$ratings','$occasions','$brand')";

    // $stmt = $conn->prepare($query);
    $stmt = pg_query($conn, $query);



    // $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    // $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    // // $stmt->bindValue(':country', $country, PDO::PARAM_STR);
    // $stmt->bindValue(':images', $images, PDO::PARAM_STR);
    // $stmt->bindValue(':price', $price, PDO::PARAM_STR);
    // $stmt->bindValue(':link', $link, PDO::PARAM_STR);
    // $stmt->bindValue(':category', $category, PDO::PARAM_STR);
    // $stmt->bindValue(':subCategory', $subCategory, PDO::PARAM_STR);
    // $stmt->bindValue(':featured', $featured, PDO::PARAM_STR);
    // $stmt->bindValue(':ratings', $ratings, PDO::PARAM_STR);
    // $stmt->bindValue(':occasions', $occasions, PDO::PARAM_STR);
    // $stmt->bindValue(':brand', $brand, PDO::PARAM_STR);

    if ($stmt) {

        http_response_code(201);
        echo json_encode([
            'success' => 1,
            'message' => 'Data Inserted Successfully.'
        ]);
        exit;
    }
    
    echo json_encode([
        'success' => 0,
        'message' => 'Data not Inserted.'
    ]);
    exit;

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => 0,
        'message' => $e->getMessage()
    ]);
    exit;
}
// function insert($data)
// {
//     global $conn;

//     $mine_result = $data['title'];
//     // $mine_color = $data['mine_color'];
//     // $date = $data['install_date'];
//     // $owner = $data['mine_owner'];

//     $query = "INSERT INTO product(title) VALUES('title')";

//     // $query = "INSERT INTO mining_tb(mine_result,mine_color,install_date,mine_owner) VALUES('$mine_result','$mine_color','$date','$owner')";

//     $insert = pg_query($conn, $query);

//     return pg_affected_rows($insert);
// }