<?php

class GoogleMapsGeocoderPickFirstAmbiguityResolutionStrategyTest extends \PHPUnit\Framework\TestCase
{
	private $strat;
	protected function setUp()
	{
		$this->strat=new \Fgms\Distributor\GoogleMapsGeocoderPickFirstAmbiguityResolutionStrategy();
	}
	public function testInvalid()
	{
		$this->expectException('\\LogicException');
		$this->strat->resolve([]);
	}
	public function testOne()
	{
		$arr=['foo'];
		$this->assertSame($arr[0],$this->strat->resolve($arr));
	}
	public function testMultiple()
	{
		$arr=['foo','bar'];
		$this->assertSame($arr[0],$this->strat->resolve($arr));
	}
}