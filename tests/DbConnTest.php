<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../src/DbConn.php';

class DbConnTest extends TestCase
{
    public function testGetConn(): void
    {
        $conn = GetConn();
        $this->assertEquals($conn->connect_errno, 0);
        $conn->close();
    }
}
