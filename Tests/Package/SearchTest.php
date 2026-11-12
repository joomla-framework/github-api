<?php
/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Search;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for Activity.
 *
 * @since  1.0
 */
class SearchTest extends GitHubTestCase
{
    /**
     * @var Search
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @since   1.0
     *
     * @return  void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Search($this->options, $this->client);
    }

    /**
     * Tests that the methods for the removed legacy search API are gone
     *
     * @return  void
     */
    public function testLegacyMethodsAreRemoved()
    {
        foreach (['issues', 'repositories', 'users', 'email'] as $method) {
            $this->assertFalse(method_exists($this->object, $method), $method);
        }
    }
}
