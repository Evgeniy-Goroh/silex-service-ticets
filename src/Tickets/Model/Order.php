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
    		var_dump($order);
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
    			return Order::saveOrder($dbh, $order->getConcertId(), $order->getEmail(), $order->getSeats());
    		}
    	}
    	
    	public static function saveOrder($dbh, $id, $email, $seats)
    	{
    		echo '<pre>';
    		var_dump($dbh);
    		var_dump($id);
    		var_dump($email);
    		var_dump($seats);
    		echo '</pre>';
    		
    		die('test2');
    		$concert = \Model\Concert::openById($id, $dbh);
    		$dbh->beginTransaction();
    		try {
    			$sql = "INSERT INTO `order` (concert_id, email, is_active, is_paid, created)
                    VALUES (?,?,?,?,NOW())";
    			$sth = $dbh->prepare($sql);
    			$res = $sth->execute(array($id, $email, '1', '0'));
    			if (!$res) {
    				throw new OrderNotSavedException('Ошибка в запросе создания заказа');
    			}
    			
    		} catch (OrderNotSavedException $e) {
    			$dbh->rollBack();
    			return false;
    		}
    		$dbh->commit();
    		return true;
    	}
    }
}