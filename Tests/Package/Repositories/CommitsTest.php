<?php
/**
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Repositories\Commits;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class.
 *
 * @covers \Joomla\Github\Package\Repositories\Commits
 *
 * @since  1.0
 */
class CommitsTest extends GitHubTestCase
{
	/**
	 * @var    Commits  Object under test.
	 * @since  12.1
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->object = new Commits($this->options, $this->client);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Repositories\Commits::get()
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGet()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/commits/abc1234')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->get('joomla', 'joomla-platform', 'abc1234'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Repositories\Commits::get()
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @expectedException  \DomainException
	 * @expectedExceptionMessage Generic Error
	 */
	public function testGetFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/commits/abc1234')
			->will($this->returnValue($this->response));

		$this->object->get('joomla', 'joomla-platform', 'abc1234');
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Repositories\Commits::getList()
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetList()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/commits')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList('joomla', 'joomla-platform'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Repositories\Commits::getList()
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @expectedException  \DomainException
	 * @expectedExceptionMessage Generic Error
	 */
	public function testGetListFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/commits')
			->will($this->returnValue($this->response));

		$this->object->getList('joomla', 'joomla-platform');
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Repositories\Commits::compare()
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testCompare()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/compare/123abc...456def')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->compare('joomla', 'joomla-platform', '123abc', '456def'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Repositories\Commits::getSha()
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testgetSha()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/{user}/{repo}/commits/{ref}')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getSha('{user}', '{repo}', '{ref}'),
			$this->equalTo($this->sampleString)
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Repositories\Commits::getSha()
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
	 * @expectedExceptionMessage Invalid response received from GitHub.
	 */
	public function testgetShaFailure()
	{
		$this->response->code = 666;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/{user}/{repo}/commits/{ref}')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getSha('{user}', '{repo}', '{ref}'),
			$this->equalTo($this->sampleString)
		);
	}
}
