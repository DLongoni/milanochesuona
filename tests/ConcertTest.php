<?php

require( __DIR__ . '/../src/Concert.php');

class ConcertTest extends PHPUnit_Framework_TestCase
{
	public function testConstructor()
	{
		$c = new Concert("Boz Trio");
		$this->assertEquals($c->band,"Boz Trio");
	}
}
