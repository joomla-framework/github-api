<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Pulls;

use Joomla\Github\Package\Pulls\Comments;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class.
 *
 * @covers \Joomla\Github\Package\Pulls\Comments
 *
 * @since  1.0
 */
class CommentsTest extends GitHubTestCase
{
    /**
     * @var Comments
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

        $this->object = new Comments($this->options, $this->client);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Pulls\Comments::create()
     *
     * @return  void
     */
    public function testCreate()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);
        $data                 = '{"body":"The Body","commit_id":"123abc","path":"a\/b\/c","position":456}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/pulls/1/comments', $data, [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->create('joomla', 'joomla-platform', 1, 'The Body', '123abc', 'a/b/c', 456)
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Pulls\Comments::createReply()
     *
     * @return  void
     */
    public function testCreateReply()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/pulls/1/comments', '{"body":"The Body","in_reply_to":456}', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->createReply('joomla', 'joomla-platform', 1, 'The Body', 456)
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Pulls\Comments::delete()
     *
     * @return  void
     */
    public function testDelete()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/pulls/comments/456', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->delete('joomla', 'joomla-platform', 456)
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Pulls\Comments::edit()
     *
     * @return  void
     */
    public function testEdit()
    {
        $this->response = $this->getResponseObject('');

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/pulls/comments/456', '{"body":"Hello"}', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->edit('joomla', 'joomla-platform', 456, 'Hello')
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Pulls\Comments::get()
     *
     * @return  void
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/pulls/comments/456', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->get('joomla', 'joomla-platform', 456)
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Pulls\Comments::getList()
     *
     * @return  void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/pulls/456/comments', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->getList('joomla', 'joomla-platform', 456)
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Pulls\Comments::getListForRepo()
     *
     * @return  void
     */
    public function testGetListForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/{user}/{repo}/pulls/comments', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->getListForRepo('{user}', '{repo}')
        );
    }
}
