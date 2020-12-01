<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../src/REP/RepBand.php';

class RepBandTest extends TestCase
{
    public function testGetList(): void
    {
        $bl = RepBand::getList();
        $this->assertGreaterThan(1000, count($bl));
        $this->assertInstanceOf('Band', $bl[0]);
    }

    public function testGetById(): void
    {
        $b = RepBand::getById(648);
        $this->assertEquals("Punkreas", $b->name);
    }

    public function testGetByFbId(): void
    {
        $b = RepBand::getByFbId(119064771484094);
        $this->assertEquals("Punkreas", $b->name);
    }

    public function testGetByName(): void
    {
        $b = RepBand::getByName("Punkreas");
        $this->assertEquals("Punkreas", $b->name);
    }
}

