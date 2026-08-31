<?php

/**
 * Clase de tipo EMPRESA
 * @author Wxp
 *
 */
class empresa {
	private $id;
	private $empresa;
	private $calle;
	private $numero;
	private $codigo_postal;
	private $activo;
	private $telefono;
	private $web;
	private $email;
	private $fecha_alta;
	private $aud_fecha;
	private $aud_usuario;
	
	/* recibimos un array de una consulta de BD para construir el banner*/
	public function  __construct($arrBanner){
		
		$this->id				= $arrBanner[0];
		$this->empresa 			= $arrBanner[1];
		$this->calle 			= $arrBanner[2];
		$this->numero 			= $arrBanner[3];
		$this->codigo_postal 	= $arrBanner[4];
		$this->telefono 		= $arrBanner[5];
		$this->email			= $arrBanner[6];
		$this->web  			= $arrBanner[7];
		$this->fecha_alta		= $arrBanner[8];
		$this->aud_fecha		= $arrBanner[9];
		$this->aud_usuario		= $arrBanner[10];
		$this->activo 			= $arrBanner[11];
		
		
	}
	
	
	// GETTERS
	public function getId(){
		return $this->id;
	}
	public function getCalle (){
		return $this->calle;
	}
	public function getNumero (){
		return $this->numero;
	}
	public function getEmpresa (){
		return $this->empresa;
	}
	public function getCodigo_postal (){
		return $this->codigo_postal;
	}
	public function getActivo (){
		return $this->activo;
	}
	public function getTelefono (){
		return $this->telefono;
	}
	public function getWeb (){
		return $this->web;
	}
	public function getEmail (){
		return $this->email;
	}
	public function getFecha_Alta (){
		return $this->fecha_alta;
	}
	public function getAud_Fecha (){
		return $this->aud_fecha;
	}
	public function getAud_Usuario (){
		return $this->aud_usuario;
	}
	
	// SETTERS
	public function setId( $id ){
		$this->id = $id;
	}
	public function setCalle ( $calle ){
		return $this->calle = $calle;
	}
	public function setNumero ( $numero ){
		return $this->$numero = $numero;
	}
	public function setEmpresa ( $empresa ){
		return $this->empresa = $empresa;
	}
	public function setCodigo_postal ( $codigo_postal ){
		return $this->codigo_postal = $codigo_postal;
	}
	public function setActivo ( $activo ){
		return $this->activo = $activo;
	}
	public function setTelefono ( $telefono ){
		return $this->telefono = $telefono;
	}
	public function setWeb ( $web ){
		return $this->web = $web;
	}
	public function setEmail (){
		return $this->email = $email;
	}
	public function setFecha_Alta (){
		return $this->fecha_alta = $fecha_alta;
	}
	public function setAud_Fecha (){
		return $this->aud_fecha = $aud_fecha;
	}
	public function setAud_Usuario (){
		return $this->aud_usuario = $aud_usuario;
	}
}

?>