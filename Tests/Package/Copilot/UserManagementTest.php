<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Copilot;

use Joomla\Github\Package\Copilot\UserManagement;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Copilot\UserManagement.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(UserManagement::class)]
class UserManagementTest extends GitHubTestCase
{
    /**
     * @var    UserManagement  Object under test.
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

        $this->object = new UserManagement($this->options, $this->client);
    }

    /**
     * Tests the getForOrg method.
     *
     * @return  void
     */
    public function testGetForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/billing', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getForOrg('joomla')
        );
    }

    /**
     * Tests the getForOrg method.
     *
     * @return  void
     */
    public function testGetForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/billing', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getForOrg('joomla');
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     */
    public function testGetList(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/billing/seats?page=2&per_page=10', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getList('joomla', 2, 10)
        );
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     */
    public function testGetListFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/billing/seats?page=2&per_page=10', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getList('joomla', 2, 10);
    }

    /**
     * Tests the addTeams method.
     *
     * @return  void
     */
    public function testAddTeams(): void
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/copilot/billing/selected_teams', json_encode(['selected_teams' => ['core', 'docs']]), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->addTeams('joomla', ['core', 'docs'])
        );
    }

    /**
     * Tests the addTeams method.
     *
     * @return  void
     */
    public function testAddTeamsFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/copilot/billing/selected_teams', json_encode(['selected_teams' => ['core', 'docs']]), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->addTeams('joomla', ['core', 'docs']);
    }

    /**
     * Tests the removeTeams method.
     *
     * @return  void
     */
    public function testRemoveTeams(): void
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/copilot/billing/selected_teams', [], 0, json_encode(['selected_teams' => ['core', 'docs']]))
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->removeTeams('joomla', ['core', 'docs'])
        );
    }

    /**
     * Tests the removeTeams method.
     *
     * @return  void
     */
    public function testRemoveTeamsFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/copilot/billing/selected_teams', [], 0, json_encode(['selected_teams' => ['core', 'docs']]))
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->removeTeams('joomla', ['core', 'docs']);
    }

    /**
     * Tests the addUsers method.
     *
     * @return  void
     */
    public function testAddUsers(): void
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/copilot/billing/selected_users', json_encode(['selected_usernames' => ['octocat', 'octokitten']]), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->addUsers('joomla', ['octocat', 'octokitten'])
        );
    }

    /**
     * Tests the addUsers method.
     *
     * @return  void
     */
    public function testAddUsersFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/copilot/billing/selected_users', json_encode(['selected_usernames' => ['octocat', 'octokitten']]), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->addUsers('joomla', ['octocat', 'octokitten']);
    }

    /**
     * Tests the removeUsers method.
     *
     * @return  void
     */
    public function testRemoveUsers(): void
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/copilot/billing/selected_users', [], 0, json_encode(['selected_usernames' => ['octocat', 'octokitten']]))
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->removeUsers('joomla', ['octocat', 'octokitten'])
        );
    }

    /**
     * Tests the removeUsers method.
     *
     * @return  void
     */
    public function testRemoveUsersFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/copilot/billing/selected_users', [], 0, json_encode(['selected_usernames' => ['octocat', 'octokitten']]))
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->removeUsers('joomla', ['octocat', 'octokitten']);
    }

    /**
     * Tests the getForUser method.
     *
     * @return  void
     */
    public function testGetForUser(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/members/octocat/copilot', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getForUser('joomla', 'octocat')
        );
    }

    /**
     * Tests the getForUser method.
     *
     * @return  void
     */
    public function testGetForUserFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/members/octocat/copilot', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getForUser('joomla', 'octocat');
    }
}
