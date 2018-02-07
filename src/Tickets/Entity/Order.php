<?php

namespace Entity;

class Order
{
	private $id;
	private $concert_id;
	private $email;
	private $created;
	private $is_active;
	private $is_paid;
	private $total;
	private $seats;     // массив мест
	private $concert;   // объект класса Concert
	
	
	function __construct($arr)
	{
		if (isset($arr['id'])) $this->id = $arr['id'];
		if (isset($arr['concert_id'])) $this->concert_id = $arr['concert_id'];
		if (isset($arr['email'])) $this->email = $arr['email'];
		if (isset($arr['created'])) $this->created = $arr['created'];
		if (isset($arr['is_active'])) {
			if ($arr['is_active']) $this->is_active = '1'; else $this->is_active = '0';
		}
		if (isset($arr['is_paid'])) {
			if ($arr['is_paid']) $this->is_paid = '1'; else $this->is_paid = '0';
		}
		if (isset($arr['total'])) $this->total = $arr['total'];
	}
	
	
	public static function openById($id, $dbh)
	{
		$order = Order\Model::openById($id, $dbh);
		
		return $order;
	}
	
	public function save($dbh)
	{
		return Order\Model::save($this, $dbh);
	}
}
