<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../src/OM/Band.php';

class OmBandTest extends TestCase
{
    public function testInstance(): void
    {
        $b = new Band();
        $b->name = "Sherazad";
        $this->assertEquals($b->name, "Sherazad");
    }

    public function testLink(): void
    {
        $b = new Band();
        $b->fbId = 1234;
        $this->assertStringContainsString("facebook", $b->getLinkHtml());
    }
}
