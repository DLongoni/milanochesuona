<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../src/REP/RepEventBand.php';

class RepEventBandTest extends TestCase
{
    public function testGetList(): void
    {
        $bl = RepEventBand::getList();
        $this->assertGreaterThan(1000, count($bl));
        $this->assertInstanceOf('EventBand', $bl[0]);
    }

    public function testGetByEventId(): void
    {
        $eb = RepEventBand::getByEventId(54);
        $this->assertEquals(12, $eb[0]->bandId);
    }

    public function testGetByBandId(): void
    {
        $ebl = RepEventBand::getByBandId(12);
        $this->assertEquals(54, $ebl[0]->eventId);
    }
}

