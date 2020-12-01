<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../src/OM/Event.php';

class OmEventTest extends TestCase
{
    public function testInstance(): void
    {
        $e = new Event();
        $e->title = "Sagra della patata";
        $this->assertEquals($e->title, "Sagra della patata");
    }
}
