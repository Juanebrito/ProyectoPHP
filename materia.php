<?php
require('conexion2.php');

function buscarMateria() {
    $cn = getConexion();  

    try {
        $stm = $cn->query("SELECT * FROM materia");
        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);

    } catch(Exception $ex){
        // print_r($ex);
    }
    
    $data=[];
    foreach ($rows as $row){
        $data[]= [
            "id" => $row["id"],
            "nombre" =>$row["nombre"],
            "creditos" =>$row["creditos"]
            //"carrera_materia" =>$row["carrera_materia"],
            //"carrera_id" =>$row["carrera_id"]
        ];
    }

     print_r($data);

    header("Content-Type: application/json",true);
    $data = json_encode($data);
    echo $data;

}

function guardarMateria() {
    $postdata=file_get_contents("php://input");
    $data= json_decode($postdata, true);
    $cn= getConexion();
    //$stm= $pdo->prepare("INSERT INTO carrera(nombre) VALUE (:nombre)");
    $stm= $cn->prepare("INSERT INTO materia (nombre,creditos) VALUE (:nombre,:creditos)");
    $stm->bindparam(":nombre",$data["nombre"]);
    $stm->bindparam(":creditos",$data["creditos"]);


    $data=$stm->execute();
        echo'Guardar Materia';
    }

$method= $_SERVER["REQUEST_METHOD"];
switch ($method) {
    case 'POST':
        guardarMateria();
        break;
    case 'GET':
        buscarMateria();
        break;
    case 'DELATE':
    case 'PUT':
    default:
        echo'TO BE IMPLEMENTED'; 
    }  
?>