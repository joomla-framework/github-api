<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\Dependabot;
use Joomla\Github\Package\Dependabot\Alerts;
use Joomla\Github\Package\Dependabot\RepositoryAccess;
use Joomla\Github\Package\Dependabot\RunnerSettings;
use Joomla\Github\Package\Dependabot\Secrets;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Dependabot.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Dependabot::class)]
class DependabotTest extends GitHubTestCase
{
    /**
     * @var    Dependabot  Object under test.
     * @since  __DEPLOY_VERSION__
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Dependabot($this->options, $this->client);
    }

    /**
     * Tests that the sub-packages are resolved through the magic getter.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetSubPackages()
    {
        $this->assertInstanceOf(Alerts::class, $this->object->alerts);
        $this->assertInstanceOf(Secrets::class, $this->object->secrets);
        $this->assertInstanceOf(RepositoryAccess::class, $this->object->repositoryAccess);
        $this->assertInstanceOf(RunnerSettings::class, $this->object->runnerSettings);
    }

    /**
     * Tests that an unknown sub-package throws an exception.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetInvalidSubPackage()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->object->unknown;
    }
}
