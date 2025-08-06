<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Activity;

use Joomla\Github\Package\Activity\Starring;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class.
 *
 * @covers \Joomla\Github\Package\Activity\Starring
 *
 * @since  1.0
 */
class StarringTest extends GitHubTestCase
{
    /**
     * @var    Starring  Object under test.
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

        $this->object = new Starring($this->options, $this->client);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Activity\Starring::getList()
     *
     * @return  void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/stargazers', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->getList('joomla', 'joomla-platform')
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Activity\Starring::getRepositories()
     *
     * @return  void
     */
    public function testGetRepositories()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/starred?sort=created&direction=desc', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->getRepositories()
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Activity\Starring::getRepositories()
     *
     * @return  void
     */
    public function testGetRepositoriesWithName()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/{user}/starred?sort=created&direction=desc', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->getRepositories('{user}')
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Activity\Starring::getRepositories()
     *
     * Invalid sort option
     *
     * @return  void
     */
    public function testGetRepositoriesInvalidSort()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->object->getRepositories('', 'invalid');
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Activity\Starring::getRepositories()
     *
     * Invalid direction option
     *
     * @return  void
     */
    public function testGetRepositoriesInvalidDirection()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->object->getRepositories('', 'created', 'invalid');
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Activity\Starring::check()
     *
     * @return  void
     */
    public function testCheck()
    {
        $this->response = $this->getResponseObject(true, 204);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/starred/joomla/joomla-platform', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->check('joomla', 'joomla-platform')
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Activity\Starring::check()
     *
     * @return  void
     */
    public function testCheckFalse()
    {
        $this->response = $this->getResponseObject(false, 404);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/starred/joomla/joomla-platform', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->check('joomla', 'joomla-platform')
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Activity\Starring::check()
     *
     * @return  void
     */
    public function testCheckUnexpected()
    {
        $this->expectException(\Laminas\Diactoros\Exception\InvalidArgumentException::class);

        $this->response = $this->getResponseObject(false, 666);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/starred/joomla/joomla-platform', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->check('joomla', 'joomla-platform')
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Activity\Starring::star()
     *
     * @return  void
     */
    public function testStar()
    {
        $this->response = $this->getResponseObject($this->sampleString, 204);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/user/starred/joomla/joomla-platform', '', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->star('joomla', 'joomla-platform')
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Activity\Starring::unstar()
     *
     * @return  void
     */
    public function testUnstar()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/starred/joomla/joomla-platform', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->unstar('joomla', 'joomla-platform')
        );
    }
}
