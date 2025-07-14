<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Activity\Watching;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for the GitHub API package.
 *
 * @since  1.0
 */
class WatchingTest extends GitHubTestCase
{
    /**
     * @var    Watching  Object under test.
     * @since  1.0
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

        $this->object = new Watching($this->options, $this->client);
    }

    /**
     * Tests the getList method
     *
     * @return  void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/subscribers', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getList('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the getRepositories method
     *
     * @return  void
     */
    public function testGetRepositories()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/subscriptions', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getRepositories()
        );
    }

    /**
     * Tests the getRepositoriesUser method
     *
     * @return  void
     */
    public function testGetRepositoriesUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/joomla/subscriptions', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getRepositories('joomla')
        );
    }

    /**
     * Tests the getSubscription method
     *
     * @return  void
     */
    public function testGetSubscription()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/subscription', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getSubscription('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the setSubscription method
     *
     * @return  void
     */
    public function testSetSubscription()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/subscription', '{"subscribed":true,"ignored":false}', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->setSubscription('joomla', 'joomla-platform', true, false)
        );
    }

    /**
     * Tests the deleteSubscription method
     *
     * @return  void
     */
    public function testDeleteSubscription()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/subscription', [], 0)
            ->willReturn($this->response);

        $response = $this->response->getBody()->getContents();
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->deleteSubscription('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the check method
     *
     * @return  void
     */
    public function testCheck()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/subscriptions/joomla/joomla-platform', [], 0)
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->check('joomla', 'joomla-platform'),
            $this->equalTo(true)
        );
    }

    /**
     * Tests the checkFalse method
     *
     * @return  void
     */
    public function testCheckFalse()
    {
        $this->response = $this->getResponseObject('', 404);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/subscriptions/joomla/joomla-platform', [], 0)
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->check('joomla', 'joomla-platform'),
            $this->equalTo(false)
        );
    }

    /**
     * Tests the checkUnexpected method
     *
     * @return  void
     */
    public function testCheckUnexpected()
    {
        $this->expectException(\Laminas\Diactoros\Exception\InvalidArgumentException::class);

        $this->response = $this->getResponseObject(false, 666);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/subscriptions/joomla/joomla-platform', [], 0)
            ->willReturn($this->response);

        $this->object->check('joomla', 'joomla-platform');
    }

    /**
     * Tests the watch method
     *
     * @return  void
     */
    public function testWatch()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/user/subscriptions/joomla/joomla-platform', '', [], 0)
            ->willReturn($this->response);

        $response = $this->response->getBody()->getContents();
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->watch('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the unwatch method
     *
     * @return  void
     */
    public function testUnwatch()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/subscriptions/joomla/joomla-platform', [], 0)
            ->willReturn($this->response);

        $response = $this->response->getBody()->getContents();
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->unwatch('joomla', 'joomla-platform')
        );
    }
}
