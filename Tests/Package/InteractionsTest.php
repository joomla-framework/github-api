<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\Interactions;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Interactions.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Interactions::class)]
class InteractionsTest extends GitHubTestCase
{
    /**
     * @var    Interactions  Object under test.
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

        $this->object = new Interactions($this->options, $this->client);
    }

    /**
     * Tests the getRestrictionsForOrg method.
     *
     * @return  void
     */
    public function testGetRestrictionsForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/interaction-limits', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getRestrictionsForOrg('joomla')
        );
    }

    /**
     * Tests the getRestrictionsForOrg method.
     *
     * @return  void
     */
    public function testGetRestrictionsForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/interaction-limits', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getRestrictionsForOrg('joomla');
    }

    /**
     * Tests the setRestrictionsForOrg method.
     *
     * @return  void
     */
    public function testSetRestrictionsForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/interaction-limits', json_encode(['expiry' => 'value', 'limit' => 'collaborators_only']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->setRestrictionsForOrg('joomla', 'collaborators_only', ['expiry' => 'value'])
        );
    }

    /**
     * Tests the setRestrictionsForOrg method.
     *
     * @return  void
     */
    public function testSetRestrictionsForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/interaction-limits', json_encode(['expiry' => 'value', 'limit' => 'collaborators_only']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->setRestrictionsForOrg('joomla', 'collaborators_only', ['expiry' => 'value']);
    }

    /**
     * Tests the removeRestrictionsForOrg method.
     *
     * @return  void
     */
    public function testRemoveRestrictionsForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/interaction-limits', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 204));

        $this->assertNull($this->object->removeRestrictionsForOrg('joomla'));
    }

    /**
     * Tests the removeRestrictionsForOrg method.
     *
     * @return  void
     */
    public function testRemoveRestrictionsForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/interaction-limits', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->removeRestrictionsForOrg('joomla');
    }

    /**
     * Tests the getPullRequestCreationCapForOrg method.
     *
     * @return  void
     */
    public function testGetPullRequestCreationCapForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/interaction-limits/pulls/creation-cap', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getPullRequestCreationCapForOrg('joomla')
        );
    }

    /**
     * Tests the getPullRequestCreationCapForOrg method.
     *
     * @return  void
     */
    public function testGetPullRequestCreationCapForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/interaction-limits/pulls/creation-cap', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getPullRequestCreationCapForOrg('joomla');
    }

    /**
     * Tests the editPullRequestCreationCapForOrg method.
     *
     * @return  void
     */
    public function testEditPullRequestCreationCapForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/interaction-limits/pulls/creation-cap', json_encode(['max_open_pull_requests' => 'value', 'enabled' => true]), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->editPullRequestCreationCapForOrg('joomla', true, ['max_open_pull_requests' => 'value'])
        );
    }

    /**
     * Tests the editPullRequestCreationCapForOrg method.
     *
     * @return  void
     */
    public function testEditPullRequestCreationCapForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/interaction-limits/pulls/creation-cap', json_encode(['max_open_pull_requests' => 'value', 'enabled' => true]), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->editPullRequestCreationCapForOrg('joomla', true, ['max_open_pull_requests' => 'value']);
    }

    /**
     * Tests the getRestrictionsForRepo method.
     *
     * @return  void
     */
    public function testGetRestrictionsForRepo(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/interaction-limits', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getRestrictionsForRepo('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the getRestrictionsForRepo method.
     *
     * @return  void
     */
    public function testGetRestrictionsForRepoFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/interaction-limits', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getRestrictionsForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the setRestrictionsForRepo method.
     *
     * @return  void
     */
    public function testSetRestrictionsForRepo(): void
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/interaction-limits', json_encode(['expiry' => 'value', 'limit' => 'collaborators_only']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->setRestrictionsForRepo('joomla', 'joomla-platform', 'collaborators_only', ['expiry' => 'value'])
        );
    }

    /**
     * Tests the setRestrictionsForRepo method.
     *
     * @return  void
     */
    public function testSetRestrictionsForRepoFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/interaction-limits', json_encode(['expiry' => 'value', 'limit' => 'collaborators_only']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->setRestrictionsForRepo('joomla', 'joomla-platform', 'collaborators_only', ['expiry' => 'value']);
    }

    /**
     * Tests the removeRestrictionsForRepo method.
     *
     * @return  void
     */
    public function testRemoveRestrictionsForRepo(): void
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/interaction-limits', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 204));

        $this->assertNull($this->object->removeRestrictionsForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the removeRestrictionsForRepo method.
     *
     * @return  void
     */
    public function testRemoveRestrictionsForRepoFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/interaction-limits', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->removeRestrictionsForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the getPullRequestBypassListForRepo method.
     *
     * @return  void
     */
    public function testGetPullRequestBypassListForRepo(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/interaction-limits/pulls/bypass-list', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getPullRequestBypassListForRepo('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the getPullRequestBypassListForRepo method.
     *
     * @return  void
     */
    public function testGetPullRequestBypassListForRepoFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/interaction-limits/pulls/bypass-list', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getPullRequestBypassListForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the addPullRequestBypassUsersForRepo method.
     *
     * @return  void
     */
    public function testAddPullRequestBypassUsersForRepo(): void
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/interaction-limits/pulls/bypass-list', json_encode(['users' => ['octocat']]), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 204));

        $this->assertNull($this->object->addPullRequestBypassUsersForRepo('joomla', 'joomla-platform', ['octocat']));
    }

    /**
     * Tests the addPullRequestBypassUsersForRepo method.
     *
     * @return  void
     */
    public function testAddPullRequestBypassUsersForRepoFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/interaction-limits/pulls/bypass-list', json_encode(['users' => ['octocat']]), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->addPullRequestBypassUsersForRepo('joomla', 'joomla-platform', ['octocat']);
    }

    /**
     * Tests the removePullRequestBypassUsersForRepo method.
     *
     * @return  void
     */
    public function testRemovePullRequestBypassUsersForRepo(): void
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/interaction-limits/pulls/bypass-list', [], 0, json_encode(['users' => ['octocat']]))
            ->willReturn($this->getResponseObject($this->sampleString, 204));

        $this->assertNull($this->object->removePullRequestBypassUsersForRepo('joomla', 'joomla-platform', ['octocat']));
    }

    /**
     * Tests the removePullRequestBypassUsersForRepo method.
     *
     * @return  void
     */
    public function testRemovePullRequestBypassUsersForRepoFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/interaction-limits/pulls/bypass-list', [], 0, json_encode(['users' => ['octocat']]))
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->removePullRequestBypassUsersForRepo('joomla', 'joomla-platform', ['octocat']);
    }

    /**
     * Tests the getPullRequestCreationCapForRepo method.
     *
     * @return  void
     */
    public function testGetPullRequestCreationCapForRepo(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/interaction-limits/pulls/creation-cap', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getPullRequestCreationCapForRepo('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the getPullRequestCreationCapForRepo method.
     *
     * @return  void
     */
    public function testGetPullRequestCreationCapForRepoFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/interaction-limits/pulls/creation-cap', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getPullRequestCreationCapForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the editPullRequestCreationCapForRepo method.
     *
     * @return  void
     */
    public function testEditPullRequestCreationCapForRepo(): void
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/interaction-limits/pulls/creation-cap', json_encode(['max_open_pull_requests' => 'value', 'enabled' => true]), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->editPullRequestCreationCapForRepo('joomla', 'joomla-platform', true, ['max_open_pull_requests' => 'value'])
        );
    }

    /**
     * Tests the editPullRequestCreationCapForRepo method.
     *
     * @return  void
     */
    public function testEditPullRequestCreationCapForRepoFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/interaction-limits/pulls/creation-cap', json_encode(['max_open_pull_requests' => 'value', 'enabled' => true]), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->editPullRequestCreationCapForRepo('joomla', 'joomla-platform', true, ['max_open_pull_requests' => 'value']);
    }

    /**
     * Tests the getRestrictionsForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testGetRestrictionsForAuthenticatedUser(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/interaction-limits', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getRestrictionsForAuthenticatedUser()
        );
    }

    /**
     * Tests the getRestrictionsForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testGetRestrictionsForAuthenticatedUserWithStatus204(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/interaction-limits', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->getRestrictionsForAuthenticatedUser());
    }

    /**
     * Tests the getRestrictionsForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testGetRestrictionsForAuthenticatedUserFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/interaction-limits', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getRestrictionsForAuthenticatedUser();
    }

    /**
     * Tests the setRestrictionsForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testSetRestrictionsForAuthenticatedUser(): void
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/user/interaction-limits', json_encode(['expiry' => 'value', 'limit' => 'collaborators_only']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->setRestrictionsForAuthenticatedUser('collaborators_only', ['expiry' => 'value'])
        );
    }

    /**
     * Tests the setRestrictionsForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testSetRestrictionsForAuthenticatedUserFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/user/interaction-limits', json_encode(['expiry' => 'value', 'limit' => 'collaborators_only']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->setRestrictionsForAuthenticatedUser('collaborators_only', ['expiry' => 'value']);
    }

    /**
     * Tests the removeRestrictionsForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testRemoveRestrictionsForAuthenticatedUser(): void
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/interaction-limits', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 204));

        $this->assertNull($this->object->removeRestrictionsForAuthenticatedUser());
    }

    /**
     * Tests the removeRestrictionsForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testRemoveRestrictionsForAuthenticatedUserFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/interaction-limits', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->removeRestrictionsForAuthenticatedUser();
    }
}
