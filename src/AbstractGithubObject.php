<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github;

use Joomla\Http\Exception\UnexpectedResponseException;
use Joomla\Http\Http as BaseHttp;
use Joomla\Http\HttpFactory;
use Joomla\Http\Response;
use Joomla\Registry\Registry;
use Joomla\Uri\Uri;

/**
 * GitHub API object class for the Joomla Framework.
 *
 * @since  1.0
 */
abstract class AbstractGithubObject
{
    /**
     * Options for the GitHub object.
     *
     * @var    Registry
     * @since  1.0
     */
    protected $options;

    /**
     * The HTTP client object to use in sending HTTP requests.
     *
     * @var    BaseHttp
     * @since  1.0
     */
    protected $client;

    /**
     * The package the object resides in
     *
     * @var    string
     * @since  1.0
     */
    protected $package = '';

    /**
     * Array containing the allowed hook events
     *
     * @var    array
     * @since  1.5.2
     * @link   https://developer.github.com/webhooks/#events
     * @note   From 1.4.0 to 1.5.1 this was named $events, it was renamed due to naming conflicts with package subclasses
     */
    protected $hookEvents = [
        '*',
        'commit_comment',
        'create',
        'delete',
        'deployment',
        'deployment_status',
        'fork',
        'gollum',
        'issue_comment',
        'issues',
        'member',
        'membership',
        'page_build',
        'public',
        'pull_request_review_comment',
        'pull_request',
        'push',
        'repository',
        'release',
        'status',
        'team_add',
        'watch',
    ];

    /**
     * Constructor.
     *
     * @param   ?Registry  $options  GitHub options object.
     * @param   ?BaseHttp  $client   The HTTP client object.
     *
     * @since   1.0
     */
    public function __construct(Registry $options = null, BaseHttp $client = null)
    {
        $this->options = $options ?: new Registry();
        $this->client  = $client ?: (new HttpFactory())->getHttp($this->options);

        $this->package = \get_class($this);
        $this->package = substr($this->package, strrpos($this->package, '\\') + 1);
    }

    /**
     * Method to build and return a full request URL for the request.  This method will
     * add appropriate pagination details if necessary and also prepend the API url
     * to have a complete URL for the request.
     *
     * @param   string   $path   URL to inflect
     * @param   integer  $page   Page to request
     * @param   integer  $limit  Number of results to return per page
     *
     * @return  Uri
     *
     * @since   1.0
     * @since   __DEPLOY_VERSION__  Sets a default `Accept: application/vnd.github+json` header and pins
     *                              `X-GitHub-Api-Version` (overridable via the `api.version` option, or by
     *                              setting either header on the HTTP client before the request). The
     *                              `gh.token.scheme` option (default `token`, unchanged) may be set to
     *                              `Bearer` for fine-grained PATs / GitHub App installation tokens.
     */
    protected function fetchUrl($path, $page = 0, $limit = 0)
    {
        // Get a new Uri object focusing the api url and given path.
        $uri = new Uri($this->options->get('api.url') . $path);

        $headers = $this->client->getOption('headers', []);

        // Pin the REST API media type and version unless the consumer already set their own.
        if (!isset($headers['Accept'])) {
            $headers['Accept'] = 'application/vnd.github+json';
        }

        if (!isset($headers['X-GitHub-Api-Version'])) {
            $headers['X-GitHub-Api-Version'] = $this->options->get('api.version', '2022-11-28');
        }

        if ($this->options->get('gh.token', false)) {
            // Use oAuth authentication
            if (!isset($headers['Authorization'])) {
                // 'token' is the classic scheme; set gh.token.scheme to 'Bearer' for fine-grained
                // PATs or GitHub App installation tokens, both of which GitHub also accepts as 'token'.
                $scheme = $this->options->get('gh.token.scheme', 'token');

                $headers['Authorization'] = $scheme . ' ' . $this->options->get('gh.token');
            }
        } else {
            // Use basic authentication
            // Note: GitHub removed username/password Basic authentication for the API in
            // November 2020; this path is kept only for compatibility with Enterprise Server
            // instances that may still accept it. Use gh.token for github.com.
            if ($this->options->get('api.username', false)) {
                $uri->setUser($this->options->get('api.username'));
            }

            if ($this->options->get('api.password', false)) {
                $uri->setPass($this->options->get('api.password'));
            }
        }

        $this->client->setOption('headers', $headers);

        // If we have a defined page number add it to the JUri object.
        if ($page > 0) {
            $uri->setVar('page', (int) $page);
        }

        // If we have a defined items per page add it to the JUri object.
        if ($limit > 0) {
            $uri->setVar('per_page', (int) $limit);
        }

        return $uri;
    }

    /**
     * Process the response and decode it.
     *
     * @param   Response  $response      The response.
     * @param   integer   $expectedCode  The expected "good" code.
     *
     * @return  mixed
     *
     * @since   1.0
     * @throws  UnexpectedResponseException
     */
    protected function processResponse(Response $response, $expectedCode = 200)
    {
        // Validate the response code.
        if ($response->getStatusCode() != $expectedCode) {
            // Decode the error response and throw an exception.
            $error   = json_decode((string) $response->getBody());
            $message = isset($error->message) ? $error->message : 'Invalid response received from GitHub.';

            throw new UnexpectedResponseException($response, $message, $response->getStatusCode());
        }

        return json_decode((string) $response->getBody());
    }
}
