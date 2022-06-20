<?php
error_reporting(E_ERROR);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Access");
header("Access-Control-Allow-MEthods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset-UTF-8");

if ($_SERVER['REQUEST_METHOD'] !== 'POST'):
    http_response_code(405);
    echo json_encode([
        'success'=>0,
        'message'=> 'Bad Request! Only POST method is allowed',
    ]);
    exit;
endif;

require 'connexionDB.php';
$database = new Operations();
$conn = $database->dbConnection();

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->firstname) || !isset($data->lastname) || !isset($data->sexe) ) {
    echo json_encode([
        'success'=>0,
        'message'=> 'Les champs obligatoires vides! Remplir tous ces champs',
    ]);
    exit;
}elseif (empty(trim(($data->firstname))) || empty(trim(($data->lastname))) || empty(trim(($data->sexe)))) {
    echo json_encode([
        'success'=>0,
        'message'=> 'Les champs vides! Remplir tous les champs',
    ]);
    exit;
}

$firstname = htmlspecialchars(trim($data->firstname));
$lastname = htmlspecialchars(trim($data->lastname));
$sexe = htmlspecialchars(trim($data->sexe));
$birthday = $data->birthday;
$phone = $data->phone;
$poste = $data->poste;
$id_circonscription = $data->id_circonscription;
$secteur = $data->secteur;
$localite = $data->localite;
$picture = $data->picture;
$observation = $data->observation;
$creation_date = $data->creation_date;
$update_date = $data->update_date;

$query ="INSERT INTO `members`
        (`firstname`, `lastname`, `birthday`, `phone`, `sexe`, `poste`, `id_circonscription`, `secteur`,
         `localite`, `picture`, `observation`, `creation_date`, `update_date`) 
        VALUES 
        (:firstname, :lastname, :birthday, :phone, :sexe, :poste, :id_circonscription, :secteur,
         :localite, :picture, :observation, :creation_date, :update_date)";

        $stmt = $conn->prepare($query);

        $stmt->bindValue(':firstname',$firstname, PDO::PARAM_STR);
        $stmt->bindValue(':lastname',$lastname, PDO::PARAM_STR);
        $stmt->bindValue(':birthday',$birthday, PDO::PARAM_STR);
        $stmt->bindValue(':phone',$phone, PDO::PARAM_STR);
        $stmt->bindValue(':sexe',$sexe, PDO::PARAM_STR);
        $stmt->bindValue(':poste',$poste, PDO::PARAM_STR);
        $stmt->bindValue(':id_circonscription',$id_circonscription, PDO::PARAM_STR);
        $stmt->bindValue(':secteur',$secteur, PDO::PARAM_STR);
        $stmt->bindValue(':localite',$localite, PDO::PARAM_STR);
        $stmt->bindValue(':picture',$picture, PDO::PARAM_STR);
        $stmt->bindValue(':observation',$observation, PDO::PARAM_STR);
        $stmt->bindValue(':creation_date',$creation_date, PDO::PARAM_STR);
        $stmt->bindValue(':update_date',$update_date, PDO::PARAM_STR);

        if ($stmt->execute()) {
            http_response_code(405);
            echo json_encode([
                'success'=>1,
                'message'=> 'Membre ajoute avec succes !',
            ]);
            exit;
        }

        echo json_encode([
            'success'=>0,
            'message'=> 'Echec ajout du membre !',
        ]);
        exit;