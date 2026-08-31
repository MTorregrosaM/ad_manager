<?php

/**
 * Clase de tipo USUARIO
 * @author Wxp
 *
 */
class usuario {
	private $id;
	private $empresaID;
	private $username;
	private $password;
	private $nombre;
	private $apellidos;
	private $telefono;
	private $email;
	private $fecha_alta;
	private $fecha_ult_acceso;
	private $activada;
	
	/* recibimos un array de una consulta de BD para construir el banner*/
	public function  __construct($arrBanner){
		
		$this->id				= $arrBanner[0];
		$this->empresaID 		= $arrBanner[1];
		$this->username 		= $arrBanner[2];
		$this->password 		= $arrBanner[3];
		$this->nombre  			= $arrBanner[4];
		$this->apellidos 		= $arrBanner[5];
		$this->telefono 		= $arrBanner[6];
		$this->email			= $arrBanner[7];
		$this->fecha_alta		= $arrBanner[8];
		$this->fecha_ult_acceso	= $arrBanner[9];
		$this->activada			= $arrBanner[10];
		
		
	}
	
	
	// GETTERS
	public function getId(){
		return $this->id;
	}
	public function getUsername (){
		return $this->username;
	}
	public function getPassword (){
		return $this->password;
	}
	public function getEmpresaID (){
		return $this->empresaID;
	}
	public function getApellidos (){
		return $this->apellidos;
	}
	public function getActivada(){
		return $this->activada;
	}
	public function getTelefono (){
		return $this->telefono;
	}
	public function getNombre (){
		return $this->nombre;
	}
	public function getEmail (){
		return $this->email;
	}
	public function getFecha_Alta (){
		return $this->fecha_alta;
	}
	public function getAud_Fecha (){
		return $this->fecha_ult_acceso;
	}
	public function getAud_Usuario (){
		return $this->aud_usuario;
	}
	
	// SETTERS
	public function setId( $id ){
		$this->id = $id;
	}
	public function setUsername ( $username ){
		return $this->username = $username;
	}
	public function setPassword ( $password ){
		return $this->$password = $password;
	}
	public function setEmpresaID ( $empresaID ){
		return $this->empresaID = $empresaID;
	}
	public function setApellidos ( $apellidos ){
		return $this->apellidos = $apellidos;
	}
	public function setActivada( $activada){
		return $this->activada= $activada;
	}
	public function setTelefono ( $telefono ){
		return $this->telefono = $telefono;
	}
	public function setNombre ( $nombre ){
		return $this->nombre = $nombre;
	}
	public function setEmail (){
		return $this->email = $email;
	}
	public function setFecha_Alta (){
		return $this->fecha_alta = $fecha_alta;
	}
	public function setAud_Fecha (){
		return $this->fecha_ult_acceso = $fecha_ult_acceso;
	}
	public function setAud_Usuario (){
		return $this->aud_usuario = $aud_usuario;
	}
}

?>