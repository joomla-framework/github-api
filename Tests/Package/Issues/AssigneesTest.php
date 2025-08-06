<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Issues;

use Joomla\Github\Package\Issues\Assignees;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for the GitHub API package.
 *
 * @since  1.0
 */
class AssigneesTest extends GitHubTestCase
{
    /**
     * @var    Assignees  Object under test.
     * @since  1.0
     */
    protected $object;

    /**
     * @var string
     * @since  1.0
     */
    protected $owner = 'joomla';

    /**
     * @var string
     * @since  1.0
     */
    protected $repo = 'joomla-framework';

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

        $this->object = new Assignees($this->options, $this->client);
    }

    /**
     * Tests the getList method
     *
     * @return void
     */
    public function testGetList()
    {
        $body = '[
	{
	"login": "octocat",
	"id": 1,
	"avatar_url": "https://github.com/images/error/octocat_happy.gif",
	"gravatar_id": "somehexcode",
	"url": "https://api.github.com/users/octocat"
	}
	]';
        $this->response = $this->getResponseObject($body);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/' . $this->owner . '/' . $this->repo . '/assignees', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->getList($this->owner, $this->repo)
        );
    }

    /**
     * Tests the getList method
     * Response:
     * If the given assignee login belongs to an assignee for the repository,
     * a 204 header with no content is returned.
     * Otherwise a 404 status code is returned.
     *
     * @return void
     */
    public function testCheck()
    {
        $this->response = $this->getResponseObject('', 204);

        $assignee = 'elkuku';

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/' . $this->owner . '/' . $this->repo . '/assignees/' . $assignee, [], 0)
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->check($this->owner, $this->repo, $assignee),
            $this->equalTo(true)
        );
    }

    /**
     * Tests the getList method with a negative response
     * Response:
     * If the given assignee login belongs to an assignee for the repository,
     * a 204 header with no content is returned.
     * Otherwise a 404 status code is returned.
     *
     * @return void
     */
    public function testCheckNo()
    {
        $this->response = $this->getResponseObject('', 404);

        $assignee = 'elkuku';

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/' . $this->owner . '/' . $this->repo . '/assignees/' . $assignee, [], 0)
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->check($this->owner, $this->repo, $assignee),
            $this->equalTo(false)
        );
    }

    /**
     * Tests the getList method with a negative response
     * Response:
     * If the given assignee login belongs to an assignee for the repository,
     * a 204 header with no content is returned.
     * Otherwise a 404 status code is returned.
     *
     * @return void
     */
    public function testCheckException()
    {
        $this->expectException(\Laminas\Diactoros\Exception\InvalidArgumentException::class);

        $this->response = $this->getResponseObject(false, 666);

        $assignee = 'elkuku';

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/' . $this->owner . '/' . $this->repo . '/assignees/' . $assignee, [], 0)
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->check($this->owner, $this->repo, $assignee),
            $this->equalTo(false)
        );
    }

    /**
     * Tests the add method
     *
     * @return void
     */
    public function testAdd()
    {
        $body = '[
	{
	"login": "octocat",
	"id": 1,
	"avatar_url": "https://github.com/images/error/octocat_happy.gif",
	"gravatar_id": "somehexcode",
	"url": "https://api.github.com/users/octocat"
	}
	]';
        $this->response = $this->getResponseObject($body, 201);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/' . $this->owner . '/' . $this->repo . '/issues/123/assignees', json_encode(['assignees' => ['joomla']]))
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->add($this->owner, $this->repo, 123, ['joomla'])
        );
    }

    /**
     * Tests the remove method
     *
     * @return void
     */
    public function testRemove()
    {
        $body = '[
	{
	"login": "octocat",
	"id": 1,
	"avatar_url": "https://github.com/images/error/octocat_happy.gif",
	"gravatar_id": "somehexcode",
	"url": "https://api.github.com/users/octocat"
	}
	]';
        $this->response = $this->getResponseObject($body);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/' . $this->owner . '/' . $this->repo . '/issues/123/assignees', [], null, json_encode(['assignees' => ['joomla']]))
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->remove($this->owner, $this->repo, 123, ['joomla'])
        );
    }
}
