<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../src/REP/RepUserSubmissions.php';

class RepUserSubmissionsTest extends TestCase
{
    public function testGetList(): void
    {
        $ul = RepUserSubmissions::getList();
        $this->assertGreaterThan(10, count($ul));
    }

    public function testExists(): void
    {
        $this->assertTrue(RepUserSubmissions::exists(522044374821400));
        $this->assertFalse(RepUserSubmissions::exists(522044374821400, 1));
        $this->assertFalse(RepUserSubmissions::exists(2222222));
    }
}

