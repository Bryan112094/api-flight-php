<?php
require 'vendor/autoload.php';
Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=bryan_api','root',''));

//Con el método GET - Listamos todos los datos de la tabla
Flight::route('GET /alumnos', function(){
    
    $sentencia = Flight::db()->prepare("SELECT * FROM alumnos");
    $sentencia->execute();
    $datos = $sentencia->fetchAll();
    Flight::json($datos);

});

//Con el método POST - Agregador datos a la tabla
Flight::route('POST /alumnos', function(){
    
    $nombre = Flight::request()->data->nombre;
    $apellido = Flight::request()->data->apellido;
    $sql = "INSERT INTO alumnos (nombre, apellido) VALUES (?, ?)";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $nombre);
    $sentencia->bindParam(2, $apellido);
    $sentencia->execute();
    Flight::jsonp(["Alumno agregado"]);

});

//Con el método DELETE - Eliminamos datos a la tabla
Flight::route('DELETE /alumnos', function(){
    
    $id = Flight::request()->data->id;
    $sql = "DELETE FROM alumnos WHERE id = ?";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $id);
    $sentencia->execute();
    Flight::jsonp(["Alumno eliminado"]);

});

//Con el método PUT - Eliminamos datos a la tabla
Flight::route('PUT /alumnos', function(){
    
    $id = Flight::request()->data->id;
    $nombre = Flight::request()->data->nombre;
    $apellido = Flight::request()->data->apellido;
    $sql = "UPDATE alumnos SET nombre = ?, apellido = ? WHERE id =?";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $nombre);
    $sentencia->bindParam(2, $apellido);
    $sentencia->bindParam(3, $id);
    $sentencia->execute();
    Flight::jsonp(["Alumno modificado"]);

});

//Lectura de un registro determinado
Flight::route('GET /alumnos/@id', function($id){
    
    $sentencia = Flight::db()->prepare("SELECT * FROM alumnos WHERE id = ?");
    $sentencia->bindParam(1, $id);
    $sentencia->execute();
    $datos = $sentencia->fetchAll();
    Flight::json($datos);

});

Flight::start();
?>