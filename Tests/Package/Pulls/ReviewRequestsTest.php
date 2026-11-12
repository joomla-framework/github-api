<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Pulls;

use Joomla\Github\Package\Pulls\ReviewRequests;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Pulls\ReviewRequests.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(ReviewRequests::class)]
class ReviewRequestsTest extends GitHubTestCase
{
    /**
     * @var    ReviewRequests  Object under test.
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

        $this->object = new ReviewRequests($this->options, $this->client);
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/pulls/1/requested_reviewers', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getList('joomla', 'joomla-platform', 1)
        );
    }

    /**
     * Tests the getList method - failure.
     *
     * @return  void
     */
    public function testGetListFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/pulls/1/requested_reviewers', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getList('joomla', 'joomla-platform', 1);
    }

    /**
     * Tests the request method.
     *
     * @return  void
     */
    public function testRequest()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with(
                '/repos/joomla/joomla-platform/pulls/1/requested_reviewers',
                '{"reviewers":["octocat"],"team_reviewers":["justice-league"]}',
                [],
                0
            )
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->request('joomla', 'joomla-platform', 1, ['octocat'], ['justice-league'])
        );
    }

    /**
     * Tests the request method with teams only.
     *
     * @return  void
     */
    public function testRequestTeamsOnly()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/pulls/1/requested_reviewers', '{"team_reviewers":["justice-league"]}', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->request('joomla', 'joomla-platform', 1, [], ['justice-league'])
        );
    }

    /**
     * Tests the request method - failure.
     *
     * @return  void
     */
    public function testRequestFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/pulls/1/requested_reviewers', '{"reviewers":["octocat"]}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->request('joomla', 'joomla-platform', 1, ['octocat']);
    }

    /**
     * Tests the remove method.
     *
     * @return  void
     */
    public function testRemove()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with(
                '/repos/joomla/joomla-platform/pulls/1/requested_reviewers',
                [],
                null,
                '{"reviewers":["octocat"],"team_reviewers":["justice-league"]}'
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->remove('joomla', 'joomla-platform', 1, ['octocat'], ['justice-league'])
        );
    }

    /**
     * Tests the remove method - failure.
     *
     * @return  void
     */
    public function testRemoveFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/pulls/1/requested_reviewers', [], null, '{"reviewers":["octocat"]}')
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->remove('joomla', 'joomla-platform', 1, ['octocat']);
    }

    /**
     * Tests the rerequest method.
     *
     * @return  void
     */
    public function testRerequest()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with(
                '/repos/joomla/joomla-platform/pulls/1/requested_reviewers/rerequest',
                '{"reviewers":["octocat"]}',
                [],
                0
            )
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->rerequest('joomla', 'joomla-platform', 1, ['octocat'])
        );
    }

    /**
     * Tests the rerequest method - failure.
     *
     * @return  void
     */
    public function testRerequestFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with(
                '/repos/joomla/joomla-platform/pulls/1/requested_reviewers/rerequest',
                '{"team_reviewers":["justice-league"]}',
                [],
                0
            )
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->rerequest('joomla', 'joomla-platform', 1, [], ['justice-league']);
    }
}
