<?php
error_reporting(E_ERROR);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Access");
header("Access-Control-Allow-MEthods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset-UTF-8");

if ($_SERVER['REQUEST_METHOD'] !== 'GET'):
    http_response_code(405);
    echo json_encode([
        'success'=>0,
        'message'=> 'Bad Request! Only GET method is allowed',
    ]);
    exit;
endif;

require 'connexionDB.php';
$database = new Operations();
$conn = $database->dbConnection();

if (isset($_GET['row'])) {
    $iddortoir = $_GET['row'];
}

try {

    $sql ="SELECT * FROM members WHERE id_dortoir='$iddortoir'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if($stmt->rowCount() > 0):
        $data = null;
        
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'success'=>1,
            'data'=>$data
        ]);
    else:
        echo json_encode([
            'success'=>0,
            'data'=>''
        ]);
    
    endif;


}catch(PDOException $e){
    http_response_code(500);
    echo json_encode([
        'success'=>0,
        'message'=> $e->getMessage(),
    ]);
    exit;
}