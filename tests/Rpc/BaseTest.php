<?php
// +----------------------------------------------------------------------
// | BaseTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\Rpc;

use Tests\App\TestClient;
use Tests\TestCase;
use swoole_process;

class BaseTest extends TestCase
{
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testGet()
    {
        $result = TestClient::getInstance()->test();
        $this->assertTrue($result['success']);
        $this->assertEquals('limx', $result['model']['welcome']);

        $result = TestClient::getInstance()->testGet();
        $this->assertEquals('GET', $result['model']['method']);
        $this->assertEquals('limx', $result['model']['body']['name']);
    }

    public function testPost()
    {
        $result = TestClient::getInstance()->testPost();
        $this->assertTrue($result['success']);
        $this->assertEquals('POST', $result['model']['method']);
        $this->assertEquals('limx', $result['model']['body']['name']);
        $this->assertEquals(28, $result['model']['body']['age']);
    }

    public function testJson()
    {
        $result = TestClient::getInstance()->testJson();
        $this->assertTrue($result['success']);
        $this->assertEquals('POST', $result['model']['method']);
        $this->assertEquals('Agnes', $result['model']['json']['name']);
        $this->assertEquals(28, $result['model']['json']['age']);
    }

    public function test404()
    {
        try {
            $result = TestClient::getInstance()->test404();
        } catch (\Exception $ex) {
            $this->assertEquals(
                'Client error: `POST http://api.demo.phalcon.lmx0536.cn/api/404` resulted in a `404 Not Found` response',
                $ex->getMessage()
            );
        }
    }
}
