<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\Reactions;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Reactions.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Reactions::class)]
class ReactionsTest extends GitHubTestCase
{
    /**
     * @var    Reactions  Object under test.
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

        $this->object = new Reactions($this->options, $this->client);
    }

    /**
     * Tests that creating a reaction which already exists (HTTP 200) returns it.
     *
     * @return  void
     */
    public function testCreateForIssueExisting()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/issues/5/reactions', '{"content":"heart"}', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createForIssue('joomla', 'joomla-cms', 5, 'heart')
        );
    }

    /**
     * Tests the getListForCommitComment method.
     *
     * @return  void
     */
    public function testGetListForCommitComment()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/comments/5/reactions?page=2&per_page=10&content=heart', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForCommitComment('joomla', 'joomla-cms', 5, ['content' => 'heart'], 2, 10)
        );
    }

    /**
     * Tests the getListForCommitComment method - failure.
     *
     * @return  void
     */
    public function testGetListForCommitCommentFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/comments/5/reactions', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getListForCommitComment('joomla', 'joomla-cms', 5);
    }

    /**
     * Tests the createForCommitComment method.
     *
     * @return  void
     */
    public function testCreateForCommitComment()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/comments/5/reactions', '{"content":"heart"}', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createForCommitComment('joomla', 'joomla-cms', 5, 'heart')
        );
    }

    /**
     * Tests the createForCommitComment method - failure.
     *
     * @return  void
     */
    public function testCreateForCommitCommentFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/comments/5/reactions', '{"content":"heart"}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->createForCommitComment('joomla', 'joomla-cms', 5, 'heart');
    }

    /**
     * Tests the deleteForCommitComment method.
     *
     * @return  void
     */
    public function testDeleteForCommitComment()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/comments/5/reactions/7', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteForCommitComment('joomla', 'joomla-cms', 5, 7));
    }

    /**
     * Tests the deleteForCommitComment method - failure.
     *
     * @return  void
     */
    public function testDeleteForCommitCommentFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/comments/5/reactions/7', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->deleteForCommitComment('joomla', 'joomla-cms', 5, 7);
    }

    /**
     * Tests the getListForIssueComment method.
     *
     * @return  void
     */
    public function testGetListForIssueComment()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/issues/comments/5/reactions', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForIssueComment('joomla', 'joomla-cms', 5)
        );
    }

    /**
     * Tests the getListForIssueComment method - failure.
     *
     * @return  void
     */
    public function testGetListForIssueCommentFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/issues/comments/5/reactions', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getListForIssueComment('joomla', 'joomla-cms', 5);
    }

    /**
     * Tests the createForIssueComment method.
     *
     * @return  void
     */
    public function testCreateForIssueComment()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/issues/comments/5/reactions', '{"content":"heart"}', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createForIssueComment('joomla', 'joomla-cms', 5, 'heart')
        );
    }

    /**
     * Tests the createForIssueComment method - failure.
     *
     * @return  void
     */
    public function testCreateForIssueCommentFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/issues/comments/5/reactions', '{"content":"heart"}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->createForIssueComment('joomla', 'joomla-cms', 5, 'heart');
    }

    /**
     * Tests the deleteForIssueComment method.
     *
     * @return  void
     */
    public function testDeleteForIssueComment()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/issues/comments/5/reactions/7', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteForIssueComment('joomla', 'joomla-cms', 5, 7));
    }

    /**
     * Tests the deleteForIssueComment method - failure.
     *
     * @return  void
     */
    public function testDeleteForIssueCommentFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/issues/comments/5/reactions/7', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->deleteForIssueComment('joomla', 'joomla-cms', 5, 7);
    }

    /**
     * Tests the getListForIssue method.
     *
     * @return  void
     */
    public function testGetListForIssue()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/issues/5/reactions?page=2&per_page=10&content=heart', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForIssue('joomla', 'joomla-cms', 5, ['content' => 'heart'], 2, 10)
        );
    }

    /**
     * Tests the getListForIssue method - failure.
     *
     * @return  void
     */
    public function testGetListForIssueFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/issues/5/reactions', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getListForIssue('joomla', 'joomla-cms', 5);
    }

    /**
     * Tests the createForIssue method.
     *
     * @return  void
     */
    public function testCreateForIssue()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/issues/5/reactions', '{"content":"heart"}', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createForIssue('joomla', 'joomla-cms', 5, 'heart')
        );
    }

    /**
     * Tests the createForIssue method - failure.
     *
     * @return  void
     */
    public function testCreateForIssueFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/issues/5/reactions', '{"content":"heart"}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->createForIssue('joomla', 'joomla-cms', 5, 'heart');
    }

    /**
     * Tests the deleteForIssue method.
     *
     * @return  void
     */
    public function testDeleteForIssue()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/issues/5/reactions/7', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteForIssue('joomla', 'joomla-cms', 5, 7));
    }

    /**
     * Tests the deleteForIssue method - failure.
     *
     * @return  void
     */
    public function testDeleteForIssueFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/issues/5/reactions/7', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->deleteForIssue('joomla', 'joomla-cms', 5, 7);
    }

    /**
     * Tests the getListForPullRequestReviewComment method.
     *
     * @return  void
     */
    public function testGetListForPullRequestReviewComment()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/pulls/comments/5/reactions', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForPullRequestReviewComment('joomla', 'joomla-cms', 5)
        );
    }

    /**
     * Tests the getListForPullRequestReviewComment method - failure.
     *
     * @return  void
     */
    public function testGetListForPullRequestReviewCommentFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/pulls/comments/5/reactions', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getListForPullRequestReviewComment('joomla', 'joomla-cms', 5);
    }

    /**
     * Tests the createForPullRequestReviewComment method.
     *
     * @return  void
     */
    public function testCreateForPullRequestReviewComment()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/pulls/comments/5/reactions', '{"content":"heart"}', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createForPullRequestReviewComment('joomla', 'joomla-cms', 5, 'heart')
        );
    }

    /**
     * Tests the createForPullRequestReviewComment method - failure.
     *
     * @return  void
     */
    public function testCreateForPullRequestReviewCommentFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/pulls/comments/5/reactions', '{"content":"heart"}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->createForPullRequestReviewComment('joomla', 'joomla-cms', 5, 'heart');
    }

    /**
     * Tests the deleteForPullRequestReviewComment method.
     *
     * @return  void
     */
    public function testDeleteForPullRequestReviewComment()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/pulls/comments/5/reactions/7', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteForPullRequestReviewComment('joomla', 'joomla-cms', 5, 7));
    }

    /**
     * Tests the deleteForPullRequestReviewComment method - failure.
     *
     * @return  void
     */
    public function testDeleteForPullRequestReviewCommentFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/pulls/comments/5/reactions/7', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->deleteForPullRequestReviewComment('joomla', 'joomla-cms', 5, 7);
    }

    /**
     * Tests the getListForRelease method.
     *
     * @return  void
     */
    public function testGetListForRelease()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/releases/5/reactions?page=2&per_page=10&content=heart', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForRelease('joomla', 'joomla-cms', 5, ['content' => 'heart'], 2, 10)
        );
    }

    /**
     * Tests the getListForRelease method - failure.
     *
     * @return  void
     */
    public function testGetListForReleaseFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/releases/5/reactions', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getListForRelease('joomla', 'joomla-cms', 5);
    }

    /**
     * Tests the createForRelease method.
     *
     * @return  void
     */
    public function testCreateForRelease()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/releases/5/reactions', '{"content":"heart"}', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createForRelease('joomla', 'joomla-cms', 5, 'heart')
        );
    }

    /**
     * Tests the createForRelease method - failure.
     *
     * @return  void
     */
    public function testCreateForReleaseFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-cms/releases/5/reactions', '{"content":"heart"}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->createForRelease('joomla', 'joomla-cms', 5, 'heart');
    }

    /**
     * Tests the deleteForRelease method.
     *
     * @return  void
     */
    public function testDeleteForRelease()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/releases/5/reactions/7', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteForRelease('joomla', 'joomla-cms', 5, 7));
    }

    /**
     * Tests the deleteForRelease method - failure.
     *
     * @return  void
     */
    public function testDeleteForReleaseFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms/releases/5/reactions/7', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->deleteForRelease('joomla', 'joomla-cms', 5, 7);
    }
}
