<?php
namespace Model
{
    class Order extends BaseModel
    {
        public static function openById($id, $dbh)
        {
            $sql = "SELECT id, concert_id, email, is_active, is_paid, created, total
                   FROM `order`
                   WHERE id = ?";
            $sth = $dbh->prepare($sql);
            $sth->execute(array($id));
            if ($row = $sth->fetch()) {
                return new \Entity\Order($row);
            }
            
            return null;
        }
        
        /**
         * возвращает массив купленных мест
         */
        public static function getSeats($order, $dbh)
        {
            $sql = "SELECT row, seat
                   FROM order_seats
                   WHERE order_id = ?";
            $sth = $dbh->prepare($sql);
            $sth->execute(array($order->getId()));
            return $sth->fetchAll();
        }
        
        
        public static function save($order, $dbh)
        {
            echo '<pre>';
            var_dump('save cуществующий');
            echo '</pre>';
            
            if ($order->getId()) {
                die('test1');
                // существующий
                $sql = "UPDATE `order`
                    SET is_active = ?, is_paid = ?
                    WHERE id = ?";
                $sth = $dbh->prepare($sql);
                $res = $sth->execute(array($order->getIsActive(), $order->getIsPaid(), $order->getId()));
                return $res;
            } else {
                
                //die('test2');
                return Order::saveOrder($dbh, $order->getConcertId(), $order->getEmail(), $order->getSeats(),$order->getTotal());
            }
        }
        
        public static function saveOrder($dbh, $id, $email, $seats, $total)
        {
            
            $obj = new \Model\Concert($dbh);
            $data['concert'] = $obj->openById($id);
            $obj->getPrices($data['concert']);
            $data['price'] = $data['concert']->getPrices();
            
            $dbh->beginTransaction();
            try {
                $sql = "INSERT INTO `order` (concert_id, email,total, is_active, is_paid, created)
                    VALUES (?,?,?,?,?,NOW())";
                $sth = $dbh->prepare($sql);
                $res = $sth->execute(array($id, $email, $total,'1', '0'));
                if (!$res) {
                    throw new Exception('Ошибка в запросе создания заказа');
                }
                $order_id = $dbh->lastInsertId();
                foreach($seats as $seat) {
                    $price = $obj->priceByRow($data['price'],$seat['row']);
                    $crs = $id.'/'.$seat['row'].'/'.$seat['seat'];
                    $sql = "INSERT INTO order_seats (order_id, price_type, row, seat, crs, price)
                        VALUES (?,?,?,?,?,?)";
                    $sth = $dbh->prepare($sql);
                    $res = $sth->execute(array($order_id, $price['type'], $seat['row'], $seat['seat'], $crs, $price['price']));
                    if (!$res) {
                        throw new Exception('Ошибка при сохранении места');
                    }
                }
                
            } catch (Exception $e) {
                $dbh->rollBack();
                
                return false;
            }
            
            $dbh->commit();
            
            return true;
        }
        
        public static function getAllOrders($dbh)
        {
            $sql = "SELECT o.id, c.title, o.email, o.is_active, o.is_paid, o.created, o.total
                    FROM `order` as o
                    INNER JOIN concert as c ON o.concert_id=c.id
                    ORDER BY o.created DESC";
            $sth = $dbh->prepare($sql);
            $sth->execute(array());
            
            return $sth->fetchAll();
        }
        
        public static function getAllOrdersSeat($dbh)
        {
            echo 'test';
        }
        
        /**
         * Неоплаченные заявки старше часа деактивируются
         */
        public  function clearOrders($dbh)
        {
        	$sql = "UPDATE `order`, order_seats
                SET `order`.is_active='0', order_seats.crs = NULL
                WHERE order_seats.order_id = `order`.id
                    AND ADDTIME(`order`.created, '01:00:00')<NOW()
                    AND `order`.is_paid='0'
                    AND `order`.is_active='1'";
        	$sth = $dbh->prepare($sql);
        	
        	return $sth->execute(array());
        }
        
    }
}