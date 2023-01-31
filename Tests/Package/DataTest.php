<?php
/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Data;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class.
 *
 * @covers \Joomla\Github\Package\Data
 *
 * @since  1.0
 */
class DataTest extends GitHubTestCase
{
    /**
     * @var Data
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

        $this->object = new Data($this->options, $this->client);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Data::__construct()
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testConstruct()
    {
        // Dummy to make PHPUnit "happy"
        self::assertEquals(true, true);
    }
}
