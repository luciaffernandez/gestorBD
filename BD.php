<?php

class BD {

    private $conexion;
    private $info;
    private $user;
    private $pass;
    private $dns;

    /** FUNCION QUE RECOGE LOS ATRIBUTOS NECESARIOS PARA CREAR LA CONEXION A LA BASE DE DATOS
     * @param type $host
     * @param type $user
     * @param type $pass
     * @param type $bd
     */
    public function __construct($host = "172.17.0.2", $user = "root", $pass = "root", $bd = null) {
        $this->user = $user;
        $this->pass = $pass;
        if ($bd === null) {
            $this->dns = "mysql:host=$host";
        } else {
            $this->dns = "mysql:host=$host;dbname=$bd";
        }
        $this->conexion = $this->conectar();
    }

    /**
     * @return \mysqli devuelve la conexion que es de tipo mysqli
     */
    private function conectar() {
        try {
            $conexion = new PDO($this->dns, $this->user, $this->pass);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (Exception $e) {
            $this->info = "Error conectando: " . $e->getMessage() . "<br/><strong>Prueba con el host 172.17.0.2 el usuario root y la contraseña root</strong>";
        }
        $conexion->query("SET NAMES 'utf8'");
        return $conexion;
    }

    /** Devolvera un array o un string depende de la consulta que se haga
     * @param string $consulta
     */
    public function consulta($consulta) {
        return $this->conexion->query($consulta);
    }

    /**
     * @return string que sera el codigo de info que se generara si no se puede conectar a la base de datos
     */
    function getInfo() {
        return $this->info;
    }

    //cierra la conexion a la base de datos
    public function cerrar() {
        $this->conexion = null;
    }

    /*
     * @param string $consulta que tendrá una sentencia mysql
     * @return type array que recogera todas las filas que hemos seleccionado de la base de datos
     */

    public function seleccion(string $consulta): array {
        $campos = [];
        if ($this->conexion == null) {
            $this->conexion = $this->conexion();
        }
        $resultado = $this->conexion->query($consulta);
        while ($filas = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $campos[] = $filas;
        }
        return $campos;
    }

    /**
     * @param string $nomTabla es el nombre de la tabla cuyos nombres de los campos que quiero
     * @return array con los nombres de las columnas de la tabla
     */
    public function nomCol($nomTabla): array {
        $campos = [];
        if ($this->conexion == null) {
            $this->conexion = $this->conexion();
        }
        $consulta = "select * from $nomTabla";
        $r = $this->conexion->query($consulta);
        $camposObj = $r->fetch(PDO::FETCH_ASSOC);
        foreach ($camposObj as $nomCol => $campo) {
            $campos[] = $nomCol;
        }
        return $campos;
    }

    public function ejecutar($sentencia) {
        $this->info = NULL;
        if ($this->conexion == NULL) {
            $this->__construct($conexion);
        }
        try {
            $stmt = $this->conexion->prepare($sentencia);
            $stmt->execute();
        } catch (PDOException $ex) {
            $this->info = "Error " . $ex->getMessage() . "<br/><hr /> Sentencia erronea.";
        }
    }

    /** Realiza la función de borrar del gestor de tabla
     * @param type $tabla
     * @param type $datos
     * @return array
     */
    public function delete($tabla, $datos): array {
        if ($this->con == null) {
            $this->con = $this->conexion();
        }
        $sentencia = "DELETE FROM $tabla WHERE ";
        foreach ($datos as $campo => $dato) {
            $columna = substr($campo, 1);
            $sentencia .= "$columna=$campo AND ";
        }

        $sql = substr($sentencia, 0, strlen($sentencia) - 4);
        return $this->prepareStmt($sql, $datos);
    }

    /*     * Realiza la sentencia preparada que le pases
     * @param string $sql
     * @param array $datos
     * @return bool
     */

    private function prepareStmt(string $sql, array $datos): bool {
        $stmt = $this->conexion->prepare($sql);
        $resultado = $stmt->execute($datos);
        return $resultado;
    }

}
