<?php
/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

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
			->with('/repos/joomla/joomla-platform/stargazers', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList('joomla', 'joomla-platform'),
			$this->equalTo(json_decode($this->response->body))
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
			->with('/user/starred?sort=created&direction=desc', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getRepositories(),
			$this->equalTo(json_decode($this->response->body))
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
			->with('/users/{user}/starred?sort=created&direction=desc', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getRepositories('{user}'),
			$this->equalTo(json_decode($this->response->body))
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
		$this->response->code = 204;
		$this->response->body = true;

		$this->client->expects($this->once())
			->method('get')
			->with('/user/starred/joomla/joomla-platform', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->check('joomla', 'joomla-platform'),
			$this->equalTo(json_decode($this->response->body))
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
		$this->response->code = 404;
		$this->response->body = false;

		$this->client->expects($this->once())
			->method('get')
			->with('/user/starred/joomla/joomla-platform', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->check('joomla', 'joomla-platform'),
			$this->equalTo(json_decode($this->response->body))
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
		$this->expectException(\UnexpectedValueException::class);

		$this->response->code = 666;
		$this->response->body = false;

		$this->client->expects($this->once())
			->method('get')
			->with('/user/starred/joomla/joomla-platform', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->check('joomla', 'joomla-platform'),
			$this->equalTo(json_decode($this->response->body))
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
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('put')
			->with('/user/starred/joomla/joomla-platform', '', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->star('joomla', 'joomla-platform'),
			$this->equalTo(json_decode($this->response->body))
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
		$this->response->code = 204;
		$this->response->body = '';

		$this->client->expects($this->once())
			->method('delete')
			->with('/user/starred/joomla/joomla-platform', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->unstar('joomla', 'joomla-platform'),
			$this->equalTo(json_decode($this->response->body))
		);
	}
}
