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

if (isset($_GET['dortoir'])) {
    $dortoir = filter_var($_GET['dortoir'], FILTER_VALIDATE_INT, [
        'options'=>[
            'default'=>'all_members',
            'min_range'=> 1
        ]
        ]);
}

try {

    $sql = is_numeric($dortoir) ? "SELECT * FROM dortoirs WHERE id='$dortoir'" : "SELECT * FROM dortoirs";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if($stmt->rowCount() > 0):
        $data = null;

        if (is_numeric($dortoir)) {

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

        } else {

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

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