<?php
/**
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Activity\Notifications;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class.
 *
 * @covers \Joomla\Github\Package\Activity\Notifications
 *
 * @since  1.0
 */
class NotificationsTest extends GitHubTestCase
{
	/**
	 * @var    Notifications  Object under test.
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
	protected function setUp()
	{
		parent::setUp();

		$this->object = new Notifications($this->options, $this->client);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Activity\Notifications::getList()
	 *
	 * @return  void
	 */
	public function testGetList()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/notifications?all=1&participating=1&since=2005-08-17T00:00:00+00:00&before=2005-08-17T00:00:00+00:00', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList(true, true, new \DateTime('2005-8-17'), new  \DateTime('2005-8-17')),
			$this->equalTo(json_decode($this->response->body))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Activity\Notifications::getListRepository()
	 *
	 * @return  void
	 */
	public function testGetListRepository()
	{
		$args = 'all=1&participating=1&since=2005-08-17T00:00:00+00:00&before=2005-08-17T00:00:00+00:00';

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/{owner}/{repo}/notifications?' . $args, array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getListRepository('{owner}', '{repo}', true, true, new \DateTime('2005-8-17'), new  \DateTime('2005-8-17')),
			$this->equalTo(json_decode($this->response->body))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Activity\Notifications::markRead()
	 *
	 * @return  void
	 */
	public function testMarkRead()
	{
		$this->response->code = 205;
		$this->response->body = '';

		$this->client->expects($this->once())
			->method('put')
			->with('/notifications', '{"unread":true,"read":true}', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->markRead(),
			$this->equalTo($this->response->body)
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Activity\Notifications::markRead()
	 *
	 * @return  void
	 */
	public function testMarkReadLastRead()
	{
		$this->response->code = 205;
		$this->response->body = '';

		$date = new \DateTime('1966-09-14', new \DateTimeZone('UTC'));
		$data = '{"unread":true,"read":true,"last_read_at":"1966-09-14T00:00:00+00:00"}';

		$this->client->expects($this->once())
			->method('put')
			->with('/notifications', $data, array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->markRead(true, true, $date),
			$this->equalTo($this->response->body)
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Activity\Notifications::markReadRepository()
	 *
	 * @return  void
	 */
	public function testMarkReadRepository()
	{
		$this->response->code = 205;
		$this->response->body = '';

		$data = '{"unread":true,"read":true}';

		$this->client->expects($this->once())
			->method('put')
			->with('/repos/joomla/joomla-platform/notifications', $data, array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->markReadRepository('joomla', 'joomla-platform', true, true),
			$this->equalTo($this->response->body)
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Activity\Notifications::markReadRepository()
	 *
	 * @return  void
	 */
	public function testMarkReadRepositoryLastRead()
	{
		$this->response->code = 205;
		$this->response->body = '';

		$date = new \DateTime('1966-09-14', new \DateTimeZone('UTC'));
		$data = '{"unread":true,"read":true,"last_read_at":"1966-09-14T00:00:00+00:00"}';

		$this->client->expects($this->once())
			->method('put')
			->with('/repos/joomla/joomla-platform/notifications', $data, array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->markReadRepository('joomla', 'joomla-platform', true, true, $date),
			$this->equalTo($this->response->body)
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Activity\Notifications::viewThread()
	 *
	 * @return  void
	 */
	public function testViewThread()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/notifications/threads/1', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->viewThread(1),
			$this->equalTo(json_decode($this->response->body))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Activity\Notifications::markReadThread()
	 *
	 * @return  void
	 */
	public function testMarkReadThread()
	{
		$this->response->code = 205;

		$this->client->expects($this->once())
			->method('patch')
			->with('/notifications/threads/1', '{"unread":true,"read":true}', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->markReadThread(1),
			$this->equalTo(json_decode($this->response->body))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Activity\Notifications::getThreadSubscription()
	 *
	 * @return  void
	 */
	public function testGetThreadSubscription()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/notifications/threads/1/subscription', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getThreadSubscription(1),
			$this->equalTo(json_decode($this->response->body))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Activity\Notifications::setThreadSubscription()
	 *
	 * @return  void
	 */
	public function testSetThreadSubscription()
	{
		$this->client->expects($this->once())
			->method('put')
			->with('/notifications/threads/1/subscription', '{"subscribed":true,"ignored":false}', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->setThreadSubscription(1, true, false),
			$this->equalTo(json_decode($this->response->body))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Activity\Notifications::deleteThreadSubscription()
	 *
	 * @return  void
	 */
	public function testDeleteThreadSubscription()
	{
		$this->response->code = 204;
		$this->response->body = '';

		$this->client->expects($this->once())
			->method('delete')
			->with('/notifications/threads/1/subscription', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->deleteThreadSubscription(1),
			$this->equalTo(json_decode($this->response->body))
		);
	}
}
