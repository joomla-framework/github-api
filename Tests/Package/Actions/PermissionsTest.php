<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Actions;

use Joomla\Github\Package\Actions\Permissions;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for the GitHub API package.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Permissions::class)]
class PermissionsTest extends GitHubTestCase
{
    /**
     * @var    Permissions  Object under test.
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

        $this->object = new Permissions($this->options, $this->client);
    }

    /**
     * Tests the getForOrg method.
     *
     * @return  void
     */
    public function testGetForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/permissions', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getForOrg('joomla'));
    }

    /**
     * Tests the getForOrg method.
     *
     * @return  void
     */
    public function testGetForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getForOrg('joomla');
    }

    /**
     * Tests the setForOrg method.
     *
     * @return  void
     */
    public function testSetForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"allowed_actions":"allowed-actions","enabled_repositories":"enabled-repositories"}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/permissions', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setForOrg('joomla', 'enabled-repositories', ['allowed_actions' => 'allowed-actions']));
    }

    /**
     * Tests the setForOrg method.
     *
     * @return  void
     */
    public function testSetForOrgDefaults()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"enabled_repositories":"enabled-repositories"}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/permissions', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setForOrg('joomla', 'enabled-repositories'));
    }

    /**
     * Tests the setForOrg method.
     *
     * @return  void
     */
    public function testSetForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setForOrg('joomla', 'enabled-repositories', ['allowed_actions' => 'allowed-actions']);
    }

    /**
     * Tests the getArtifactAndLogRetentionForOrg method.
     *
     * @return  void
     */
    public function testGetArtifactAndLogRetentionForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/permissions/artifact-and-log-retention', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getArtifactAndLogRetentionForOrg('joomla'));
    }

    /**
     * Tests the getArtifactAndLogRetentionForOrg method.
     *
     * @return  void
     */
    public function testGetArtifactAndLogRetentionForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getArtifactAndLogRetentionForOrg('joomla');
    }

    /**
     * Tests the setArtifactAndLogRetentionForOrg method.
     *
     * @return  void
     */
    public function testSetArtifactAndLogRetentionForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"days":10}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/permissions/artifact-and-log-retention', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setArtifactAndLogRetentionForOrg('joomla', 10));
    }

    /**
     * Tests the setArtifactAndLogRetentionForOrg method.
     *
     * @return  void
     */
    public function testSetArtifactAndLogRetentionForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setArtifactAndLogRetentionForOrg('joomla', 10);
    }

    /**
     * Tests the getForkPrContributorApprovalForOrg method.
     *
     * @return  void
     */
    public function testGetForkPrContributorApprovalForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/permissions/fork-pr-contributor-approval', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getForkPrContributorApprovalForOrg('joomla'));
    }

    /**
     * Tests the getForkPrContributorApprovalForOrg method.
     *
     * @return  void
     */
    public function testGetForkPrContributorApprovalForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getForkPrContributorApprovalForOrg('joomla');
    }

    /**
     * Tests the setForkPrContributorApprovalForOrg method.
     *
     * @return  void
     */
    public function testSetForkPrContributorApprovalForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"approval_policy":"approval-policy"}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/permissions/fork-pr-contributor-approval', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setForkPrContributorApprovalForOrg('joomla', 'approval-policy'));
    }

    /**
     * Tests the setForkPrContributorApprovalForOrg method.
     *
     * @return  void
     */
    public function testSetForkPrContributorApprovalForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setForkPrContributorApprovalForOrg('joomla', 'approval-policy');
    }

    /**
     * Tests the getPrivateRepoForkPrWorkflowsForOrg method.
     *
     * @return  void
     */
    public function testGetPrivateRepoForkPrWorkflowsForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/permissions/fork-pr-workflows-private-repos', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getPrivateRepoForkPrWorkflowsForOrg('joomla'));
    }

    /**
     * Tests the getPrivateRepoForkPrWorkflowsForOrg method.
     *
     * @return  void
     */
    public function testGetPrivateRepoForkPrWorkflowsForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getPrivateRepoForkPrWorkflowsForOrg('joomla');
    }

    /**
     * Tests the setPrivateRepoForkPrWorkflowsForOrg method.
     *
     * @return  void
     */
    public function testSetPrivateRepoForkPrWorkflowsForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"send_write_tokens_to_workflows":true,"run_workflows_from_fork_pull_requests":true}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/permissions/fork-pr-workflows-private-repos', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setPrivateRepoForkPrWorkflowsForOrg('joomla', true, ['send_write_tokens_to_workflows' => true]));
    }

    /**
     * Tests the setPrivateRepoForkPrWorkflowsForOrg method.
     *
     * @return  void
     */
    public function testSetPrivateRepoForkPrWorkflowsForOrgDefaults()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"run_workflows_from_fork_pull_requests":true}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/permissions/fork-pr-workflows-private-repos', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setPrivateRepoForkPrWorkflowsForOrg('joomla', true));
    }

    /**
     * Tests the setPrivateRepoForkPrWorkflowsForOrg method.
     *
     * @return  void
     */
    public function testSetPrivateRepoForkPrWorkflowsForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setPrivateRepoForkPrWorkflowsForOrg('joomla', true, ['send_write_tokens_to_workflows' => true]);
    }

    /**
     * Tests the getListSelectedRepositoriesForOrg method.
     *
     * @return  void
     */
    public function testGetListSelectedRepositoriesForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/permissions/repositories?page=2&per_page=30', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListSelectedRepositoriesForOrg('joomla', 2, 30));
    }

    /**
     * Tests the getListSelectedRepositoriesForOrg method.
     *
     * @return  void
     */
    public function testGetListSelectedRepositoriesForOrgDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/permissions/repositories', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListSelectedRepositoriesForOrg('joomla'));
    }

    /**
     * Tests the getListSelectedRepositoriesForOrg method.
     *
     * @return  void
     */
    public function testGetListSelectedRepositoriesForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListSelectedRepositoriesForOrg('joomla', 2, 30);
    }

    /**
     * Tests the setSelectedRepositoriesForOrg method.
     *
     * @return  void
     */
    public function testSetSelectedRepositoriesForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"selected_repository_ids":[1,2]}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/permissions/repositories', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setSelectedRepositoriesForOrg('joomla', [1, 2]));
    }

    /**
     * Tests the setSelectedRepositoriesForOrg method.
     *
     * @return  void
     */
    public function testSetSelectedRepositoriesForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setSelectedRepositoriesForOrg('joomla', [1, 2]);
    }

    /**
     * Tests the enableRepositoryForOrg method.
     *
     * @return  void
     */
    public function testEnableRepositoryForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/permissions/repositories/1', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->enableRepositoryForOrg('joomla', 1));
    }

    /**
     * Tests the enableRepositoryForOrg method.
     *
     * @return  void
     */
    public function testEnableRepositoryForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->enableRepositoryForOrg('joomla', 1);
    }

    /**
     * Tests the disableRepositoryForOrg method.
     *
     * @return  void
     */
    public function testDisableRepositoryForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/actions/permissions/repositories/1', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->disableRepositoryForOrg('joomla', 1));
    }

    /**
     * Tests the disableRepositoryForOrg method.
     *
     * @return  void
     */
    public function testDisableRepositoryForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->disableRepositoryForOrg('joomla', 1);
    }

    /**
     * Tests the getAllowedActionsForOrg method.
     *
     * @return  void
     */
    public function testGetAllowedActionsForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/permissions/selected-actions', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getAllowedActionsForOrg('joomla'));
    }

    /**
     * Tests the getAllowedActionsForOrg method.
     *
     * @return  void
     */
    public function testGetAllowedActionsForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getAllowedActionsForOrg('joomla');
    }

    /**
     * Tests the setAllowedActionsForOrg method.
     *
     * @return  void
     */
    public function testSetAllowedActionsForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"github_owned_allowed":true}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/permissions/selected-actions', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setAllowedActionsForOrg('joomla', ['github_owned_allowed' => true]));
    }

    /**
     * Tests the setAllowedActionsForOrg method.
     *
     * @return  void
     */
    public function testSetAllowedActionsForOrgDefaults()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/permissions/selected-actions', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setAllowedActionsForOrg('joomla'));
    }

    /**
     * Tests the setAllowedActionsForOrg method.
     *
     * @return  void
     */
    public function testSetAllowedActionsForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setAllowedActionsForOrg('joomla', ['github_owned_allowed' => true]);
    }

    /**
     * Tests the getSelfHostedRunnersForOrg method.
     *
     * @return  void
     */
    public function testGetSelfHostedRunnersForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/permissions/self-hosted-runners', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getSelfHostedRunnersForOrg('joomla'));
    }

    /**
     * Tests the getSelfHostedRunnersForOrg method.
     *
     * @return  void
     */
    public function testGetSelfHostedRunnersForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getSelfHostedRunnersForOrg('joomla');
    }

    /**
     * Tests the setSelfHostedRunnersForOrg method.
     *
     * @return  void
     */
    public function testSetSelfHostedRunnersForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"enabled_repositories":"enabled-repositories"}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/permissions/self-hosted-runners', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setSelfHostedRunnersForOrg('joomla', 'enabled-repositories'));
    }

    /**
     * Tests the setSelfHostedRunnersForOrg method.
     *
     * @return  void
     */
    public function testSetSelfHostedRunnersForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setSelfHostedRunnersForOrg('joomla', 'enabled-repositories');
    }

    /**
     * Tests the getListSelfHostedRunnersRepositoriesForOrg method.
     *
     * @return  void
     */
    public function testGetListSelfHostedRunnersRepositoriesForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/permissions/self-hosted-runners/repositories?page=2&per_page=30', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListSelfHostedRunnersRepositoriesForOrg('joomla', 2, 30));
    }

    /**
     * Tests the getListSelfHostedRunnersRepositoriesForOrg method.
     *
     * @return  void
     */
    public function testGetListSelfHostedRunnersRepositoriesForOrgDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/permissions/self-hosted-runners/repositories', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListSelfHostedRunnersRepositoriesForOrg('joomla'));
    }

    /**
     * Tests the getListSelfHostedRunnersRepositoriesForOrg method.
     *
     * @return  void
     */
    public function testGetListSelfHostedRunnersRepositoriesForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListSelfHostedRunnersRepositoriesForOrg('joomla', 2, 30);
    }

    /**
     * Tests the setSelfHostedRunnersRepositoriesForOrg method.
     *
     * @return  void
     */
    public function testSetSelfHostedRunnersRepositoriesForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"selected_repository_ids":[1,2]}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/permissions/self-hosted-runners/repositories', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setSelfHostedRunnersRepositoriesForOrg('joomla', [1, 2]));
    }

    /**
     * Tests the setSelfHostedRunnersRepositoriesForOrg method.
     *
     * @return  void
     */
    public function testSetSelfHostedRunnersRepositoriesForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setSelfHostedRunnersRepositoriesForOrg('joomla', [1, 2]);
    }

    /**
     * Tests the enableSelfHostedRunnersRepositoryForOrg method.
     *
     * @return  void
     */
    public function testEnableSelfHostedRunnersRepositoryForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/permissions/self-hosted-runners/repositories/1', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->enableSelfHostedRunnersRepositoryForOrg('joomla', 1));
    }

    /**
     * Tests the enableSelfHostedRunnersRepositoryForOrg method.
     *
     * @return  void
     */
    public function testEnableSelfHostedRunnersRepositoryForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->enableSelfHostedRunnersRepositoryForOrg('joomla', 1);
    }

    /**
     * Tests the disableSelfHostedRunnersRepositoryForOrg method.
     *
     * @return  void
     */
    public function testDisableSelfHostedRunnersRepositoryForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/actions/permissions/self-hosted-runners/repositories/1', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->disableSelfHostedRunnersRepositoryForOrg('joomla', 1));
    }

    /**
     * Tests the disableSelfHostedRunnersRepositoryForOrg method.
     *
     * @return  void
     */
    public function testDisableSelfHostedRunnersRepositoryForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->disableSelfHostedRunnersRepositoryForOrg('joomla', 1);
    }

    /**
     * Tests the getDefaultWorkflowPermissionsForOrg method.
     *
     * @return  void
     */
    public function testGetDefaultWorkflowPermissionsForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/permissions/workflow', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getDefaultWorkflowPermissionsForOrg('joomla'));
    }

    /**
     * Tests the getDefaultWorkflowPermissionsForOrg method.
     *
     * @return  void
     */
    public function testGetDefaultWorkflowPermissionsForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getDefaultWorkflowPermissionsForOrg('joomla');
    }

    /**
     * Tests the setDefaultWorkflowPermissionsForOrg method.
     *
     * @return  void
     */
    public function testSetDefaultWorkflowPermissionsForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"default_workflow_permissions":"default-workflow-permissions"}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/permissions/workflow', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setDefaultWorkflowPermissionsForOrg('joomla', ['default_workflow_permissions' => 'default-workflow-permissions']));
    }

    /**
     * Tests the setDefaultWorkflowPermissionsForOrg method.
     *
     * @return  void
     */
    public function testSetDefaultWorkflowPermissionsForOrgDefaults()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/permissions/workflow', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setDefaultWorkflowPermissionsForOrg('joomla'));
    }

    /**
     * Tests the setDefaultWorkflowPermissionsForOrg method.
     *
     * @return  void
     */
    public function testSetDefaultWorkflowPermissionsForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setDefaultWorkflowPermissionsForOrg('joomla', ['default_workflow_permissions' => 'default-workflow-permissions']);
    }

    /**
     * Tests the getForRepo method.
     *
     * @return  void
     */
    public function testGetForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/permissions', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getForRepo method.
     *
     * @return  void
     */
    public function testGetForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the setForRepo method.
     *
     * @return  void
     */
    public function testSetForRepo()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"allowed_actions":"allowed-actions","enabled":true}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/permissions', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setForRepo('joomla', 'joomla-platform', true, ['allowed_actions' => 'allowed-actions']));
    }

    /**
     * Tests the setForRepo method.
     *
     * @return  void
     */
    public function testSetForRepoDefaults()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"enabled":true}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/permissions', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setForRepo('joomla', 'joomla-platform', true));
    }

    /**
     * Tests the setForRepo method.
     *
     * @return  void
     */
    public function testSetForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setForRepo('joomla', 'joomla-platform', true, ['allowed_actions' => 'allowed-actions']);
    }

    /**
     * Tests the getWorkflowAccessForRepo method.
     *
     * @return  void
     */
    public function testGetWorkflowAccessForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/permissions/access', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getWorkflowAccessForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getWorkflowAccessForRepo method.
     *
     * @return  void
     */
    public function testGetWorkflowAccessForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getWorkflowAccessForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the setWorkflowAccessForRepo method.
     *
     * @return  void
     */
    public function testSetWorkflowAccessForRepo()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"access_level":"access-level"}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/permissions/access', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setWorkflowAccessForRepo('joomla', 'joomla-platform', 'access-level'));
    }

    /**
     * Tests the setWorkflowAccessForRepo method.
     *
     * @return  void
     */
    public function testSetWorkflowAccessForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setWorkflowAccessForRepo('joomla', 'joomla-platform', 'access-level');
    }

    /**
     * Tests the getArtifactAndLogRetentionForRepo method.
     *
     * @return  void
     */
    public function testGetArtifactAndLogRetentionForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/permissions/artifact-and-log-retention', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getArtifactAndLogRetentionForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getArtifactAndLogRetentionForRepo method.
     *
     * @return  void
     */
    public function testGetArtifactAndLogRetentionForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getArtifactAndLogRetentionForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the setArtifactAndLogRetentionForRepo method.
     *
     * @return  void
     */
    public function testSetArtifactAndLogRetentionForRepo()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"days":10}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/permissions/artifact-and-log-retention', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setArtifactAndLogRetentionForRepo('joomla', 'joomla-platform', 10));
    }

    /**
     * Tests the setArtifactAndLogRetentionForRepo method.
     *
     * @return  void
     */
    public function testSetArtifactAndLogRetentionForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setArtifactAndLogRetentionForRepo('joomla', 'joomla-platform', 10);
    }

    /**
     * Tests the getForkPrContributorApprovalForRepo method.
     *
     * @return  void
     */
    public function testGetForkPrContributorApprovalForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/permissions/fork-pr-contributor-approval', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getForkPrContributorApprovalForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getForkPrContributorApprovalForRepo method.
     *
     * @return  void
     */
    public function testGetForkPrContributorApprovalForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getForkPrContributorApprovalForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the setForkPrContributorApprovalForRepo method.
     *
     * @return  void
     */
    public function testSetForkPrContributorApprovalForRepo()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"approval_policy":"approval-policy"}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/permissions/fork-pr-contributor-approval', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setForkPrContributorApprovalForRepo('joomla', 'joomla-platform', 'approval-policy'));
    }

    /**
     * Tests the setForkPrContributorApprovalForRepo method.
     *
     * @return  void
     */
    public function testSetForkPrContributorApprovalForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setForkPrContributorApprovalForRepo('joomla', 'joomla-platform', 'approval-policy');
    }

    /**
     * Tests the getPrivateRepoForkPrWorkflowsForRepo method.
     *
     * @return  void
     */
    public function testGetPrivateRepoForkPrWorkflowsForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/permissions/fork-pr-workflows-private-repos', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getPrivateRepoForkPrWorkflowsForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getPrivateRepoForkPrWorkflowsForRepo method.
     *
     * @return  void
     */
    public function testGetPrivateRepoForkPrWorkflowsForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getPrivateRepoForkPrWorkflowsForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the setPrivateRepoForkPrWorkflowsForRepo method.
     *
     * @return  void
     */
    public function testSetPrivateRepoForkPrWorkflowsForRepo()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"send_write_tokens_to_workflows":true,"run_workflows_from_fork_pull_requests":true}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/permissions/fork-pr-workflows-private-repos', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setPrivateRepoForkPrWorkflowsForRepo('joomla', 'joomla-platform', true, ['send_write_tokens_to_workflows' => true]));
    }

    /**
     * Tests the setPrivateRepoForkPrWorkflowsForRepo method.
     *
     * @return  void
     */
    public function testSetPrivateRepoForkPrWorkflowsForRepoDefaults()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"run_workflows_from_fork_pull_requests":true}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/permissions/fork-pr-workflows-private-repos', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setPrivateRepoForkPrWorkflowsForRepo('joomla', 'joomla-platform', true));
    }

    /**
     * Tests the setPrivateRepoForkPrWorkflowsForRepo method.
     *
     * @return  void
     */
    public function testSetPrivateRepoForkPrWorkflowsForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setPrivateRepoForkPrWorkflowsForRepo('joomla', 'joomla-platform', true, ['send_write_tokens_to_workflows' => true]);
    }

    /**
     * Tests the getAllowedActionsForRepo method.
     *
     * @return  void
     */
    public function testGetAllowedActionsForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/permissions/selected-actions', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getAllowedActionsForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getAllowedActionsForRepo method.
     *
     * @return  void
     */
    public function testGetAllowedActionsForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getAllowedActionsForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the setAllowedActionsForRepo method.
     *
     * @return  void
     */
    public function testSetAllowedActionsForRepo()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"github_owned_allowed":true}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/permissions/selected-actions', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setAllowedActionsForRepo('joomla', 'joomla-platform', ['github_owned_allowed' => true]));
    }

    /**
     * Tests the setAllowedActionsForRepo method.
     *
     * @return  void
     */
    public function testSetAllowedActionsForRepoDefaults()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/permissions/selected-actions', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setAllowedActionsForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the setAllowedActionsForRepo method.
     *
     * @return  void
     */
    public function testSetAllowedActionsForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setAllowedActionsForRepo('joomla', 'joomla-platform', ['github_owned_allowed' => true]);
    }

    /**
     * Tests the getDefaultWorkflowPermissionsForRepo method.
     *
     * @return  void
     */
    public function testGetDefaultWorkflowPermissionsForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/permissions/workflow', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getDefaultWorkflowPermissionsForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getDefaultWorkflowPermissionsForRepo method.
     *
     * @return  void
     */
    public function testGetDefaultWorkflowPermissionsForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getDefaultWorkflowPermissionsForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the setDefaultWorkflowPermissionsForRepo method.
     *
     * @return  void
     */
    public function testSetDefaultWorkflowPermissionsForRepo()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"default_workflow_permissions":"default-workflow-permissions"}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/permissions/workflow', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setDefaultWorkflowPermissionsForRepo('joomla', 'joomla-platform', ['default_workflow_permissions' => 'default-workflow-permissions']));
    }

    /**
     * Tests the setDefaultWorkflowPermissionsForRepo method.
     *
     * @return  void
     */
    public function testSetDefaultWorkflowPermissionsForRepoDefaults()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/permissions/workflow', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setDefaultWorkflowPermissionsForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the setDefaultWorkflowPermissionsForRepo method.
     *
     * @return  void
     */
    public function testSetDefaultWorkflowPermissionsForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setDefaultWorkflowPermissionsForRepo('joomla', 'joomla-platform', ['default_workflow_permissions' => 'default-workflow-permissions']);
    }
}
