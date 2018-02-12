<?php
namespace Model
{
    class Concert extends BaseModel
    {
        
        private $title;
        /**
         * возвращает массив опубликованных концертов, которые пройдут после текущей даты
         */
        
        public function getFutureConcerts()
        {
            $sql = "SELECT c.*, (100-count(rs.id)) as free_seats, p.price_type, p.price 
                    FROM concert as c 
                    INNER JOIN price as p ON p.concert_id = c.id 
                    LEFT JOIN `order` as r ON (r.concert_id = c.id and r.is_active='1') 
                    LEFT JOIN order_seats as rs ON (rs.order_id = r.id and rs.price_type=p.price_type) 
                    WHERE c.concert_date >= CURDATE() AND c.publish = '1' 
                    GROUP BY c.id, p.price_type, p.price 
                    ORDER BY c.concert_date ASC";
            
            $sth = $this->db->prepare($sql);
            $sth->execute(array());
            $concerts = array();
            $oldId = 0;
            
            while ($row = $sth->fetch()) {
                if ($oldId!=$row['id']) {
                    
                    $oldId=$row['id'];
                    $concert = new \Entity\Concert($this->db, $row);
                    $concert->addPrice($row['price_type'], $row['price'], $row['free_seats']);
                    $concerts[] = $concert;
                } else {
                    $concert->addPrice($row['price_type'], $row['price'], $row['free_seats']);
                }
            }
            
            return $concerts;
            
        }
        
        public function openById($id) 
        {
        	$sql = "SELECT id, title, description, image, concert_date, time_start, publish
                FROM concert
                WHERE id = ?";
        	$sth = $this->db->prepare($sql);
        	$sth->execute(array($id));
        	if ($row = $sth->fetch()) {
        		return new \Entity\Concert($this->db, $row);
        	}
        	return null;
        	
        }
        
        /**
         * возвращает массив занятых мест
         * первый индекс # ряда, второй индекс # места
         */
        public static function getOccupiedSeats($id,$dbh)
        {
        	$Seats = array();
        	$sql = "SELECT rs.row, rs.seat
                FROM `order` as r
                INNER JOIN order_seats as rs ON rs.order_id = r.id
                WHERE r.concert_id = ? AND r.is_active='1'";
        	$sth = $dbh->prepare($sql);
        	$sth->execute(array($id));
        	while ($row = $sth->fetch()) {
        		$Seats[$row['row']][$row['seat']] = 1;
        	}
        	
        	return $Seats;
        }
        
        public function getPrices($concert)
        {
        	$prices = array();
        	$sql = "SELECT (100-count(rs.id)) as free_seats, p.price_type, p.price
                FROM price as p
                LEFT JOIN `order` as r ON (r.concert_id = p.concert_id and r.is_active='1')
                LEFT JOIN order_seats as rs ON (rs.order_id = r.id and rs.price_type=p.price_type)
                WHERE p.concert_id = ?
                GROUP BY p.price_type, p.price";
        	$sth = $this->db->prepare($sql);
        	$sth->execute(array($concert->getId()));
        	while ($row = $sth->fetch()) {
        		$concert->addPrice($row['price_type'], $row['price'], $row['free_seats']);
        	}
        	
        }
        
        
        public function priceByRow($arPrice,$row) 
        {
        	$type = 1+floor( ($row-1)/5);
        	foreach($arPrice as $price) {
        		if ($price['type'] == $type) {
        			return $price;
        		}
        	}
        }  
        
        
        public static function save($concert, $dbh)
        {
        	if (!$concert->getId()) {
        		// сохраняем новый объект
        		return self::saveNewConcert($concert, $dbh);
        	} else {
        		// обновляем существующего
        		return self::updateConcert($concert, $dbh);
        	}
        }
        
       
        private static function saveNewConcert($concert, $dbh)
        {
        	$sql = 'INSERT INTO concert(id, title, description, concert_date, time_start, publish)
                VALUES (?,?,?,?,?,?)';
        	$sth = $dbh->prepare($sql);
        	$sth->execute(array( $concert->getId(),
        			$concert->getTitle(),
        			$concert->getDescription(),
        			$concert->getDate(),
        			$concert->getTime(),
        			$concert->getPublish(),
        	));
        	$id = $dbh->lastInsertId(); // ID нового объекта
        	
        	if ($id) {
	        	// сохраняем картинку
	        	if ($concert->getTmpFile()){
	        		$imgfile = $id.'.'.$concert->getTmpFile()->getClientOriginalExtension();
	        		$sql = 'UPDATE concert SET image=? WHERE id=?';
	        		$sth = $dbh->prepare($sql);
	        		$sth->execute(array($imgfile, $id));
	        		$concert->getTmpFile()->move(__DIR__.'/../../www/images',$imgfile);
	        	}
        	
        		$prices = $concert->getPrices(true);
        		
        		// сохраняем цены
        		foreach ($prices as $price) {
        			$sql = 'INSERT INTO price (price_type, concert_id, price)
        	       VALUES(?,?,?)';
        			$sth = $dbh->prepare($sql);
        			$sth->execute(array($price['type'], $id, $price['price']));
        		}
        	}
        	
        	return $id;
        }
        
    }
    
}


?>