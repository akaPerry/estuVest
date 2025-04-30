<?php
class UsuarioReg{
    private string $nick;
    private string $contrasenia;
    private string $email;
    private string $nombre;
    private string $apellidos;
    private string $ciudad;
    private string $estudios;

    public function __construct(string $nick, string $contrasenia, string $email, string $nombre, string $apellidos, string $ciudad, string $estudios){
        $this->nick=$nick;
        $this->contrasenia=$contrasenia;
        $this->email=$email;
        $this->nombre=$nombre;
        $this->apellidos=$apellidos;
        $this->ciudad=$ciudad;
        $this->estudios=$estudios;
    }
    public function getNick(){
        return $this->nick;
    }
    public function getContrasenia(){
        return $this->contrasenia;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getApellidos(){
        return $this->apellidos;
    }
    public function getCiudad(){
        return $this->ciudad;
    }
    public function getEstudios(){
        return $this->estudios;
    }
    
}