<?php

class GoogleMapsGeocoderTest extends \PHPUnit\Framework\TestCase
{
    private $mock;
    private $geo;
    private $api_key='test';
    protected function setUp()
    {
        $this->mock=new \GuzzleHttp\Handler\MockHandler();
        $handler=\GuzzleHttp\HandlerStack::create($this->mock);
        $client=new \GuzzleHttp\Client(['handler' => $handler]);
        $this->geo=new \Fgms\Distributor\GoogleMapsGeocoder($this->api_key,$client);
    }
    private function throws()
    {
        $this->expectException('\\Fgms\\Distributor\\GoogleMapsGeocoderException');
    }
    private function response($body)
    {
        $this->mock->append(new \GuzzleHttp\Psr7\Response(200,[],$body));
    }
    private function forward()
    {
        return $this->geo->forward('foo','bar',null,'baz');
    }
    private function assertPair($pair, $lat, $lng)
    {
        $this->assertTrue(is_array($pair));
        $this->assertSame(2,count($pair));
        $this->assertSame($lat,$pair[0]);
        $this->assertSame($lng,$pair[1]);
    }
    public function testStatusCode()
    {
        $this->mock->append(new \GuzzleHttp\Psr7\Response(200));
        $this->throws();
        $this->forward();
    }
    public function testInvalidJson()
    {
        $this->response('aoeu');
        $this->throws();
        $this->forward();
    }
    public function testJsonNotObject()
    {
        $this->response('[]');
        $this->throws();
        $this->forward();
    }
    public function testNoResults()
    {
        $this->response('{}');
        $this->throws();
        $this->forward();
    }
    public function testResultsNotArray()
    {
        $this->response('{"results":"foo"}');
        $this->throws();
        $this->forward();
    }
    public function testResultsEmpty()
    {
        $this->response('{"results":[]}');
        $this->throws();
        $this->forward();
    }
    public function testResultsAmbiguous()
    {
        $this->response('{"results":[{"geometry":{"location":{"lat":5,"lng":3}}},{"geometry":{"location":{"lat":5,"lng":3}}}]}');
        $this->throws();
        $this->forward();
    }
    public function testResultNotObject()
    {
        $this->response('{"results":[[]]}');
        $this->throws();
        $this->forward();
    }
    public function testNoGeometry()
    {
		$this->response('{"results":[{}]}');
		$this->throws();
		$this->forward();
    }
    public function testGeometryNotObject()
    {
		$this->response('{"results":[{"geometry":[]}]}');
		$this->throws();
		$this->forward();
    }
    public function testNoLocation()
    {
		$this->response('{"results":[{"geometry":{}}]}');
		$this->throws();
		$this->forward();
    }
    public function testLocationNotObject()
    {
		$this->response('{"results":[{"geometry":{"location":[]}}]}');
		$this->throws();
		$this->forward();
    }
    public function testNotLat()
    {
		$this->response('{"results":[{"geometry":{"location":{"lng":3}}}]}');
		$this->throws();
		$this->forward();
    }
    public function testNoLng()
    {
		$this->response('{"results":[{"geometry":{"location":{"lat":5}}}]}');
		$this->throws();
		$this->forward();
    }
    public function testLatNotNumber()
    {
		$this->response('{"results":[{"geometry":{"location":{"lat":{},"lng":3}}}]}');
		$this->throws();
		$this->forward();
    }
    public function testLngNotNumber()
    {
		$this->response('{"results":[{"geometry":{"location":{"lat":5,"lng":[]}}}]}');
		$this->throws();
		$this->forward();
    }
    public function testBothInteger()
    {
		$this->response('{"results":[{"geometry":{"location":{"lat":5,"lng":3}}}]}');
		$pair=$this->forward();
        $this->assertPair($pair,5,3);
    }
    public function testBothFloat()
    {
		$this->response('{"results":[{"geometry":{"location":{"lat":5.5,"lng":3.5}}}]}');
		$pair=$this->forward();
        $this->assertPair($pair,5.5,3.5);
    }
    public function testLatIntegerLngFloat()
    {
		$this->response('{"results":[{"geometry":{"location":{"lat":5,"lng":3.5}}}]}');
		$pair=$this->forward();
        $this->assertPair($pair,5,3.5);
    }
    public function testLatFloatLngInteger()
    {
		$this->response('{"results":[{"geometry":{"location":{"lat":5.5,"lng":3}}}]}');
		$pair=$this->forward();
        $this->assertPair($pair,5.5,3);
    }
}