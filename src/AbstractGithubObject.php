<?php
/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github;

use Joomla\Http\Exception\UnexpectedResponseException;
use Joomla\Http\Http as BaseHttp;
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
	 * @param   Registry  $options  GitHub options object.
	 * @param   BaseHttp  $client   The HTTP client object.
	 *
	 * @since   1.0
	 */
	public function __construct(Registry $options = null, BaseHttp $client = null)
	{
		$this->options = $options ?: new Registry;
		$this->client  = $client ?: (new HttpFactory)->getHttp($this->options);

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
	 */
	protected function fetchUrl($path, $page = 0, $limit = 0)
	{
		// Get a new Uri object focusing the api url and given path.
		$uri = new Uri($this->options->get('api.url') . $path);

		if ($this->options->get('gh.token', false))
		{
			// Use oAuth authentication
			$headers = $this->client->getOption('headers', array());

			if (!isset($headers['Authorization']))
			{
				$headers['Authorization'] = 'token ' . $this->options->get('gh.token');
				$this->client->setOption('headers', $headers);
			}
		}
		else
		{
			// Use basic authentication
			if ($this->options->get('api.username', false))
			{
				$uri->setUser($this->options->get('api.username'));
			}

			if ($this->options->get('api.password', false))
			{
				$uri->setPass($this->options->get('api.password'));
			}
		}

		// If we have a defined page number add it to the JUri object.
		if ($page > 0)
		{
			$uri->setVar('page', (int) $page);
		}

		// If we have a defined items per page add it to the JUri object.
		if ($limit > 0)
		{
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
	 * @return  Response
	 *
	 * @since   1.0
	 * @throws  UnexpectedResponseException
	 */
	protected function processResponse(Response $response, $expectedCode = 200)
	{
		// Validate the response code.
		if ($response->getStatusCode() != $expectedCode)
		{
			// Decode the error response and throw an exception.
			$error   = json_decode($response->body);
			$message = isset($error->message) ? $error->message : 'Invalid response received from GitHub.';

			throw new UnexpectedResponseException($response, $message, $response->getStatusCode());
		}

		return json_decode($response->body);
	}
}
