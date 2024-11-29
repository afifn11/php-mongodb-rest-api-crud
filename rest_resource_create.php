<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database configuration file
include_once 'mongodb_config.php';

$dbname = 'toko';
$collection = 'barang'; // Perbaikan nama variabel 'collecction' menjadi 'collection'

// DB connection
$db = new DbManager();
$conn = $db->getConnection();

// Read and decode incoming JSON request
$data = json_decode(file_get_contents("php://input"), true);

// Validasi data JSON
if (!$data || !is_array($data)) {
    echo json_encode(["message" => "Invalid JSON payload."]);
    exit;
}

// Insert record
$bulk = new MongoDB\Driver\BulkWrite();
$bulk->insert($data);

try {
    // Execute the bulk write
    $result = $conn->executeBulkWrite("$dbname.$collection", $bulk);

    // Verify insertion
    if ($result->getInsertedCount() === 1) {
        echo json_encode(["message" => "Record Successfully created"]);
    } else {
        echo json_encode(["message" => "Error while saving record"]);
    }
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo json_encode([
        "message" => "An error occurred",
        "error" => $e->getMessage()
    ]);
}

?>
