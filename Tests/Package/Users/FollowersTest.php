<?php
/**
 * @copyright  Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
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
			->will($this->returnValue($this->response));

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
			->will($this->returnValue($this->response));

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
			->will($this->returnValue($this->response));

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
			->will($this->returnValue($this->response));

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
		$this->response->code = 204;
		$this->response->body = true;

		$this->client->expects($this->once())
			->method('get')
			->with('/user/following/joomla')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->check('joomla'),
			$this->equalTo($this->response->body)
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
		$this->response->code = 404;
		$this->response->body = false;

		$this->client->expects($this->once())
			->method('get')
			->with('/user/following/joomla')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->check('joomla'),
			$this->equalTo($this->response->body)
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
		$this->expectException(\UnexpectedValueException::class);

		$this->response->code = 666;
		$this->response->body = false;

		$this->client->expects($this->once())
			->method('get')
			->with('/user/following/joomla')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->check('joomla'),
			$this->equalTo($this->response->body)
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
		$this->response->code = 204;
		$this->response->body = '';

		$this->client->expects($this->once())
			->method('put')
			->with('/user/following/joomla')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->follow('joomla'),
			$this->equalTo($this->response->body)
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
		$this->response->code = 204;
		$this->response->body = '';

		$this->client->expects($this->once())
			->method('delete')
			->with('/user/following/joomla')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->unfollow('joomla'),
			$this->equalTo($this->response->body)
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
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('get')
			->with('/user/{user}/following/{target}')
			->will($this->returnValue($this->response));

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
		$this->response->code = 404;

		$this->client->expects($this->once())
			->method('get')
			->with('/user/{user}/following/{target}')
			->will($this->returnValue($this->response));

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
		$this->expectException(\UnexpectedValueException::class);
		$this->expectExceptionMessage('Unexpected response code: 666');

		$this->response->code = 666;

		$this->client->expects($this->once())
			->method('get')
			->with('/user/{user}/following/{target}')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->checkUserFollowing('{user}', '{target}'),
			$this->equalTo(true)
		);
	}
}
