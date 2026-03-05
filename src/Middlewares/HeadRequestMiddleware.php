<?php

declare(strict_types=1);

namespace MaplePHP\Emitron\Middlewares;

use MaplePHP\Http\StreamFactory;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HeadRequestMiddleware implements MiddlewareInterface
{
    /**
     * Detach body on HEAD
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		$response = $handler->handle($request);
		if (strtoupper($request->getMethod()) !== 'HEAD') {
			return $response;
		}
		$streamFactory = new StreamFactory();
		return $response->withBody($streamFactory->createStream());
	}
}
