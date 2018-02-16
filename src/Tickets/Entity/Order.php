<?php

namespace Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Range;

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
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
    	$metadata->addPropertyConstraint('seats', new NotBlank(array(
    			'groups' => array('save','seats'),
    			'message'=>'Необходимо выбрать хотя бы одно место'
    	))); 
    }
    
    public function openSeats($dbh)
    {
        if (!is_array($this->seats)) {
            $this->seats = \Model\Order::getSeats($this, $dbh);
        }
    }
    
    public function getSeats()
    {
        return $this->seats;
    }
    
    public function setSeats($seats)
    {
        $this->seats = array();
        if (!is_array($seats))
            return;
            foreach ($seats as $row => $val) {
                foreach ($val as $seat => $p) {
                    $this->seats[] = array('row'=>$row, 'seat'=>$seat);
                }
            }
    }
    
    public function getConcertId()
    {
        return $this->concert_id;
    }
    
    public function setConcert($val)
    {
        $this->concert = $val;
    }
    
    public function openConcert($dbh)
    {
        if (!($this->concert instanceof Concert)) {
            $obj = new \Model\Concert($dbh);
            $this->concert = $obj->openById($this->concert_id);
        }
    }
    
    public function getConcert()
    {
        return $this->concert;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function setEmail($val)
    {
        $this->email = $val;
    }
    
    public function getTotal()
    {
        return $this->total;
    }
    
    public function setTotal($val)
    {
        $this->total= $val;
    }
    
    public function getIsActive()
    {
        return $this->is_active;
    }
    
    public function getIsPaid()
    {
        return $this->is_paid;
    }
    
    public function setIsActive($val)
    {
        if ($val=='') $val = '0';
        else $val = '1';
        $this->is_active = $val;
    }
    
    public function setIsPaid($val)
    {
        if ($val=='') $val = '0';
        else $val = '1';
        $this->is_paid = $val;
    }
    
    public static function openById($id, $dbh)
    {
        $order = \Model\Order::openById($id, $dbh);
        $order->openConcert($dbh);
        $order->openSeats($dbh);
        
        return $order;
    }
    
    public function save($dbh)
    {
        return \Model\Order::save($this, $dbh);
    }
    
    
}
