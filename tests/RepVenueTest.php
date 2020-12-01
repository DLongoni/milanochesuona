<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/REP/RepVenue.php';

class RepVenueTest extends TestCase
{
    // Too slow
    // public function testGetList(): void
    // {
    //   $vl = RepVenue::getList();
    //   $this->assertGreaterThan(1000, count($vl));
    //   $this->assertInstanceOf('Venue', $vl[0]);
    // }

    public function testGetById(): void
    {
        $v = RepVenue::getById(17);
        $this->assertEquals("Circolo Agorà", $v->name);
    }

    public function testGetByFbId(): void
    {
        $v = RepVenue::getByFbId(224486880940270);
        $this->assertEquals("Circolo Agorà", $v->name);
    }
}
