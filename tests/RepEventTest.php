<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../src/REP/RepEvent.php';

class RepEventTest extends TestCase
{
	// public function testGetList(): void
	// {
  //   // Too slow
	// }

	public function testGetByDate(): void
	{
    $el = RepEvent::getByDate("20-jan-2019");
    $this->assertGreaterThan(10, count($el));
    $this->assertInstanceOf('Event', $el[0]);
	}

	public function testGetById(): void
	{
    $e = RepEvent::getById(54);
    $this->assertEquals("La Malaleche", $e->title);
	}

	public function testGetByFbId(): void
	{
    $e = RepEvent::getByFbId(1912051795736573);
    $this->assertEquals("La Malaleche", $e->title);
	}
}

