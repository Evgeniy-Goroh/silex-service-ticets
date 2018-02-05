<?php
namespace Model
{
    class Concert extends BaseModel{
        
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
                    
                    // новый
                    $oldId=$row['id'];
                    $concert = new \Tickets\Entity\Concert($this->db, $row);
                    $concert->addPrice($row['price_type'], $row['price'], $row['free_seats']);
                    $concerts[] = $concert;
                } else {
                    $concert->addPrice($row['price_type'], $row['price'], $row['free_seats']);
                }
            }
            
            return $concerts;
            
        }
        
    }
    
}


?>