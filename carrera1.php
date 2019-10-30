<?php
require('conexion2.php');

function buscarCarrera() {
    $cn = getConexion();  

    try {
        $stm = $cn->query("SELECT * FROM carrera");
        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);

    } catch(Exception $ex){
        // print_r($ex);
    }
    
    $data=[];
    foreach ($rows as $row){
        $data[]= [
            "id" => $row["id"],
            "nombre" =>$row["nombre"]
        ];
    }

    // print_r($data);

    header("Content-Type: application/json",true);
    $data = json_encode($data);
    echo $data;

}

function guardarCarrera() {
    $postdata=file_get_contents("php://input");
    $data= json_decode($postdata, true);
    $cn= getConexion();
    //$stm= $pdo->prepare("INSERT INTO carrera(nombre) VALUE (:nombre)");
    $stm= $cn->prepare("INSERT INTO carrera (nombre) VALUE (:nombre)");
    $stm->bindparam(":nombre",$data["nombre"]);
    $data=$stm->execute();
        echo'Guardar Carrera';
    }

$method= $_SERVER["REQUEST_METHOD"];
switch ($method) {
    case 'POST':
        guardarCarrera();
        break;
    case 'GET':
        buscarCarrera();
        break;
    case 'DELATE':
    case 'PUT':
    default:
        echo'TO BE IMPLEMENTED'; 
    }  
?>