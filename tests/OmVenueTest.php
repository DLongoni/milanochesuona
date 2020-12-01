<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../src/OM/Venue.php';

class OmVenueTest extends TestCase
{
    public function testInstance(): void
    {
        $v = new Venue();
        $v->name = "Sherazad";
        $this->assertEquals($v->name, "Sherazad");
    }

    public function testHasLoc(): void
    {
        $v = new Venue();
        $this->assertFalse($v->hasLocation());
    }

    public function testLink(): void
    {
        $v = new Venue();
        $v->website = "https://www.minchia.com";
        $this->assertStringContainsString(
            "https://www.minchia.com", 
            $v->getLinkHtml()
        );
    }
}
