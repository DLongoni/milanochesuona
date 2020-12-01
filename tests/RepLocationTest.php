<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/REP/RepLocation.php';

class RepLocationTest extends TestCase
{
    public function testGetList(): void
    {
        $bl = RepLocation::getList();
        $this->assertGreaterThan(1000, count($bl));
        $this->assertInstanceOf('Location', $bl[0]);
    }

    public function testGetById(): void
    {
        $l = RepLocation::getById(2);
        $this->assertEquals("Milan", $l->city);
    }
}
