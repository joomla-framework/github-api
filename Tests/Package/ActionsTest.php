<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\Actions;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Test class for the GitHub API package.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Actions::class)]
class ActionsTest extends GitHubTestCase
{
    /**
     * @var    Actions  Object under test.
     * @since  __DEPLOY_VERSION__
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return  void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Actions($this->options, $this->client);
    }

    /**
     * Data provider for the sub-packages.
     *
     * @return  array
     */
    public static function subPackageProvider(): array
    {
        return [
            ['artifacts', Actions\Artifacts::class],
            ['cache', Actions\Cache::class],
            ['concurrencyGroups', Actions\ConcurrencyGroups::class],
            ['hostedRunners', Actions\HostedRunners::class],
            ['oidc', Actions\Oidc::class],
            ['permissions', Actions\Permissions::class],
            ['policies', Actions\Policies::class],
            ['secrets', Actions\Secrets::class],
            ['variables', Actions\Variables::class],
            ['runnerGroups', Actions\RunnerGroups::class],
            ['runners', Actions\Runners::class],
            ['jobs', Actions\Jobs::class],
            ['runs', Actions\Runs::class],
            ['workflows', Actions\Workflows::class],
        ];
    }

    /**
     * Tests that the sub-packages are resolved.
     *
     * @param   string  $name   The property name.
     * @param   string  $class  The expected class.
     *
     * @return  void
     */
    #[DataProvider('subPackageProvider')]
    public function testSubPackage(string $name, string $class)
    {
        $this->assertInstanceOf($class, $this->object->$name);
        $this->assertSame($this->object->$name, $this->object->$name);
    }

    /**
     * Tests that an unknown sub-package throws an exception.
     *
     * @return  void
     */
    public function testUnknownSubPackage()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->object->unknown;
    }
}
