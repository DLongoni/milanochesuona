<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../src/OM/EventBand.php';

class OmEventBandTest extends TestCase
{
	public function testInstance(): void
	{
		$eb = new EventBand();
    $eb->eventId = 1234;
		$this->assertEquals($eb->eventId,1234);
	}

}
