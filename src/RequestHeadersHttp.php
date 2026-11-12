<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github;

use Joomla\Http\Http;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * HTTP client decorator that adds the GitHub request headers to each request.
 *
 * The headers (authentication, media type, API version) are computed for every request and are put on the wrapped
 * client only for the duration of that request. The wrapped client is left as it was, so a client shared with other
 * code never keeps the GitHub credentials, and a changed token is used on the next request.
 *
 * Headers already set on the wrapped client, or passed with the request, take precedence.
 *
 * @since   __DEPLOY_VERSION__
 * @internal
 */
final class RequestHeadersHttp extends Http
{
    /**
     * The wrapped HTTP client.
     *
     * @var    Http
     * @since  __DEPLOY_VERSION__
     */
    private Http $client;

    /**
     * Callback returning the headers to add to each request.
     *
     * @var    \Closure
     * @since  __DEPLOY_VERSION__
     */
    private \Closure $headers;

    /**
     * Constructor.
     *
     * @param   Http      $client   The HTTP client to wrap.
     * @param   \Closure  $headers  Callback returning the headers to add to each request.
     *
     * @since   __DEPLOY_VERSION__
     */
    public function __construct(Http $client, \Closure $headers)
    {
        // A client wrapped for a parent package is unwrapped, so the headers are not added twice.
        if ($client instanceof self) {
            $client = $client->getClient();
        }

        $this->client  = $client;
        $this->headers = $headers;
    }

    /**
     * Get the wrapped HTTP client.
     *
     * @return  Http
     *
     * @since   __DEPLOY_VERSION__
     */
    public function getClient(): Http
    {
        return $this->client;
    }

    /**
     * Get an option from the wrapped HTTP client.
     *
     * @param   string  $key      The name of the option to get.
     * @param   mixed   $default  The default value if the option is not set.
     *
     * @return  mixed  The option value.
     *
     * @since   __DEPLOY_VERSION__
     */
    public function getOption($key, $default = null)
    {
        return $this->client->getOption($key, $default);
    }

    /**
     * Set an option on the wrapped HTTP client.
     *
     * @param   string  $key    The name of the option to set.
     * @param   mixed   $value  The option value to set.
     *
     * @return  $this
     *
     * @since   __DEPLOY_VERSION__
     */
    public function setOption($key, $value)
    {
        $this->client->setOption($key, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function options($url, array $headers = [], $timeout = null)
    {
        return $this->withHeaders(fn () => $this->client->options($url, $headers, $timeout));
    }

    /**
     * {@inheritdoc}
     */
    public function head($url, array $headers = [], $timeout = null)
    {
        return $this->withHeaders(fn () => $this->client->head($url, $headers, $timeout));
    }

    /**
     * {@inheritdoc}
     */
    public function get($url, array $headers = [], $timeout = null)
    {
        return $this->withHeaders(fn () => $this->client->get($url, $headers, $timeout));
    }

    /**
     * {@inheritdoc}
     */
    public function post($url, $data, array $headers = [], $timeout = null)
    {
        return $this->withHeaders(fn () => $this->client->post($url, $data, $headers, $timeout), $data);
    }

    /**
     * {@inheritdoc}
     */
    public function put($url, $data, array $headers = [], $timeout = null)
    {
        return $this->withHeaders(fn () => $this->client->put($url, $data, $headers, $timeout), $data);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($url, array $headers = [], $timeout = null, $data = null)
    {
        return $this->withHeaders(fn () => $this->client->delete($url, $headers, $timeout, $data), $data);
    }

    /**
     * {@inheritdoc}
     */
    public function trace($url, array $headers = [], $timeout = null)
    {
        return $this->withHeaders(fn () => $this->client->trace($url, $headers, $timeout));
    }

    /**
     * {@inheritdoc}
     */
    public function patch($url, $data, array $headers = [], $timeout = null)
    {
        return $this->withHeaders(fn () => $this->client->patch($url, $data, $headers, $timeout), $data);
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->withHeaders(fn () => $this->client->sendRequest($request));
    }

    /**
     * Run a request with the GitHub headers added to the wrapped client, and restore its headers afterwards.
     *
     * The headers are put on the client's options rather than passed with the request, so that request headers
     * passed by the caller keep precedence, as they do for the client's own headers. A string body is sent as JSON
     * unless a content type is given.
     *
     * @param   callable  $request  Callback sending the request.
     * @param   mixed     $data     The request body.
     *
     * @return  mixed  The response.
     *
     * @since   __DEPLOY_VERSION__
     */
    private function withHeaders(callable $request, $data = null)
    {
        $original = $this->client->getOption('headers');
        $headers  = (array) ($original ?? []);
        $existing = array_change_key_case($headers, \CASE_LOWER);
        $added    = ($this->headers)();

        if (\is_string($data)) {
            $added['Content-Type'] = 'application/json';
        }

        foreach ($added as $name => $value) {
            if (!isset($existing[strtolower($name)])) {
                $headers[$name] = $value;
            }
        }

        $this->client->setOption('headers', $headers);

        try {
            return $request();
        } finally {
            $this->client->setOption('headers', $original);
        }
    }
}
