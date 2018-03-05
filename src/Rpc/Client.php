<?php
// +----------------------------------------------------------------------
// | Client.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Xin\Http\Rpc;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;
use Xin\Http\Rpc\Exceptions\InitException;

/**
 * Class Client
 * @package Xin\Http\Rpc
 */
abstract class Client
{
    protected $guzzleClient;

    protected $baseUri;

    protected $timeout = 2;

    protected function getGuzzleClient()
    {
        if (isset($this->guzzleClient) && $this->guzzleClient instanceof GuzzleClient) {
            return $this->guzzleClient;
        }
        return $this->guzzleClient = new GuzzleClient([
            'base_uri' => $this->getBaseUri(),
            'timeout' => $this->getTimeout(),
        ]);
    }

    protected function getBaseUri()
    {
        if (!isset($this->baseUri)) {
            throw new InitException('Please rewrite getBaseUri function or baseUri property');
        }
        return $this->baseUri;
    }

    protected function getTimeout()
    {
        return $this->timeout;
    }

    protected function beforeExecute($method, $arguments)
    {
    }

    protected function afterExecute($method, $arguments, ResponseInterface $response)
    {
    }

    protected function handleRequest($method, $arguments)
    {
        return $arguments;
    }

    protected function handleResponse($method, $arguments, $response)
    {
        return json_decode($response, true);
    }

    public function __call($name, $arguments)
    {
        $arguments = $this->handleRequest($name, $arguments);
        $this->beforeExecute($name, $arguments);

        // 接口调用
        /** @var ResponseInterface $result */
        $result = $this->getGuzzleClient()->$name(...$arguments);

        $this->afterExecute($name, $arguments, $result);
        return $this->handleResponse($name, $arguments, $result->getBody());
    }
}
