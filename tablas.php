<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
        <title>Ejemplo de estilos CSS en un archivo externo</title>
        <link rel="stylesheet" type="text/css" href="estilo.css" media="screen" />
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <fieldset id="sup" style="width:25%">
            <legend>Listado bases de datos</legend>
            <form action="index.php" method='POST'>
                <input type="submit" value="Volver" name="volver">
            </form>
        </fieldset>

        <fieldset style="width:70%">
            <legend>Gestion de las Bases de Datos <span class="resaltar"></span></legend>
            <form action='gestionarTabla.php' method='post'>
                <input type=submit value=CHARACTER_SETS name=tabla>
                <input type=submit value=COLLATIONS name=tabla>
                <input type=submit value=COLLATION_CHARACTER_SET_APPLICABILITY name=tabla>
                <input type=submit value=COLUMNS name=tabla>
                <input type=submit value=COLUMN_PRIVILEGES name=tabla>
                <input type=submit value=ENGINES name=tabla>
                <input type=submit value=EVENTS name=tabla>
                <input type=submit value=FILES name=tabla>
                <input type=submit value=GLOBAL_STATUS name=tabla
                       <input type=submit value=GLOBAL_VARIABLES name=tabla>
                <input type=submit value=KEY_COLUMN_USAGE name=tabla>
                <input type=submit value=OPTIMIZER_TRACE name=tabla>
                <input type=submit value=PARAMETERS name=tabla>
                <input type=submit value=PARTITIONS name=tabla>
            </form>
        </fieldset>

    </body>
</html>
