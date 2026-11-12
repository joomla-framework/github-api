<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Copilot;

use Joomla\Github\Package\Copilot\CodingAgentManagement;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Copilot\CodingAgentManagement.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(CodingAgentManagement::class)]
class CodingAgentManagementTest extends GitHubTestCase
{
    /**
     * @var    CodingAgentManagement  Object under test.
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

        $this->object = new CodingAgentManagement($this->options, $this->client);
    }

    /**
     * Tests the getPermissions method.
     *
     * @return  void
     */
    public function testGetPermissions(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/coding-agent/permissions', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getPermissions('joomla')
        );
    }

    /**
     * Tests the getPermissions method.
     *
     * @return  void
     */
    public function testGetPermissionsFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/coding-agent/permissions', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getPermissions('joomla');
    }

    /**
     * Tests the setPermissions method.
     *
     * @return  void
     */
    public function testSetPermissions(): void
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/copilot/coding-agent/permissions', json_encode(['enabled_repositories' => 'selected']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 204));

        $this->assertNull($this->object->setPermissions('joomla', 'selected'));
    }

    /**
     * Tests the setPermissions method.
     *
     * @return  void
     */
    public function testSetPermissionsFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/copilot/coding-agent/permissions', json_encode(['enabled_repositories' => 'selected']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->setPermissions('joomla', 'selected');
    }

    /**
     * Tests the getRepositories method.
     *
     * @return  void
     */
    public function testGetRepositories(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/coding-agent/permissions/repositories?page=2&per_page=10', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getRepositories('joomla', 2, 10)
        );
    }

    /**
     * Tests the getRepositories method.
     *
     * @return  void
     */
    public function testGetRepositoriesFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/coding-agent/permissions/repositories?page=2&per_page=10', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getRepositories('joomla', 2, 10);
    }

    /**
     * Tests the setRepositories method.
     *
     * @return  void
     */
    public function testSetRepositories(): void
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/copilot/coding-agent/permissions/repositories', json_encode(['selected_repository_ids' => [1, 2]]), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 204));

        $this->assertNull($this->object->setRepositories('joomla', [1, 2]));
    }

    /**
     * Tests the setRepositories method.
     *
     * @return  void
     */
    public function testSetRepositoriesFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/copilot/coding-agent/permissions/repositories', json_encode(['selected_repository_ids' => [1, 2]]), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->setRepositories('joomla', [1, 2]);
    }

    /**
     * Tests the enableRepository method.
     *
     * @return  void
     */
    public function testEnableRepository(): void
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/copilot/coding-agent/permissions/repositories/42', '', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 204));

        $this->assertNull($this->object->enableRepository('joomla', 42));
    }

    /**
     * Tests the enableRepository method.
     *
     * @return  void
     */
    public function testEnableRepositoryFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/copilot/coding-agent/permissions/repositories/42', '', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->enableRepository('joomla', 42);
    }

    /**
     * Tests the disableRepository method.
     *
     * @return  void
     */
    public function testDisableRepository(): void
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/copilot/coding-agent/permissions/repositories/42', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 204));

        $this->assertNull($this->object->disableRepository('joomla', 42));
    }

    /**
     * Tests the disableRepository method.
     *
     * @return  void
     */
    public function testDisableRepositoryFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/copilot/coding-agent/permissions/repositories/42', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->disableRepository('joomla', 42);
    }
}
