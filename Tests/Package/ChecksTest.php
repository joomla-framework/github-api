<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\Checks;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Checks.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Checks::class)]
class ChecksTest extends GitHubTestCase
{
    /**
     * @var    Checks  Object under test.
     * @since  __DEPLOY_VERSION__
     */
    protected $object;

    /**
     * Sets up the fixture.
     *
     * @return  void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Checks($this->options, $this->client);
    }

    /**
     * Tests that the runs sub-package is resolved.
     *
     * @return  void
     */
    public function testGetRuns()
    {
        $this->assertInstanceOf(Checks\Runs::class, $this->object->runs);
    }

    /**
     * Tests that the suites sub-package is resolved.
     *
     * @return  void
     */
    public function testGetSuites()
    {
        $this->assertInstanceOf(Checks\Suites::class, $this->object->suites);
    }
}
