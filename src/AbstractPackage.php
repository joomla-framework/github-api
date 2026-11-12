<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github;

use Joomla\Http\Http;
use Joomla\Registry\Registry;

/**
 * GitHub API package class for the Joomla Framework.
 *
 * @since  1.0
 */
abstract class AbstractPackage extends AbstractGithubObject
{
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
        parent::__construct($options, $client);

        $this->package = \get_class($this);
        $this->package = substr($this->package, strrpos($this->package, '\\') + 1);
    }

    /**
     * Magic method to lazily create API objects
     *
     * @param   string  $name  Name of property to retrieve
     *
     * @since   1.0
     * @throws \InvalidArgumentException
     *
     * @return  AbstractPackage  GitHub API package object.
     */
    public function __get($name)
    {
        if (isset($this->packages[$name])) {
            return $this->packages[$name];
        }

        $class = '\\Joomla\\Github\\Package\\' . $this->package . '\\' . ucfirst($name);

        if (class_exists($class) == false) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Argument %1$s produced an invalid class name: %2$s in package %3$s',
                    $name,
                    $class,
                    $this->package
                )
            );
        }

        return $this->packages[$name] = new $class($this->options, $this->client);
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
}
