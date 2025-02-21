<?php

require_once __DIR__ . '/../controllers/example_controller.php';
require_once __DIR__ . '/../controllers/store_controller.php';
require_once __DIR__ . '/../utils/database.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

$uri = $_SERVER['REQUEST_URI'];

$uriSegments = explode('/', parse_url($uri, PHP_URL_PATH));

$dbConnection = (new Database())->getConnection();

$exampleController = new ExampleController($dbConnection);

$storeController = new StoreController($dbConnection);

$id = isset($uriSegments[2]) ? intval($uriSegments[2]) : null;

if ($uriSegments[1] === 'example') 
{
    switch ($requestMethod) 
    {
        case 'GET':
            if ($id) 
            {
                $response = $exampleController->get($id);
            } 
            else 
            {
                $response = $exampleController->getAll();
            }
            break;
        case 'POST':
            $response = $exampleController->create();
            break;
        case 'PUT':
            if ($id) 
            {
                $response = $exampleController->update($id);
            } 
            else {
                $response = ['status' => 'error', 'message' => 'Invalid example ID'];
            }
            break;
        case 'DELETE':
            if ($id) 
            {
                $response = $exampleController->delete($id);
            } 
            else 
            {
                $response = ['status' => 'error', 'message' => 'Invalid example ID'];
            }
            break;
        default:
            $response = ['status' => 'error', 'message' => 'Invalid request method'];
            break;
    }
} 
else if($uriSegments[1] === 'store')
{
    $detailed = isset($uriSegments[3]) ? boolval($uriSegments[3]) : null;

    switch($requestMethod)
    {
        case "GET":
            if($id && !$detailed)
            {
                $response = $storeController->getStoreById($id);
            }
            else if($id && $detailed)
            {
                $response = $storeController->getDetailedStore($id);
            }
            else
            {
                $response = $storeController->getAllStores();
            }
            break;
        default:
            $response = ['status' => 'error', 'message' => 'Invalid request method'];
            break;
    }
}
else 
{
    $response = ['status' => 'error', 'message' => 'Invalid API endpoint'];
}

header('Content-Type: application/json');

// CORS
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') 
{
    http_response_code(200);
    exit;
}

echo json_encode($response);

?>