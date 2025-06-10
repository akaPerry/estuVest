<?php
class BaseDatos {
    private $user = "root";
    private $psd = "";
    private $bd = "estuvest2";
    public $conn;

    function __construct()
    {
        try {
            $this->conn = new PDO("mysql:lst=localhost;dbname=$this->bd", $this->user, $this->psd);

        } catch (PDOException $e) {
            echo ("Error: " . $e->getMessage());
        }
    }
    //devuelve un array con todos los elementos de una tabla
    public function sacarTabla(string $tabla)
    {
        $stmt = $this->conn->prepare("SELECT * from $tabla ;");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function cerrarBD()
    {
        try {
            $this->conn = null;
        } catch (PDOException $e) {
            echo ("" . $e->getMessage());
        }
    }

    //devuelve un true si encuentra un campo con un valor determinado en una tabla, si no, devuelve un false
    public function buscarEnTabla(string $tabla, string $campo, string $valor, bool $login = false)
    {
        session_start();
        $busca = $this->sacarTabla($tabla);
        foreach ($busca as $key => $value) {
            if ($value["$campo"] == $valor) {
                return true;
            }
        }
        return false;
    }
    //introduce un usuario registrado en la base de datos
    public function insertarUsuReg(string $nombre, string $apellidos, string $mail, string $usuario, string $contrasenia, string $ciudad, string $estudios)
    {
        $stmt = $this->conn->prepare("INSERT INTO usuario (`nick`,`contrasenia`,`nombre`,`apellidos`,`mail`) VALUES (:nick, :cont, :nombre, :apellidos, :mail);");
       
        $stmt -> bindParam(":nick",$usuario);
        $stmt -> bindParam(":cont", $contrasenia);
        $stmt -> bindParam(":nombre", $nombre);
        $stmt -> bindParam(":apellidos", $apellidos);
        $stmt -> bindParam(":mail", $mail);
        $stmt->execute();

        $id=$this->sacarUnValor("usuario","nick",$usuario,"id");
        $stmt = $this->conn->prepare("INSERT INTO usuario_registrado (`id`,`ciudad`,`estudios`,`fecha_alta`) VALUES (:id, :ciudad, :estudios, NOW());");
        $stmt -> bindParam(":id", $id);
        $stmt -> bindParam(":ciudad", $ciudad);
        $stmt -> bindParam(":estudios",$estudios);
        $stmt->execute();
        //aqui
        echo ("Usuario introducido exitosamente<br>");
    }
    public function getUsuReg(string $id){
        $stmt=$this->conn->prepare("SELECT * FROM usuario_registrado natural join usuario WHERE id=:id");
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //combrueba si el usuario introducido por teclado y la contraseña son correctos
    public function logearUsu(string $usuario, string $contrasenia)
    {
        $busca = $this->sacarTabla("usuario");
        foreach ($busca as $key => $value) {
            if ($value["nick"] == $usuario) {
                //desencripta la contraseña
                echo("Contraseña ingresada: $contrasenia");
                echo("Hash almacenado:". $value['contrasenia']);
                if (password_verify($contrasenia, $value["contrasenia"])) {
                    return true;
                } else {
                    echo ("Contraseña incorrecta.");
                    return false;
                }
            }
        } echo ("Usuario no encontrado");
            return false;
    }
    //saca un array de valores con un valor de un campo como condición
    public function sacarArrayValores(string $tabla, string $campoCondicion, string $valorCondicion, string $campoR){
        $lista= $this->sacarTabla($tabla);
        foreach ($lista as $key => $value) {
            if($value[$campoCondicion]==$valorCondicion){
                $resultado[]=$value[$campoR];
            }
        }
        return $resultado;
    }

//saca un solo valor, no array, con valor de un campo como condiciópn
    public function sacarUnValor(string $tabla, string $campoCondicion, string $valorCondicion, string $campoR){
        $lista= $this->sacarTabla($tabla);
        foreach ($lista as $key => $value) {
            if($value[$campoCondicion]==$valorCondicion){
                return $value[$campoR];
            }
        }
        return null;
    }
//saca tuplas completas en un array con un valor de un campo como condición
    public function sacarTuplas(string $tabla, string $campoCondicion, string $valorCondicion){
        $lista= $this->sacarTabla($tabla);
        $tuplas = [];
        foreach ($lista as $key => $value) {
            if($value[$campoCondicion]==$valorCondicion){
                //$tuplas = $value;
                array_push($tuplas, $value);
            }
    }
    return $tuplas;
}


}   
/* 

asociativo

array = [
    key => objeto arrya columnas
]

normal

variable [valor] = x 

*/
