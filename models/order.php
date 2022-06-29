<?php

class Order{
	private $id;
	private $id_user;
	private $province;
	private $location;
	private $address;
	private $price;
	private $state;
	private $date;
	private $hour;

	private $db;
	
	public function __construct() {
		$this->db = Database::connect();
	}
	
	function getId() {
		return $this->id;
	}

	function getId_user() {
		return $this->id_user;
	}

	function getProvince() {
		return $this->province;
	}

	function getLocation() {
		return $this->location;
	}

	function getAddress() {
		return $this->address;
	}

	function getPrice() {
		return $this->price;
	}

	function getState() {
		return $this->state;
	}

	function getDate() {
		return $this->date;
	}

	function getHour() {
		return $this->hour;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setId_user($id_user) {
		$this->id_user = $id_user;
	}

	function setProvincia($province) {
		$this->province = $this->db->real_escape_string($province);
	}

	function setLocation($location) {
		$this->location = $this->db->real_escape_string($location);
	}

	function setAddress($address){
		$this->address = $this->db->real_escape_string($address);
	}

	function setPrice($price){
		$this->price = $price;
	}

	function setState($state) {
		$this->state = $state;
	}

	function setDate($date) {
		$this->date = $date;
	}

	function setHour($hour) {
		$this->hour = $hour;
	}

	public function getAll(){
		$products = $this->db->query("SELECT * FROM orders ORDER BY id DESC");
		return $products;
	}
	
	public function getOne(){
		$product = $this->db->query("SELECT * FROM pedidos WHERE id = {$this->getId()}");
		return $product->fetch_object();
	}
	
	public function getOneByUser(){
		$sql = "SELECT p.id, p.coste FROM pedidos p "
				//. "INNER JOIN lineas_pedidos lp ON lp.pedido_id = p.id "
				. "WHERE p.usuario_id = {$this->getId_user()} ORDER BY id DESC LIMIT 1";
			
		$order = $this->db->query($sql);
			
		return $order->fetch_object();
	}
	
	public function getAllByUser(){
		$sql = "SELECT p.* FROM pedidos p "
				. "WHERE p.usuario_id = {$this->getId_user()} ORDER BY id DESC";
			
		$order = $this->db->query($sql);
			
		return $order;
	}
	
	
	public function getProductosByPedido($id){
//		$sql = "SELECT * FROM productos WHERE id IN "
//				. "(SELECT producto_id FROM lineas_pedidos WHERE pedido_id={$id})";
	
		$sql = "SELECT pr.*, lp.unidades FROM products pr "
				. "INNER JOIN order_lines ol ON pr.id = ol.id_product "
				. "WHERE lp.id_order={$id}";
				
		$products = $this->db->query($sql);
			
		return $products;
	}
	
	public function save(){
		$sql = "INSERT INTO orders VALUES(NULL, {$this->getId_user()}, '{$this->getProvince()}', '{$this->getLocation()}', '{$this->getAddress()}', {$this->getPrice()}, 'confirm', CURDATE(), CURTIME());";
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
	public function save_line(){
		$sql = "SELECT LAST_INSERT_ID() as 'order';";
		$query = $this->db->query($sql);
		$id_order = $query->fetch_object()->order;
		
		foreach($_SESSION['carrito'] as $elemento){
			$producto = $elemento['producto'];
			
			$insert = "INSERT INTO lineas_pedidos VALUES(NULL, {$pedido_id}, {$producto->id}, {$elemento['unidades']})";
			$save = $this->db->query($insert);
			
//			var_dump($producto);
//			var_dump($insert);
//			echo $this->db->error;
//			die();
		}
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
	public function edit(){
		$sql = "UPDATE pedidos SET estado='{$this->getEstado()}' ";
		$sql .= " WHERE id={$this->getId()};";
		
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
}