<?php

class Producto{
	private $id;
	private $id_category;
	private $name;
	private $description;
	private $price;
	private $stock;
	private $ofert;
	private $date;
	private $image;

	private $db;
	
	public function __construct() {
		$this->db = Database::connect();
	}
	
	function getId() {
		return $this->id;
	}

	function getId_category() {
		return $this->id_category;
	}

	function getName() {
		return $this->name;
	}

	function getDescription() {
		return $this->description;
	}

	function getPrice() {
		return $this->price;
	}

	function getStock() {
		return $this->stock;
	}

	function getOfert() {
		return $this->ofert;
	}

	function getDate() {
		return $this->date;
	}

	function getImage() {
		return $this->image;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setId_category($id_category) {
		$this->$id_category = $id_category;
	}

	function setName($name) {
		$this->name = $this->db->real_escape_string($name);
	}

	function setDescription($description) {
		$this->description = $this->db->real_escape_string($description);
	}

	function setPrice($price) {
		$this->price = $this->db->real_escape_string($price);
	}

	function setStock($stock) {
		$this->stock = $this->db->real_escape_string($stock);
	}

	function setOfert($ofert) {
		$this->ofert = $this->db->real_escape_string($ofert);
	}

	function setFecha($date) {
		$this->date = $date;
	}

	function setImagen($image) {
		$this->image = $image;
	}

	public function getAll(){
		$productos = $this->db->query("SELECT * FROM productos ORDER BY id DESC");
		return $productos;
	}
	
	public function getAllCategory(){
		$sql = "SELECT p.*, c.nombre AS 'catnombre' FROM productos p "
				. "INNER JOIN categorias c ON c.id = p.categoria_id "
				. "WHERE p.categoria_id = {$this->getId_category()} "
				. "ORDER BY id DESC";
		$products = $this->db->query($sql);
		return $products;
	}
	
	public function getRandom($limit){
		$productos = $this->db->query("SELECT * FROM productos ORDER BY RAND() LIMIT $limit");
		return $productos;
	}
	
	public function getOne(){
		$producto = $this->db->query("SELECT * FROM productos WHERE id = {$this->getId()}");
		return $producto->fetch_object();
	}
	
	public function save(){
		$sql = "INSERT INTO productos VALUES(NULL, {$this->getCategoria_id()}, '{$this->getNombre()}', '{$this->getDescripcion()}', {$this->getPrecio()}, {$this->getStock()}, null, CURDATE(), '{$this->getImagen()}');";
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
	public function edit(){
		$sql = "UPDATE productos SET nombre='{$this->getNombre()}', descripcion='{$this->getDescripcion()}', precio={$this->getPrecio()}, stock={$this->getStock()}, categoria_id={$this->getCategoria_id()}  ";
		
		if($this->getImagen() != null){
			$sql .= ", imagen='{$this->getImagen()}'";
		}
		
		$sql .= " WHERE id={$this->id};";
		
		
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
	public function delete(){
		$sql = "DELETE FROM productos WHERE id={$this->id}";
		$delete = $this->db->query($sql);
		
		$result = false;
		if($delete){
			$result = true;
		}
		return $result;
	}
	
}