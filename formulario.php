<?php
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});

session_start();

$host = $_SESSION['conexion'][0];
$user = $_SESSION['conexion'][1];
$pass = $_SESSION['conexion'][2];
$bd = $_SESSION['conexion'][3];
$conexion = new BD($host, $user, $pass, $bd);

$nomTabla = $_POST['tabla'];
$campos = $_POST['campos'];
$formulario = "";
foreach ($campos as $titulo => $campo) {
    $formulario .= "<label>$titulo</label>" .
            "<input type = 'text' name = 'valorNuevo[]' value = '$campo'/><br />" .
            "<input type = 'hidden'  name = 'campos[]' value ='$titulo' />" .
            "<input type = hidden name = valorAnt[] value= '$campo' />";
}

if(isset($_POST['enviar'])){
    switch($_POST['enviar']){
        case 'Guardar':
            $valorNuevo = $_POST['valorNuevo'];
            $valorAnt = $_POST['valorAnt'];
            generaSentenciaUpdate($nomTabla, $campos, $valorAnt, $valorNuevo);
            break;
        case 'Cancelar':
            break;
    }
}
function generaSentenciaUpdate($nomTabla, $campos, $valorAnt, $valorNuevo) {
    $indice = 0;
    foreach ($campos as $titulo => $campo) {
        $set .= "$titulo = '" . $valorNuevo[$indice] . "', ";
        $where .= "$titulo = '" . $valorAnt[$indice] . "' and ";
        $indice++;
    }
    $set = substr($set, 0, strlen($set) - 2);
    $where = substr($where, 0, strlen($where) - 5);
    $sentencia = "UPDATE $nomTabla SET $set WHERE $where";
    $resultado = $conexion->ejecutar($sentencia);
    
}
?>
<html>
    <head>
        <title>Fomulario de edición</title>
        <link rel="stylesheet" type="text/css" href="estilos.css" media="screen" />
        <meta charset="UTF-8">
    </head>
    <body>
        <fieldset>
            <legend>Editanto Registro de la tabla <?php echo $nomTabla; ?> </legend>
            <form action="." method="post">
                <?php
                echo $formulario;
                
                ?>
                <input type="submit" value="Guardar" name='enviar'>
                <input type="submit" value="Cancelar" name='enviar'>
            </form>
        </fieldset>
    </body>
</html>

