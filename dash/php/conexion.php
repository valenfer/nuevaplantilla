<?php
require_once 'config.php';




/*function connectDB()
{
    try
    {
$opc=array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $dsn="mysql:host=localhost:3306;dbname=adminBD_promobrenescash";
        $usuario="adminBD_promobrenescash";
        $contrasena="adminBD_promobrenescash";
        $base=new PDO($dsn,$usuario,$contrasena,$opc);
    }
    catch (PDOException $e)
    {
        die ("Error".$e->getMessage());
        $resultado=null;
    }
    return $base;
}*/

function connectDB()
{
    try
    {
$opc=array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $dsn="mysql:host=localhost;dbname=plantilla";
        $usuario="root";
        $contrasena="";
        $base=new PDO($dsn,$usuario,$contrasena,$opc);
    }
    catch (PDOException $e)
    {
        die ("Error".$e->getMessage());
        $resultado=null;
    }
    return $base;
}

function ejecutaConsulta($sql)
{
		//recibe una cadena conteniendo una instruccion SELECT y devuelve un resultset

		$miconexion=connectDB();
		return $miconexion->query($sql);

}

function consulta($sql)
{

		//recibe una cadena conteniendo una instruccion SELECT y devuelve un array con la fila de datos
		$datos=[];
		$resultset=ejecutaConsulta($sql);
		while($fila=$resultset->fetch(PDO::FETCH_ASSOC))
		{
			$datos[]=$fila;
		}
		return $datos;


}


function insert($sql)
{
		/*recibe una cadena conteniendo una instruccion DML, la ejecuta y
		devuelve el nº de filas afectadas por dicha instruccion*/
		$miconexion=connectDB();
		$accion = $miconexion->prepare($sql);
		$accion->execute();
		return $accion->rowCount();
		//return "1";
}




function timeStamp($timestamp){
	$fechaHora = explode(" ", $timestamp);
	$dato = [];
	$dato["fecha"] = $fechaHora[0];
	$dato["hora"] = $fechaHora[1];
	return $dato;
}


?>
