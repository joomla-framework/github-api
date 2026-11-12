<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Pulls;

use Joomla\Github\Package\Pulls\Reviews;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Pulls\Reviews.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Reviews::class)]
class ReviewsTest extends GitHubTestCase
{
    /**
     * @var    Reviews  Object under test.
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

        $this->object = new Reviews($this->options, $this->client);
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
            ->with('/repos/joomla/joomla-platform/pulls/1/reviews?page=2&per_page=30', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getList('joomla', 'joomla-platform', 1, 2, 30)
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
            ->with('/repos/joomla/joomla-platform/pulls/1/reviews', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getList('joomla', 'joomla-platform', 1);
    }

    /**
     * Tests the create method.
     *
     * @return  void
     */
    public function testCreate()
    {
        $body = '{"body":"Looks good","event":"APPROVE"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/pulls/1/reviews', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->create('joomla', 'joomla-platform', 1, ['body' => 'Looks good', 'event' => 'APPROVE'])
        );
    }

    /**
     * Tests the create method without options (sends an empty JSON object).
     *
     * @return  void
     */
    public function testCreateEmpty()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/pulls/1/reviews', '{}', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->create('joomla', 'joomla-platform', 1)
        );
    }

    /**
     * Tests the create method - failure.
     *
     * @return  void
     */
    public function testCreateFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/pulls/1/reviews', '{}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->create('joomla', 'joomla-platform', 1);
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
            ->with('/repos/joomla/joomla-platform/pulls/1/reviews/42', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->get('joomla', 'joomla-platform', 1, 42)
        );
    }

    /**
     * Tests the get method - failure.
     *
     * @return  void
     */
    public function testGetFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/pulls/1/reviews/42', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->get('joomla', 'joomla-platform', 1, 42);
    }

    /**
     * Tests the edit method.
     *
     * @return  void
     */
    public function testEdit()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/pulls/1/reviews/42', '{"body":"New text"}', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->edit('joomla', 'joomla-platform', 1, 42, 'New text')
        );
    }

    /**
     * Tests the edit method - failure.
     *
     * @return  void
     */
    public function testEditFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/pulls/1/reviews/42', '{"body":"New text"}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->edit('joomla', 'joomla-platform', 1, 42, 'New text');
    }

    /**
     * Tests the delete method.
     *
     * @return  void
     */
    public function testDelete()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/pulls/1/reviews/42', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->delete('joomla', 'joomla-platform', 1, 42)
        );
    }

    /**
     * Tests the delete method - failure.
     *
     * @return  void
     */
    public function testDeleteFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/pulls/1/reviews/42', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->delete('joomla', 'joomla-platform', 1, 42);
    }

    /**
     * Tests the getListComments method.
     *
     * @return  void
     */
    public function testGetListComments()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/pulls/1/reviews/42/comments?page=3&per_page=10', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListComments('joomla', 'joomla-platform', 1, 42, 3, 10)
        );
    }

    /**
     * Tests the getListComments method - failure.
     *
     * @return  void
     */
    public function testGetListCommentsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/pulls/1/reviews/42/comments', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getListComments('joomla', 'joomla-platform', 1, 42);
    }

    /**
     * Tests the dismiss method.
     *
     * @return  void
     */
    public function testDismiss()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with(
                '/repos/joomla/joomla-platform/pulls/1/reviews/42/dismissals',
                '{"event":"DISMISS","message":"Outdated"}',
                [],
                0
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->dismiss('joomla', 'joomla-platform', 1, 42, 'Outdated', ['event' => 'DISMISS'])
        );
    }

    /**
     * Tests the dismiss method - failure.
     *
     * @return  void
     */
    public function testDismissFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/pulls/1/reviews/42/dismissals', '{"message":"Outdated"}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->dismiss('joomla', 'joomla-platform', 1, 42, 'Outdated');
    }

    /**
     * Tests the submit method.
     *
     * @return  void
     */
    public function testSubmit()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with(
                '/repos/joomla/joomla-platform/pulls/1/reviews/42/events',
                '{"body":"Done","event":"COMMENT"}',
                [],
                0
            )
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->submit('joomla', 'joomla-platform', 1, 42, 'COMMENT', ['body' => 'Done'])
        );
    }

    /**
     * Tests the submit method - failure.
     *
     * @return  void
     */
    public function testSubmitFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/pulls/1/reviews/42/events', '{"event":"APPROVE"}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->submit('joomla', 'joomla-platform', 1, 42, 'APPROVE');
    }
}
