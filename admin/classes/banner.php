<?php

/**
 * Clase de tipo BANNER
 * @author Wxp
 *
 */
class banner {
	private $id;
	private $idEmpresa;
	private $imagen;
	private $url;
	private $nombre;
	private $descripcion;
	private $activo;
	private $estado;
	private $fechaAlta;
	
	/* recibimos un array de una consulta de BD para construir el banner*/
	public function  __construct($arrBanner){
		
		$this->id			= $arrBanner[0];
		$this->idEmpresa 	= $arrBanner[1];
		$this->imagen 		= $arrBanner[2];
		$this->url 			= $arrBanner[3];
		$this->nombre 		= $arrBanner[4];
		$this->descripcion 	= $arrBanner[5];
		$this->activo 		= $arrBanner[6];
		$this->estado 		= $arrBanner[7];
		$this->fechaAlta 	= $arrBanner[8];
		
	}
	
	
	// GETTERS
	public function getId(){
		return $this->id;
	}
	public function getIdEmpresa(){
		return $this->idEmpresa;
	}
	public function getImagen (){
		return $this->imagen;
	}
	public function getUrl (){
		return $this->url;
	}
	public function getNombre (){
		return $this->nombre;
	}
	public function getDescripcion (){
		return $this->descripcion;
	}
	public function getActivo (){
		return $this->activo;
	}
	public function getEstado (){
		return $this->estado;
	}
	public function getFechaAlta (){
		return $this->fechaAlta;
	}
	
	// SETTERS
	public function setId( $id ){
		$this->id = $id;
	}
	public function setIdEmpresa( $idEmpresa ){
		return $this->idEmpresa = $idEmpresa;
	}
	public function setImagen ( $imagen ){
		return $this->imagen = $imagen;
	}
	public function setUrl ( $url ){
		return $this->$url = $url;
	}
	public function setNombre ( $nombre ){
		return $this->nombre = $nombre;
	}
	public function setDescripcion ( $descripcion ){
		return $this->descripcion = $descripcion;
	}
	public function setActivo ( $activo ){
		return $this->activo = $activo;
	}
	public function setEstado ( $estado ){
		return $this->estado = $estado;
	}
	public function setFechaAlta ( $fechaAlta ){
		return $this->fechaAlta = $fechaAlta;
	}
}

?>