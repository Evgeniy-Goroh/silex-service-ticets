<?php 

namespace Tickets\Tests\Model;

use PHPUnit\Framework\TestCase;
use Silex\Application;

class ConcertTest extends TestCase
{
    protected $conn;
    
    public function setUp()
    {
        $app = new Application();
        $app['db.options'] = array(
                'host'     => 'localhost',
                'name'   => 'db_tickets_silex',
                'user'     => 'root',
                'password' => '123456',
        );
        $app['dbh'] = new \PDO('mysql:host='.$app['db.options']['host'].';dbname='.$app['db.options']['name'],
                $app['db.options']['user'],
                $app['db.options']['password'],
                array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                ));
        $this->conn = $app['dbh'];
    }
    
    public function testEntityConcert()
    {
        $obj = new \Model\Concert($this->conn);
        $concert = $obj->openById(1);
        $this->assertInstanceOf('\Entity\Concert', $concert);
    }
    
    public function testEntityOrder()
    {
    	$obj = new \Model\Order($this->conn);
    	$Order= $obj->openById(8,$this->conn);
    	$this->assertInstanceOf('\Entity\Order', $Order);
    }
    
}