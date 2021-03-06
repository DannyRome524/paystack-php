<?php
namespace Yabacon\Paystack\Tests;

use Yabacon\Paystack;
use Yabacon\Paystack\Helpers\Router;
use Yabacon\Paystack\Test\Mock\CustomRoute;
use \Yabacon\Paystack\Exception\ValidationException;

class PaystackTest extends \PHPUnit_Framework_TestCase
{
    public function testInitializeWithInvalidSecretKey()
    {
        $this->expectException(\InvalidArgumentException::class);
        $r = new Paystack('p');
    }

    public function testVersion()
    {
        $this->assertEquals("2.1.19", Paystack::VERSION);
    }

    public function testDisableFileGetContentsFallback()
    {
        Paystack::disableFileGetContentsFallback();
        $this->assertFalse(Paystack::$fallback_to_file_get_contents);
    }

    public function testEnableFileGetContentsFallback()
    {
        Paystack::enableFileGetContentsFallback();
        $this->assertTrue(Paystack::$fallback_to_file_get_contents);
    }


    public function testSetUseGuzzle()
    {
        $r = new Paystack('sk_');
        $r->useGuzzle();
        $this->assertTrue($r->use_guzzle);
    }

    public function testGetShouldBringRouter()
    {
        $r = new Paystack('sk_');
        $this->assertInstanceOf(Router::class, $r->customer);
        $this->expectException(ValidationException::class);
        $this->assertNull($r->nonexistent);
    }

    public function testListInvalidResource()
    {
        $r = new Paystack('sk_');
        $this->expectException(\InvalidArgumentException::class);
        $this->assertNull($r->nonexistents());
    }

    public function testFetchInvalidResource()
    {
        $r = new Paystack('sk_');
        $this->expectException(ValidationException::class);
        $this->assertNull($r->nonexistent(1));
    }

    public function testFetchWithInvalidParams2()
    {
        $r = new Paystack('sk_');
        $this->expectException(\InvalidArgumentException::class);
        $this->assertNull($r->customer());
    }

    public function testFetchWithInvalidParams3()
    {
        $r = new Paystack('sk_');
        $this->expectException(\InvalidArgumentException::class);
        $this->assertNull($r->customers(1));
    }

    public function testUseRoutes()
    {
        $custom_routes = ['custom_route' => CustomRoute::class];

        $r = new Paystack('sk_');
        $r->useRoutes($custom_routes);
        $this->assertTrue($r->custom_routes == $custom_routes);
    }

    public function testUseRoutesWithInvalidParams1()
    {
        $custom_routes = ['custom_route'];
        $r = new Paystack('sk_');
        $this->expectException(\InvalidArgumentException::class);
        $r->useRoutes($custom_routes);
        $this->assertNull($r->custom_routes);
    }

    public function testUseRoutesWithInvalidParams2()
    {
        $custom_routes = ['custom_route' => Paystack::class];
        $r = new Paystack('sk_');
        $this->expectException(\InvalidArgumentException::class);
        $r->useRoutes($custom_routes);
        $this->assertNull($r->custom_routes);
    }

    public function testUseRoutesWithInvalidParams3()
    {
        $custom_routes = ['balance' => CustomRoute::class];
        $r = new Paystack('sk_');
        $this->expectException(\InvalidArgumentException::class);
        $r->useRoutes($custom_routes);
        $this->assertNull($r->custom_routes);
    }
}
