<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Dependabot;

use Joomla\Github\Package\Dependabot\RepositoryAccess;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Dependabot\RepositoryAccess.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(RepositoryAccess::class)]
class RepositoryAccessTest extends GitHubTestCase
{
    /**
     * @var    RepositoryAccess  Object under test.
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

        $this->object = new RepositoryAccess($this->options, $this->client);
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/dependabot/repository-access?page=2&per_page=30', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getList('joomla', 2, 30)
        );
    }

    /**
     * Tests the getList method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetListFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/dependabot/repository-access', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getList('joomla');
    }

    /**
     * Tests the edit method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testEdit()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/dependabot/repository-access', json_encode(['repository_ids_to_add' => [1296269], 'repository_ids_to_remove' => [1296270]]), [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->edit('joomla', ['repository_ids_to_add' => [1296269], 'repository_ids_to_remove' => [1296270]]));
    }

    /**
     * Tests the edit method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testEditFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/dependabot/repository-access', '{}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->edit('joomla');
    }

    /**
     * Tests the setDefaultLevel method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testSetDefaultLevel()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/dependabot/repository-access/default-level', json_encode(['default_level' => 'public']), [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->setDefaultLevel('joomla', 'public'));
    }

    /**
     * Tests the setDefaultLevel method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testSetDefaultLevelFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/dependabot/repository-access/default-level', json_encode(['default_level' => 'public']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->setDefaultLevel('joomla', 'public');
    }
}
