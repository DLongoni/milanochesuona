<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../src/OM/Location.php';

class OmLocationTest extends TestCase
{
	public function testInstance(): void
	{
		$l = new Location();
    $l->city = "Sherazad";
		$this->assertEquals($l->city,"Sherazad");
	}

	public function testDescription(): void
	{
		$l = new Location();
    $l->street = "viadallepalle";
		$this->assertEquals("viadallepalle", $l->getDescription());
	}

	public function testDistance(): void
	{
		$l = new Location();
		$this->assertEquals($l->getDistance(),10000);
    $l->latitude = 45;
    $l->longitude = 9;
		$this->assertLessThan(100, $l->getDistance());
	}
}
