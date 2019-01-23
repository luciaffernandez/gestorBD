
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;
              charset = UTF-8" />
        <title>Ejemplo de estilos CSS en un archivo externo</title>
        <link rel="stylesheet" type="text/css" href="estilo.css" media="screen" />
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <fieldset>
            <legend>Editanto Registro de la tabla CHARACTER_SETS</legend>
            <form action="" method="post">
                <label for = CHARACTER_SET_NAME>CHARACTER_SET_NAME</label>
                <input type = text name = valorNuevo[] value = 'big5'  /><br />
                <input type = hidden  name = campos[] value =  'CHARACTER_SET_NAME' />
                <input type = hidden name = valorAnt[] value= 'big5' />
                <input type="submit" value="Guardar" name='enviar'>
                <input type="submit" value="Cancelar" name='enviar'>
            </form>
        </fieldset>
    </body>
</html>

