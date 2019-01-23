<?php

class BD {

    private $conexion;
    private $info;
    private $host;
    private $user;
    private $pass;
    private $bd;

    /**
     * RECOGE LAS VARIABLES NECESARIAS PARA CREAR LA CONEXION A LA BASE DE DATOS
     * @param type $host
     * @param type $user
     * @param type $pass
     * @param type $bd
     * Por último se llama a otra función que nos conectara con la base de datos
     */
    public function __construct($host = "localhost", $user = "root", $pass = "root", $bd = "dwes") {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->bd = $bd;
        $this->conexion = $this->conectar();
    }

    /**
     * @return \mysqli devuelve la conexion que es de tipo mysqli
     */
    private function conectar(): mysqli {
        $conexion = new mysqli($this->host, $this->user, $this->pass, $this->bd);
        if ($conexion->connect_errno) {
            $this->info = "Error conectando...<strong>" . $conexion->connect_error . "</strong>";
        }
        return $conexion;
    }

    /*
     * @param string $consulta que tendrá una sentencia mysql
     * @return type array que recogera todas las filas que hemos seleccionado de la base de datos
     */

    public function select(string $consulta): array {
        $filas = [];
        if ($this->conexion == null) {
            $this->conexion = $this->conexion();
        }
        $resultado = $this->conexion->query($consulta);
        while ($fila = $resultado->fetch_row()) {//mientras fila sea distinto de null cogemos el siguiente valor
            $filas[] = $fila;
        }
        return $filas;
    }

    //cierra la conexion a la base de datos
    public function cerrar() {
        $this->conexion->close();
    }

    /**
     * @param string $tabla es el nombre de la tabla cuyos nombres de los campos que quiero
     * @return array indexado con los nombres de los campos
     */
    public function nomCol(string $tabla): array {
        $campos = [];
        $consulta = "select * from $tabla";
        $r = $this->conexion->query($consulta);
        $camposObj = $r->fetch_fields();
        foreach ($camposObj as $campo) {
            $campos[] = $campo->name;
        }
        return $campos;
    }

}
