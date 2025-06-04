<?php
class Conectar
{
    private $conexion;
    function __construct($servidor, $usuario, $contraseña, $bbdd)
    {
        $this->conexion = new mysqli($servidor, $usuario, $contraseña, $bbdd);
    }

    /* function hacer_consulta($tipo_consulta, $tabla, $valores, $opciones){
        $consulta = "$tipo_consulta $tabla $valores $opciones"; 
    }   */
    function hacer_consulta($consulta, $tipos, $variables){
        $sentencia = $this->conexion->prepare($consulta);
        $array_completo = array_merge([$tipos],$variables);
        $referencia = [];
        foreach($array_completo as $clave => $valor){
            $referencia[$clave] = &$array_completo[$clave];
        }
        call_user_func_array([$sentencia, 'bind_param'],$referencia);
        //$sentencia->bind_param($tipos, $variables);
        $sentencia->execute();
        return $this->conexion->insert_id;
    }
    public function hacer_consulta_resultado($consulta, $tipos, $variables) {
    $stmt = $this->conexion->prepare($consulta);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $this->conexion->error);
    }

    $array_completo = array_merge([$tipos], $variables);
    $referencia = [];

    foreach ($array_completo as $clave => $valor) {
        $referencia[$clave] = &$array_completo[$clave];
    }

    call_user_func_array([$stmt, 'bind_param'], $referencia);
    $stmt->execute();

    $resultado = $stmt->get_result();
    if (!$resultado) {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }

    $filas = [];
    while ($fila = $resultado->fetch_assoc()) {
        $filas[] = $fila;
    }

    return $filas;
}


    function recibir_datos($consulta){
    $sentencia = $this->conexion->query($consulta);

    if ($sentencia === false) {
        die("Error en la consulta: " . $this->conexion->error . "<br>Consulta: " . $consulta);
    }

    $filas = [];
    while($row = $sentencia->fetch_assoc()){
        $filas[] = $row;
    }
    return $filas;
}

    function ultimo_id() {
        return $this->conexion->insert_id;
    }
}