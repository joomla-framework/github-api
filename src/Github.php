<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github;

use Joomla\Http\Http;
use Joomla\Http\HttpFactory;
use Joomla\Registry\Registry;

/**
 * Joomla Framework class for interacting with a GitHub server instance.
 *
 * @property-read  Package\Activity       $activity       GitHub API object for the activity package.
 * @property-read  Package\Authorization  $authorization  GitHub API object for the authorizations package.
 * @property-read  Package\Data           $data           GitHub API object for the data package.
 * @property-read  Package\Emojis         $emojis         GitHub API object for the emojis package.
 * @property-read  Package\Gists          $gists          GitHub API object for the gists package.
 * @property-read  Package\Gitignore      $gitignore      GitHub API object for the gitignore package.
 * @property-read  Package\Graphql        $graphql        GitHub API object for the GraphQL v4 API.
 * @property-read  Package\Issues         $issues         GitHub API object for the issues package.
 * @property-read  Package\Markdown       $markdown       GitHub API object for the markdown package.
 * @property-read  Package\Meta           $meta           GitHub API object for the meta package.
 * @property-read  Package\Orgs           $orgs           GitHub API object for the orgs package.
 * @property-read  Package\Pulls          $pulls          GitHub API object for the pulls package.
 * @property-read  Package\Repositories   $repositories   GitHub API object for the repositories package.
 * @property-read  Package\Search         $search         GitHub API object for the search package.
 * @property-read  Package\Users          $users          GitHub API object for the users package.
 * @property-read  Package\Zen            $zen            GitHub API object for the zen package.
 *
 * @since  1.0
 */
class Github
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
     * @var    Http
     * @since  1.0
     */
    protected $client;

    /**
     * The lazily created API objects, keyed by name.
     *
     * Kept in an array instead of dynamic properties, which are deprecated since PHP 8.2.
     *
     * @var    array<string, mixed>
     * @since  __DEPLOY_VERSION__
     */
    private array $packages = [];

    /**
     * Constructor.
     *
     * @param   ?Registry  $options  GitHub options object.
     * @param   ?Http      $client   The HTTP client object.
     *
     * @since   1.0
     */
    public function __construct(Registry $options = null, Http $client = null)
    {
        $this->options = $options ?: new Registry();

        // Setup the default user agent if not already set.
        if (!$this->getOption('userAgent')) {
            $this->setOption('userAgent', 'JGitHub/2.0');
        }

        // Setup the default API url if not already set.
        if (!$this->getOption('api.url')) {
            $this->setOption('api.url', 'https://api.github.com');
        }

        $this->client = $client ?: (new HttpFactory())->getHttp($this->options);
    }

    /**
     * Magic method to lazily create API objects
     *
     * @param   string  $name  Name of property to retrieve
     *
     * @return  AbstractGithubObject  GitHub API object (gists, issues, pulls, etc).
     *
     * @since   1.0
     * @throws  \InvalidArgumentException If $name is not a valid sub class.
     */
    public function __get($name)
    {
        if (isset($this->packages[$name])) {
            return $this->packages[$name];
        }

        $class = 'Joomla\\Github\\Package\\' . ucfirst($name);

        if (class_exists($class)) {
            return $this->packages[$name] = new $class($this->options, $this->client);
        }

        throw new \InvalidArgumentException(sprintf('Argument %s produced an invalid class name: %s', $name, $class));
    }

    /**
     * Magic method to replace an API object, e.g. with a mock in tests
     *
     * @param   string  $name   Name of the property
     * @param   mixed   $value  The object to use
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function __set($name, $value)
    {
        $this->packages[$name] = $value;
    }

    /**
     * Magic method to check whether an API object has been created or set
     *
     * @param   string  $name  Name of the property
     *
     * @return  boolean
     *
     * @since   __DEPLOY_VERSION__
     */
    public function __isset($name)
    {
        return isset($this->packages[$name]);
    }

    /**
     * Magic method to remove an API object, so that it is created again on the next access
     *
     * @param   string  $name  Name of the property
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function __unset($name)
    {
        unset($this->packages[$name]);
    }

    /**
     * Get an option from the GitHub instance.
     *
     * @param   string  $key  The name of the option to get.
     *
     * @return  mixed  The option value.
     *
     * @since   1.0
     */
    public function getOption($key)
    {
        return isset($this->options[$key]) ? $this->options[$key] : null;
    }

    /**
     * Set an option for the GitHub instance.
     *
     * @param   string  $key    The name of the option to set.
     * @param   mixed   $value  The option value to set.
     *
     * @return  GitHub  This object for method chaining.
     *
     * @since   1.0
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;

        return $this;
    }
}
