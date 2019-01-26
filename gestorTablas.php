<?php
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});

session_start();

if (isset($_POST['submit'])) {
    $host = $_SESSION['conexion'][0];
    $user = $_SESSION['conexion'][1];
    $pass = $_SESSION['conexion'][2];
    $bd = $_SESSION['conexion'][3];
    $conexion = new BD($host, $user, $pass, $bd);

    $nomTabla = $_POST['submit'];
    $consulta = "Select * from $nomTabla";

    $titulos = $conexion->nomCol($nomTabla);
    $filas = $conexion->seleccion($consulta);
    $tabla = generoTabla($titulos, $datos);
    switch ($submit) {
        case "Delete":
            break;
        case "Modificar":
            header("Location: editar.php");
            break;
        case "Editar":
            header("Location: editar.php");
            break;
    }
}

function generoTabla($titulos, $filas, $nomTabla): string {
    $tabla = "<table id='tabla' class='display' border='1'>"
            . "<tr>";
    foreach ($titulos as $titulo) {
        $tabla .= "<th>$titulo</th>";
    }
    $tabla .= "</tr>";
    foreach ($filas as $fila) {
        $tabla .= "<tr>"
                . "<form action='gestionarTabla.php'  method='post'>"
                . "<input type='hidden' value='$nomTabla' name='tabla'>";
        foreach ($fila as $i => $dato) {
            $tabla .= "<td>$dato</td>"
                    . "<input type='hidden' name='campos[$titulos[$i]]' value='$dato'>";
        }
        $tabla .= "<td>"
                . "<input type = 'submit' value = 'Editar' name = 'submit'>"
                . "<input type = 'submit' value = 'Delete' name = 'submit'>"
                . "</td>"
                . "</form>"
                . "</tr>";
    }
    $tabla .= "</table>";
    return $tabla;
}
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Gestor de las tablas</title>
        <link rel="stylesheet" type="text/css" href="estilo.css" media="screen" />
    </head>
    <body>
        <fieldset style="width:70%">
            <legend>Admnistración de la tabla  <?php echo $nomTabla; ?></legend>
            <?php echo $tabla; ?>
            <form action='gestionarTabla.php' method='post'>
                <input type="submit" value="Add" name="gestionar">
                <input type="submit" value="Close" name="gestionar">
                <input type="hidden" value='<?php echo $nomTabla;?>' name="tabla">
            </form>
        </fieldset>
    </body>
</html>




