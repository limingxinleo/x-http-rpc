# Http RPC Library

[![Build Status](https://travis-ci.org/limingxinleo/x-http-rpc.svg?branch=master)](https://travis-ci.org/limingxinleo/x-http-rpc)

## 安装
~~~
composer require limingxinleo/x-http-rpc
~~~

## 简单使用
~~~php
<?php
use Psr\Http\Message\ResponseInterface;
use Xin\Http\Rpc\Client;
use Xin\Http\Rpc\Exceptions\HttpException;
use Xin\Traits\Common\InstanceTrait;

class TestClient extends Client
{
    // composer require limingxinleo/x-trait-common
    use InstanceTrait;

    protected $baseUri = 'http://api.demo.phalcon.lmx0536.cn';

    public function testPost()
    {
        $params = [
            'name' => 'limx',
            'age' => 28
        ];
        return $this->post('/api/request', [
            'form_params' => $params
        ]);
    }
}

$result = TestClient::getInstance()->testPost();
~~~

## 复杂使用

[x-http-rpc-demo](https://github.com/Aquarmini/x-http-rpc-demo)