<?php
/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Users\Followers;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class.
 *
 * @covers \Joomla\Github\Package\Users\Followers
 *
 * @since  1.0
 */
class FollowersTest extends GitHubTestCase
{
    /**
     * @var Followers
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

        $this->object = new Followers($this->options, $this->client);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Users\Followers::getList()
     *
     * @return  void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/followers')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->getList(),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Users\Followers::getList()
     *
     * @return  void
     */
    public function testGetListWithUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/joomla/followers')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->getList('joomla'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Users\Followers::getListFollowedBy()
     *
     * @return  void
     */
    public function testGetListFollowedBy()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/following')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->getListFollowedBy(),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Users\Followers::getListFollowedBy()
     *
     * @return  void
     */
    public function testGetListFollowedByWithUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/joomla/following')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->getListFollowedBy('joomla'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Users\Followers::check()
     *
     * You are following this user
     *
     * @return  void
     */
    public function testCheck()
    {
        $this->response = $this->getResponseObject(true, 204);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/following/joomla')
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->check('joomla')
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Users\Followers::check()
     *
     * You are not following this user
     *
     * @return  void
     */
    public function testCheckNo()
    {
        $this->response = $this->getResponseObject(false, 404);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/following/joomla')
            ->willReturn($this->response);

        $response = (string) $this->response->getBody();

        $this->assertEquals(
            $response,
            $this->object->check('joomla')
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Users\Followers::check()
     *
     * @return  void
     */
    public function testCheckUnexpected()
    {
        $this->expectException(\Laminas\Diactoros\Exception\InvalidArgumentException::class);

        $this->response = $this->getResponseObject(false, 666);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/following/joomla')
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->check('joomla')
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Users\Followers::follow()
     *
     * @return  void
     */
    public function testFollow()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/user/following/joomla')
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->follow('joomla')
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Users\Followers::unfollow()
     *
     * @return  void
     */
    public function testUnfollow()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/following/joomla')
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->unfollow('joomla')
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Users\Followers::checkUserFollowing()
     *
     * User is following the target
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testCheckUserFollowing()
    {
        $this->response = $this->getResponseObject($this->sampleString, 204);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/{user}/following/{target}')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->checkUserFollowing('{user}', '{target}'),
            $this->equalTo(true)
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Users\Followers::checkUserFollowing()
     *
     * User is not following the target
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testCheckUserFollowingNot()
    {
        $this->response = $this->getResponseObject($this->sampleString, 404);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/{user}/following/{target}')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->checkUserFollowing('{user}', '{target}'),
            $this->equalTo(false)
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Users\Followers::checkUserFollowing()
     *
     * // Unexpected response
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testCheckUserFollowingUnexpected()
    {
        $this->expectException(\Laminas\Diactoros\Exception\InvalidArgumentException::class);

        $this->response = $this->getResponseObject($this->sampleString, 666);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/{user}/following/{target}')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->checkUserFollowing('{user}', '{target}'),
            $this->equalTo(true)
        );
    }
}
