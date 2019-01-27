<?php

class BD {

    private $conexion;
    private $info;
    private $user;
    private $pass;
    private $dns;

    /**
     * RECOGE LAS VARIABLES NECESARIAS PARA CREAR LA CONEXION A LA BASE DE DATOS
     * @param type $host
     * @param type $user
     * @param type $pass
     * @param type $bd
     * Por último se llama a otra función que nos conectara con la base de datos
     */
    public function __construct($host = "localhost", $user = "root", $pass = "root", $bd = null) {
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
        } catch (Exception $e) {
            $this->info = "Error conectando: " . $e->getMessage() . "<br/><strong>Prueba con el host 172.17.0.2 el usuario root y la contraseña root</strong>";
        }
        $conexion->query("SET NAMES 'utf8'");
        return $conexion;
    }

    /**
     * @param string $consulta
     * @return type
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

        $camposObj = $resultado->fetch(PDO::FETCH_ASSOC);
        while ($filas = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $campos[] = $filas;
        }
        return $campos;
    }

    /**
     * @param string $tabla es el nombre de la tabla cuyos nombres de los campos que quiero
     * @return array indexado con los nombres de los campos
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

}
