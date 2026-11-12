<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Actions;

use Joomla\Github\Package\Actions\Runs;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for the GitHub API package.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Runs::class)]
class RunsTest extends GitHubTestCase
{
    /**
     * @var    Runs  Object under test.
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

        $this->object = new Runs($this->options, $this->client);
    }

    /**
     * Tests the getListForRepo method.
     *
     * @return  void
     */
    public function testGetListForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runs?page=2&per_page=30&actor=actor-value&exclude_pull_requests=true', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForRepo('joomla', 'joomla-platform', ['actor' => 'actor-value', 'exclude_pull_requests' => true], 2, 30));
    }

    /**
     * Tests the getListForRepo method.
     *
     * @return  void
     */
    public function testGetListForRepoDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runs', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getListForRepo method.
     *
     * @return  void
     */
    public function testGetListForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForRepo('joomla', 'joomla-platform', ['actor' => 'actor-value', 'exclude_pull_requests' => true], 2, 30);
    }

    /**
     * Tests the getListForWorkflow method.
     *
     * @return  void
     */
    public function testGetListForWorkflow()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/workflows/main.yml/runs?page=2&per_page=30&actor=actor-value&exclude_pull_requests=true', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForWorkflow('joomla', 'joomla-platform', 'main.yml', ['actor' => 'actor-value', 'exclude_pull_requests' => true], 2, 30));
    }

    /**
     * Tests the getListForWorkflow method.
     *
     * @return  void
     */
    public function testGetListForWorkflowDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/workflows/main.yml/runs', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForWorkflow('joomla', 'joomla-platform', 'main.yml'));
    }

    /**
     * Tests the getListForWorkflow method.
     *
     * @return  void
     */
    public function testGetListForWorkflowFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForWorkflow('joomla', 'joomla-platform', 'main.yml', ['actor' => 'actor-value', 'exclude_pull_requests' => true], 2, 30);
    }

    /**
     * Tests the get method.
     *
     * @return  void
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runs/1?exclude_pull_requests=true', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->get('joomla', 'joomla-platform', 1, ['exclude_pull_requests' => true]));
    }

    /**
     * Tests the get method.
     *
     * @return  void
     */
    public function testGetDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runs/1', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->get('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the get method.
     *
     * @return  void
     */
    public function testGetFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->get('joomla', 'joomla-platform', 1, ['exclude_pull_requests' => true]);
    }

    /**
     * Tests the delete method.
     *
     * @return  void
     */
    public function testDelete()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/actions/runs/1', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->delete('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the delete method.
     *
     * @return  void
     */
    public function testDeleteFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->delete('joomla', 'joomla-platform', 1);
    }

    /**
     * Tests the getReviews method.
     *
     * @return  void
     */
    public function testGetReviews()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/approvals', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getReviews('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the getReviews method.
     *
     * @return  void
     */
    public function testGetReviewsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getReviews('joomla', 'joomla-platform', 1);
    }

    /**
     * Tests the approve method.
     *
     * @return  void
     */
    public function testApprove()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/approve', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->approve('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the approve method.
     *
     * @return  void
     */
    public function testApproveFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->approve('joomla', 'joomla-platform', 1);
    }

    /**
     * Tests the getAttempt method.
     *
     * @return  void
     */
    public function testGetAttempt()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/attempts/2?exclude_pull_requests=true', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getAttempt('joomla', 'joomla-platform', 1, 2, ['exclude_pull_requests' => true]));
    }

    /**
     * Tests the getAttempt method.
     *
     * @return  void
     */
    public function testGetAttemptDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/attempts/2', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getAttempt('joomla', 'joomla-platform', 1, 2));
    }

    /**
     * Tests the getAttempt method.
     *
     * @return  void
     */
    public function testGetAttemptFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getAttempt('joomla', 'joomla-platform', 1, 2, ['exclude_pull_requests' => true]);
    }

    /**
     * Tests the downloadAttemptLogs method.
     *
     * @return  void
     */
    public function testDownloadAttemptLogs()
    {
        $this->response = $this->getResponseObject('', 302, ['Location' => 'https://example.com/download']);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/attempts/2/logs', [], 0)
            ->willReturn($this->response);

        $this->assertSame('https://example.com/download', $this->object->downloadAttemptLogs('joomla', 'joomla-platform', 1, 2));
    }

    /**
     * Tests the downloadAttemptLogs method.
     *
     * @return  void
     */
    public function testDownloadAttemptLogsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->downloadAttemptLogs('joomla', 'joomla-platform', 1, 2);
    }

    /**
     * Tests the cancel method.
     *
     * @return  void
     */
    public function testCancel()
    {
        $this->response = $this->getResponseObject($this->sampleString, 202);

        $body = '';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/cancel', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->cancel('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the cancel method.
     *
     * @return  void
     */
    public function testCancelFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->cancel('joomla', 'joomla-platform', 1);
    }

    /**
     * Tests the forceCancel method.
     *
     * @return  void
     */
    public function testForceCancel()
    {
        $this->response = $this->getResponseObject($this->sampleString, 202);

        $body = '';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/force-cancel', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->forceCancel('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the forceCancel method.
     *
     * @return  void
     */
    public function testForceCancelFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->forceCancel('joomla', 'joomla-platform', 1);
    }

    /**
     * Tests the reviewCustomGates method.
     *
     * @return  void
     */
    public function testReviewCustomGates()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"comment":"comment","environment_name":"environment-name"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/deployment_protection_rule', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->reviewCustomGates('joomla', 'joomla-platform', 1, 'environment-name', ['comment' => 'comment']));
    }

    /**
     * Tests the reviewCustomGates method.
     *
     * @return  void
     */
    public function testReviewCustomGatesDefaults()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"environment_name":"environment-name"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/deployment_protection_rule', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->reviewCustomGates('joomla', 'joomla-platform', 1, 'environment-name'));
    }

    /**
     * Tests the reviewCustomGates method.
     *
     * @return  void
     */
    public function testReviewCustomGatesFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->reviewCustomGates('joomla', 'joomla-platform', 1, 'environment-name', ['comment' => 'comment']);
    }

    /**
     * Tests the downloadLogs method.
     *
     * @return  void
     */
    public function testDownloadLogs()
    {
        $this->response = $this->getResponseObject('', 302, ['Location' => 'https://example.com/download']);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/logs', [], 0)
            ->willReturn($this->response);

        $this->assertSame('https://example.com/download', $this->object->downloadLogs('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the downloadLogs method.
     *
     * @return  void
     */
    public function testDownloadLogsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->downloadLogs('joomla', 'joomla-platform', 1);
    }

    /**
     * Tests the deleteLogs method.
     *
     * @return  void
     */
    public function testDeleteLogs()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/logs', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->deleteLogs('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the deleteLogs method.
     *
     * @return  void
     */
    public function testDeleteLogsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->deleteLogs('joomla', 'joomla-platform', 1);
    }

    /**
     * Tests the getPendingDeployments method.
     *
     * @return  void
     */
    public function testGetPendingDeployments()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/pending_deployments', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getPendingDeployments('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the getPendingDeployments method.
     *
     * @return  void
     */
    public function testGetPendingDeploymentsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getPendingDeployments('joomla', 'joomla-platform', 1);
    }

    /**
     * Tests the reviewPendingDeployments method.
     *
     * @return  void
     */
    public function testReviewPendingDeployments()
    {
        $body = '{"environment_ids":[1,2],"state":"state","comment":"comment"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/pending_deployments', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->reviewPendingDeployments('joomla', 'joomla-platform', 1, [1, 2], 'state', 'comment'));
    }

    /**
     * Tests the reviewPendingDeployments method.
     *
     * @return  void
     */
    public function testReviewPendingDeploymentsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->reviewPendingDeployments('joomla', 'joomla-platform', 1, [1, 2], 'state', 'comment');
    }

    /**
     * Tests the rerun method.
     *
     * @return  void
     */
    public function testRerun()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"enable_debug_logging":true}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/rerun', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->rerun('joomla', 'joomla-platform', 1, ['enable_debug_logging' => true]));
    }

    /**
     * Tests the rerun method.
     *
     * @return  void
     */
    public function testRerunDefaults()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/rerun', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->rerun('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the rerun method.
     *
     * @return  void
     */
    public function testRerunFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->rerun('joomla', 'joomla-platform', 1, ['enable_debug_logging' => true]);
    }

    /**
     * Tests the rerunFailedJobs method.
     *
     * @return  void
     */
    public function testRerunFailedJobs()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"enable_debug_logging":true}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/rerun-failed-jobs', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->rerunFailedJobs('joomla', 'joomla-platform', 1, ['enable_debug_logging' => true]));
    }

    /**
     * Tests the rerunFailedJobs method.
     *
     * @return  void
     */
    public function testRerunFailedJobsDefaults()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/rerun-failed-jobs', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->rerunFailedJobs('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the rerunFailedJobs method.
     *
     * @return  void
     */
    public function testRerunFailedJobsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->rerunFailedJobs('joomla', 'joomla-platform', 1, ['enable_debug_logging' => true]);
    }

    /**
     * Tests the rerunJob method.
     *
     * @return  void
     */
    public function testRerunJob()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"enable_debug_logging":true}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/jobs/1/rerun', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->rerunJob('joomla', 'joomla-platform', 1, ['enable_debug_logging' => true]));
    }

    /**
     * Tests the rerunJob method.
     *
     * @return  void
     */
    public function testRerunJobDefaults()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/jobs/1/rerun', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->rerunJob('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the rerunJob method.
     *
     * @return  void
     */
    public function testRerunJobFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->rerunJob('joomla', 'joomla-platform', 1, ['enable_debug_logging' => true]);
    }

    /**
     * Tests the getUsage method.
     *
     * @return  void
     */
    public function testGetUsage()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/timing', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getUsage('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the getUsage method.
     *
     * @return  void
     */
    public function testGetUsageFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getUsage('joomla', 'joomla-platform', 1);
    }
}
