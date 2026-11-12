<?php

/**
 * @copyright  Copyright (C) 2017 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Repositories\Branches;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class.
 *
 * @covers \Joomla\Github\Package\Repositories\Branches
 *
 * @since  1.0
 */
#[CoversClass(Branches::class)]
class BranchesTest extends GitHubTestCase
{
    /**
     * @var Branches
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

        $this->object = new Branches($this->options, $this->client);
    }

    /**
     * Tests the GetList method.
     *
     * @covers \Joomla\Github\Package\Repositories\Branches::getList()
     *
     * @return  void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/{owner}/{repo}/branches')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->getList('{owner}', '{repo}'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the Get method.
     *
     * @covers \Joomla\Github\Package\Repositories\Branches::get()
     *
     * @return  void
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/{owner}/{repo}/branches/{branch}')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->get('{owner}', '{repo}', '{branch}'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the rename method.
     *
     * @return  void
     */
    public function testRename()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/rename', '{"new_name":"feature\\/y"}', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->rename('joomla', 'joomla-cms', 'feature/x', 'feature/y')
        );
    }

    /**
     * Tests the rename method - failure.
     *
     * @return  void
     */
    public function testRenameFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/rename', '{"new_name":"feature\\/y"}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->rename('joomla', 'joomla-cms', 'feature/x', 'feature/y');
    }

    /**
     * Tests the mergeUpstream method.
     *
     * @return  void
     */
    public function testMergeUpstream()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/merge-upstream', '{"branch":"4.x-dev"}', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->mergeUpstream('joomla', 'joomla-cms', '4.x-dev')
        );
    }

    /**
     * Tests the mergeUpstream method - failure.
     *
     * @return  void
     */
    public function testMergeUpstreamFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/merge-upstream', '{"branch":"4.x-dev"}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->mergeUpstream('joomla', 'joomla-cms', '4.x-dev');
    }

    /**
     * Tests the getProtection method.
     *
     * @return  void
     */
    public function testGetProtection()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getProtection('joomla', 'joomla-cms', 'feature/x')
        );
    }

    /**
     * Tests the getProtection method - failure.
     *
     * @return  void
     */
    public function testGetProtectionFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getProtection('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the editProtection method.
     *
     * @return  void
     */
    public function testEditProtection()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection',
                '{"allow_deletions":false,"required_status_checks":{"strict":true,"contexts":["ci"]},"enforce_admins":true,"required_pull_request_reviews":null,"restrictions":null}',
                [],
                0
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->editProtection('joomla', 'joomla-cms', 'feature/x', ['strict' => true, 'contexts' => ['ci']], true, null, null, ['allow_deletions' => false])
        );
    }

    /**
     * Tests the editProtection method - failure.
     *
     * @return  void
     */
    public function testEditProtectionFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection',
                '{"required_status_checks":null,"enforce_admins":false,"required_pull_request_reviews":null,"restrictions":null}',
                [],
                0
            )
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->editProtection('joomla', 'joomla-cms', 'feature/x', null, false, null, null);
    }

    /**
     * Tests the deleteProtection method.
     *
     * @return  void
     */
    public function testDeleteProtection()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteProtection('joomla', 'joomla-cms', 'feature/x'));
    }

    /**
     * Tests the deleteProtection method - failure.
     *
     * @return  void
     */
    public function testDeleteProtectionFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->deleteProtection('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the getAdminEnforcement method.
     *
     * @return  void
     */
    public function testGetAdminEnforcement()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/enforce_admins', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getAdminEnforcement('joomla', 'joomla-cms', 'feature/x')
        );
    }

    /**
     * Tests the getAdminEnforcement method - failure.
     *
     * @return  void
     */
    public function testGetAdminEnforcementFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/enforce_admins', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getAdminEnforcement('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the setAdminEnforcement method.
     *
     * @return  void
     */
    public function testSetAdminEnforcement()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/enforce_admins', '', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->setAdminEnforcement('joomla', 'joomla-cms', 'feature/x')
        );
    }

    /**
     * Tests the setAdminEnforcement method - failure.
     *
     * @return  void
     */
    public function testSetAdminEnforcementFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/enforce_admins', '', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->setAdminEnforcement('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the deleteAdminEnforcement method.
     *
     * @return  void
     */
    public function testDeleteAdminEnforcement()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/enforce_admins', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteAdminEnforcement('joomla', 'joomla-cms', 'feature/x'));
    }

    /**
     * Tests the deleteAdminEnforcement method - failure.
     *
     * @return  void
     */
    public function testDeleteAdminEnforcementFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/enforce_admins', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->deleteAdminEnforcement('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the getPullRequestReviewProtection method.
     *
     * @return  void
     */
    public function testGetPullRequestReviewProtection()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_pull_request_reviews', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getPullRequestReviewProtection('joomla', 'joomla-cms', 'feature/x')
        );
    }

    /**
     * Tests the getPullRequestReviewProtection method - failure.
     *
     * @return  void
     */
    public function testGetPullRequestReviewProtectionFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_pull_request_reviews', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getPullRequestReviewProtection('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the editPullRequestReviewProtection method.
     *
     * @return  void
     */
    public function testEditPullRequestReviewProtection()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_pull_request_reviews',
                '{"required_approving_review_count":2}',
                [],
                0
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->editPullRequestReviewProtection('joomla', 'joomla-cms', 'feature/x', ['required_approving_review_count' => 2])
        );
    }

    /**
     * Tests the editPullRequestReviewProtection method - failure.
     *
     * @return  void
     */
    public function testEditPullRequestReviewProtectionFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('patch')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_pull_request_reviews',
                '{}',
                [],
                0
            )
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->editPullRequestReviewProtection('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the deletePullRequestReviewProtection method.
     *
     * @return  void
     */
    public function testDeletePullRequestReviewProtection()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_pull_request_reviews', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deletePullRequestReviewProtection('joomla', 'joomla-cms', 'feature/x'));
    }

    /**
     * Tests the deletePullRequestReviewProtection method - failure.
     *
     * @return  void
     */
    public function testDeletePullRequestReviewProtectionFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_pull_request_reviews', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->deletePullRequestReviewProtection('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the getCommitSignatureProtection method.
     *
     * @return  void
     */
    public function testGetCommitSignatureProtection()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_signatures', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getCommitSignatureProtection('joomla', 'joomla-cms', 'feature/x')
        );
    }

    /**
     * Tests the getCommitSignatureProtection method - failure.
     *
     * @return  void
     */
    public function testGetCommitSignatureProtectionFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_signatures', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getCommitSignatureProtection('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the createCommitSignatureProtection method.
     *
     * @return  void
     */
    public function testCreateCommitSignatureProtection()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_signatures', '', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createCommitSignatureProtection('joomla', 'joomla-cms', 'feature/x')
        );
    }

    /**
     * Tests the createCommitSignatureProtection method - failure.
     *
     * @return  void
     */
    public function testCreateCommitSignatureProtectionFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_signatures', '', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->createCommitSignatureProtection('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the deleteCommitSignatureProtection method.
     *
     * @return  void
     */
    public function testDeleteCommitSignatureProtection()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_signatures', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteCommitSignatureProtection('joomla', 'joomla-cms', 'feature/x'));
    }

    /**
     * Tests the deleteCommitSignatureProtection method - failure.
     *
     * @return  void
     */
    public function testDeleteCommitSignatureProtectionFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_signatures', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->deleteCommitSignatureProtection('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the getRequiredStatusChecks method.
     *
     * @return  void
     */
    public function testGetRequiredStatusChecks()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_status_checks', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getRequiredStatusChecks('joomla', 'joomla-cms', 'feature/x')
        );
    }

    /**
     * Tests the getRequiredStatusChecks method - failure.
     *
     * @return  void
     */
    public function testGetRequiredStatusChecksFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_status_checks', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getRequiredStatusChecks('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the editRequiredStatusChecks method.
     *
     * @return  void
     */
    public function testEditRequiredStatusChecks()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_status_checks',
                '{"strict":true}',
                [],
                0
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->editRequiredStatusChecks('joomla', 'joomla-cms', 'feature/x', ['strict' => true])
        );
    }

    /**
     * Tests the editRequiredStatusChecks method - failure.
     *
     * @return  void
     */
    public function testEditRequiredStatusChecksFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_status_checks', '{}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->editRequiredStatusChecks('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the removeRequiredStatusChecks method.
     *
     * @return  void
     */
    public function testRemoveRequiredStatusChecks()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_status_checks', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->removeRequiredStatusChecks('joomla', 'joomla-cms', 'feature/x'));
    }

    /**
     * Tests the removeRequiredStatusChecks method - failure.
     *
     * @return  void
     */
    public function testRemoveRequiredStatusChecksFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_status_checks', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->removeRequiredStatusChecks('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the getStatusCheckContexts method.
     *
     * @return  void
     */
    public function testGetStatusCheckContexts()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_status_checks/contexts', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getStatusCheckContexts('joomla', 'joomla-cms', 'feature/x')
        );
    }

    /**
     * Tests the getStatusCheckContexts method - failure.
     *
     * @return  void
     */
    public function testGetStatusCheckContextsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_status_checks/contexts', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getStatusCheckContexts('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the addStatusCheckContexts method.
     *
     * @return  void
     */
    public function testAddStatusCheckContexts()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_status_checks/contexts',
                '{"contexts":["ci","lint"]}',
                [],
                0
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->addStatusCheckContexts('joomla', 'joomla-cms', 'feature/x', ['ci', 'lint'])
        );
    }

    /**
     * Tests the addStatusCheckContexts method - failure.
     *
     * @return  void
     */
    public function testAddStatusCheckContextsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_status_checks/contexts',
                '{"contexts":["ci","lint"]}',
                [],
                0
            )
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->addStatusCheckContexts('joomla', 'joomla-cms', 'feature/x', ['ci', 'lint']);
    }

    /**
     * Tests the setStatusCheckContexts method.
     *
     * @return  void
     */
    public function testSetStatusCheckContexts()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_status_checks/contexts',
                '{"contexts":["ci","lint"]}',
                [],
                0
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->setStatusCheckContexts('joomla', 'joomla-cms', 'feature/x', ['ci', 'lint'])
        );
    }

    /**
     * Tests the setStatusCheckContexts method - failure.
     *
     * @return  void
     */
    public function testSetStatusCheckContextsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_status_checks/contexts',
                '{"contexts":["ci","lint"]}',
                [],
                0
            )
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->setStatusCheckContexts('joomla', 'joomla-cms', 'feature/x', ['ci', 'lint']);
    }

    /**
     * Tests the removeStatusCheckContexts method.
     *
     * @return  void
     */
    public function testRemoveStatusCheckContexts()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_status_checks/contexts',
                [],
                null,
                '{"contexts":["ci","lint"]}'
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->removeStatusCheckContexts('joomla', 'joomla-cms', 'feature/x', ['ci', 'lint'])
        );
    }

    /**
     * Tests the removeStatusCheckContexts method - failure.
     *
     * @return  void
     */
    public function testRemoveStatusCheckContextsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/required_status_checks/contexts',
                [],
                null,
                '{"contexts":["ci","lint"]}'
            )
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->removeStatusCheckContexts('joomla', 'joomla-cms', 'feature/x', ['ci', 'lint']);
    }

    /**
     * Tests the getAccessRestrictions method.
     *
     * @return  void
     */
    public function testGetAccessRestrictions()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getAccessRestrictions('joomla', 'joomla-cms', 'feature/x')
        );
    }

    /**
     * Tests the getAccessRestrictions method - failure.
     *
     * @return  void
     */
    public function testGetAccessRestrictionsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getAccessRestrictions('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the deleteAccessRestrictions method.
     *
     * @return  void
     */
    public function testDeleteAccessRestrictions()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteAccessRestrictions('joomla', 'joomla-cms', 'feature/x'));
    }

    /**
     * Tests the deleteAccessRestrictions method - failure.
     *
     * @return  void
     */
    public function testDeleteAccessRestrictionsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->deleteAccessRestrictions('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the getAppAccessRestrictions method.
     *
     * @return  void
     */
    public function testGetAppAccessRestrictions()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/apps', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getAppAccessRestrictions('joomla', 'joomla-cms', 'feature/x')
        );
    }

    /**
     * Tests the getAppAccessRestrictions method - failure.
     *
     * @return  void
     */
    public function testGetAppAccessRestrictionsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/apps', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getAppAccessRestrictions('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the addAppAccessRestrictions method.
     *
     * @return  void
     */
    public function testAddAppAccessRestrictions()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/apps',
                '{"apps":["octoapp"]}',
                [],
                0
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->addAppAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['octoapp'])
        );
    }

    /**
     * Tests the addAppAccessRestrictions method - failure.
     *
     * @return  void
     */
    public function testAddAppAccessRestrictionsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/apps',
                '{"apps":["octoapp"]}',
                [],
                0
            )
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->addAppAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['octoapp']);
    }

    /**
     * Tests the setAppAccessRestrictions method.
     *
     * @return  void
     */
    public function testSetAppAccessRestrictions()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/apps',
                '{"apps":["octoapp"]}',
                [],
                0
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->setAppAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['octoapp'])
        );
    }

    /**
     * Tests the setAppAccessRestrictions method - failure.
     *
     * @return  void
     */
    public function testSetAppAccessRestrictionsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/apps',
                '{"apps":["octoapp"]}',
                [],
                0
            )
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->setAppAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['octoapp']);
    }

    /**
     * Tests the removeAppAccessRestrictions method.
     *
     * @return  void
     */
    public function testRemoveAppAccessRestrictions()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/apps',
                [],
                null,
                '{"apps":["octoapp"]}'
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->removeAppAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['octoapp'])
        );
    }

    /**
     * Tests the removeAppAccessRestrictions method - failure.
     *
     * @return  void
     */
    public function testRemoveAppAccessRestrictionsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/apps',
                [],
                null,
                '{"apps":["octoapp"]}'
            )
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->removeAppAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['octoapp']);
    }

    /**
     * Tests the getTeamAccessRestrictions method.
     *
     * @return  void
     */
    public function testGetTeamAccessRestrictions()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/teams', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getTeamAccessRestrictions('joomla', 'joomla-cms', 'feature/x')
        );
    }

    /**
     * Tests the getTeamAccessRestrictions method - failure.
     *
     * @return  void
     */
    public function testGetTeamAccessRestrictionsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/teams', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getTeamAccessRestrictions('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the addTeamAccessRestrictions method.
     *
     * @return  void
     */
    public function testAddTeamAccessRestrictions()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/teams',
                '{"teams":["justice-league"]}',
                [],
                0
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->addTeamAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['justice-league'])
        );
    }

    /**
     * Tests the addTeamAccessRestrictions method - failure.
     *
     * @return  void
     */
    public function testAddTeamAccessRestrictionsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/teams',
                '{"teams":["justice-league"]}',
                [],
                0
            )
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->addTeamAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['justice-league']);
    }

    /**
     * Tests the setTeamAccessRestrictions method.
     *
     * @return  void
     */
    public function testSetTeamAccessRestrictions()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/teams',
                '{"teams":["justice-league"]}',
                [],
                0
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->setTeamAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['justice-league'])
        );
    }

    /**
     * Tests the setTeamAccessRestrictions method - failure.
     *
     * @return  void
     */
    public function testSetTeamAccessRestrictionsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/teams',
                '{"teams":["justice-league"]}',
                [],
                0
            )
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->setTeamAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['justice-league']);
    }

    /**
     * Tests the removeTeamAccessRestrictions method.
     *
     * @return  void
     */
    public function testRemoveTeamAccessRestrictions()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/teams',
                [],
                null,
                '{"teams":["justice-league"]}'
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->removeTeamAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['justice-league'])
        );
    }

    /**
     * Tests the removeTeamAccessRestrictions method - failure.
     *
     * @return  void
     */
    public function testRemoveTeamAccessRestrictionsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/teams',
                [],
                null,
                '{"teams":["justice-league"]}'
            )
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->removeTeamAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['justice-league']);
    }

    /**
     * Tests the getUserAccessRestrictions method.
     *
     * @return  void
     */
    public function testGetUserAccessRestrictions()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/users', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getUserAccessRestrictions('joomla', 'joomla-cms', 'feature/x')
        );
    }

    /**
     * Tests the getUserAccessRestrictions method - failure.
     *
     * @return  void
     */
    public function testGetUserAccessRestrictionsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/users', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getUserAccessRestrictions('joomla', 'joomla-cms', 'feature/x');
    }

    /**
     * Tests the addUserAccessRestrictions method.
     *
     * @return  void
     */
    public function testAddUserAccessRestrictions()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/users',
                '{"users":["octocat"]}',
                [],
                0
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->addUserAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['octocat'])
        );
    }

    /**
     * Tests the addUserAccessRestrictions method - failure.
     *
     * @return  void
     */
    public function testAddUserAccessRestrictionsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/users',
                '{"users":["octocat"]}',
                [],
                0
            )
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->addUserAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['octocat']);
    }

    /**
     * Tests the setUserAccessRestrictions method.
     *
     * @return  void
     */
    public function testSetUserAccessRestrictions()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/users',
                '{"users":["octocat"]}',
                [],
                0
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->setUserAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['octocat'])
        );
    }

    /**
     * Tests the setUserAccessRestrictions method - failure.
     *
     * @return  void
     */
    public function testSetUserAccessRestrictionsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/users',
                '{"users":["octocat"]}',
                [],
                0
            )
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->setUserAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['octocat']);
    }

    /**
     * Tests the removeUserAccessRestrictions method.
     *
     * @return  void
     */
    public function testRemoveUserAccessRestrictions()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/users',
                [],
                null,
                '{"users":["octocat"]}'
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->removeUserAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['octocat'])
        );
    }

    /**
     * Tests the removeUserAccessRestrictions method - failure.
     *
     * @return  void
     */
    public function testRemoveUserAccessRestrictionsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with(
                '/repos/joomla/joomla-cms/branches/feature%2Fx/protection/restrictions/users',
                [],
                null,
                '{"users":["octocat"]}'
            )
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->removeUserAccessRestrictions('joomla', 'joomla-cms', 'feature/x', ['octocat']);
    }
}
