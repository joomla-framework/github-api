<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Stub;

use Joomla\Http\Response;
use Joomla\Http\TransportInterface;
use Joomla\Uri\UriInterface;

/**
 * HTTP transport that records the requests it is asked to send and answers with an empty JSON object.
 */
class RecordingTransport implements TransportInterface
{
    /**
     * The recorded requests, each with the keys method, uri, data and headers.
     *
     * @var  array[]
     */
    public array $requests = [];

    public function request($method, UriInterface $uri, $data = null, array $headers = [], $timeout = null, $userAgent = null)
    {
        $this->requests[] = [
            'method'  => $method,
            'uri'     => (string) $uri,
            'data'    => $data,
            'headers' => $headers,
        ];

        return new Response('data://text/plain,[]', 200, []);
    }

    public static function isSupported()
    {
        return true;
    }
}
