<?php

?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Ejemplo de estilos CSS en un archivo externo</title>
        <link rel="stylesheet" type="text/css" href="estilo.css" media="screen" />
        <meta charset="ISO-8859-1"
              <title></title>
    </head>
    <body>
        <fieldset style="width:70%">
            <legend>Admnistración de la tabla  CHARACTER_SETS</legend>
            <table id="tabla" class="display" border="1">
                <thead>
                    <tr>
                        <th>CHARACTER_SET_NAME</th><th>DEFAULT_COLLATE_NAME</th><th>DESCRIPTION</th><th>MAXLEN</th><th>Acciones</th>                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                <form action='gestionarTabla.php'  method='post'>

                    <input type =hidden value =CHARACTER_SETS  name = 'tabla'> 
                    <td>big5</td>
                    <input type =hidden name = campos[CHARACTER_SET_NAME] value ='big5' >
                    <td>big5_chinese_ci</td>
                    <input type =hidden name = campos[DEFAULT_COLLATE_NAME] value ='big5_chinese_ci' >
                    <td>Big5 Traditional Chinese</td>
                    <input type =hidden name = campos[DESCRIPTION] value ='Big5 Traditional Chinese' >
                    <td>2</td>
                    <input type =hidden name = campos[MAXLEN] value ='2' >
                    <td><input id=tabla type="submit" value="Edit" name="gestionar"></td>
                    <td><input id=tabla type="submit" value="Del" name="gestionar"></td>
                </form>
                </tr>
                <tr>
                <form action='gestionarTabla.php'  method='post'>

                    <input type =hidden value =CHARACTER_SETS  name = 'tabla'> 
                    <td>dec8</td>
                    <input type =hidden name = campos[CHARACTER_SET_NAME] value ='dec8' >
                    <td>dec8_swedish_ci</td>
                    <input type =hidden name = campos[DEFAULT_COLLATE_NAME] value ='dec8_swedish_ci' >
                    <td>DEC West European</td>
                    <input type =hidden name = campos[DESCRIPTION] value ='DEC West European' >
                    <td>1</td>
                    <input type =hidden name = campos[MAXLEN] value ='1' >
                    <td><input id=tabla type="submit" value="Edit" name="gestionar"></td>
                    <td><input id=tabla type="submit" value="Del" name="gestionar"></td>
                </form>
                </tr>
                <tr>
            </table>
            <form action='gestionarTabla.php' method='post'>
                <input type="submit" value="Add" name="gestionar">
                <input type="submit" value="Close" name="gestionar">
                <input type="hidden" value='CHARACTER_SETS' name="tabla">
            </form>
        </fieldset>
    </body>
</html>




