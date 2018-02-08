<?php

namespace Entity;

class Concert
{

    private $dbh;
    
    private $id;
    private $title;
    private $description;
    private $image;
    private $time;
    private $date;
    private $publish;
    private $prices;
    private $booked; // массив занятых мест
    
    private $tmpFile; // для загруженного, но еще не сохраненного файла, используем "UploadedFile" object
    
    function __construct($dbh, $arr)
    {
        $this->dbh = $dbh;
        if (isset($arr['id'])) $this->id = $arr['id'];
        if (isset($arr['title'])) $this->title = $arr['title'];
        if (isset($arr['description'])) $this->description = $arr['description'];
        if (isset($arr['image'])) $this->image = $arr['image'];
        if (isset($arr['time_start'])) $this->time = $arr['time_start'];
        if (isset($arr['concert_date'])) $this->date = $arr['concert_date'];
        if (isset($arr['publish'])) {
            if ($arr['publish']) $this->publish = '1'; else $this->publish = '0';
        }
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function getTime()
    {
        return $this->time;
    }
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function getImage()
    {
        return $this->image;
    }
    
    public function getPublish()
    {
        return $this->publish;
    }
    
    public function addPrice($price_type, $val, $free_seats)
    {
        $price = array(    'type'=>$price_type,
                'price'=>$val,
                'free_seats'=>$free_seats);
        $this->prices[ceil($val)] = $price;
    }
    
    public function isFreeSeats()
    {
        foreach ($this->prices as $price) {
            if ($price['free_seats'] > 0) {
                return true;
            }
        }
        return false;
    }
    
    public function getPrices($all=false)
    {
       
    	if (!is_array($this->prices)) {
            \Model\Concert::getPrices($this);
        }
        ksort($this->prices);
        if ($all) {
            return $this->prices;
        }
        $res = array();
        foreach ($this->prices as $price) {
            if ($price['free_seats'] > 0) {
                $res[] = $price;
            }
        }
        
        return $res;
    }
    
    public function getOccupiedSeats($id) {
    	if (!is_array($this->booked)) {
    		$this->booked = \Model\Concert::getOccupiedSeats($id,$this->dbh);
    	}
    	
    	return $this->booked;
    }
}