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
    }
}