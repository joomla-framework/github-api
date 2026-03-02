<?php
/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Repositories\Statuses;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class.
 *
 * @covers \Joomla\Github\Package\Repositories\Statuses
 *
 * @since  1.0
 */
class StatusesTest extends GitHubTestCase
{
	/**
	 * @var    Statuses  Object under test.
	 * @since  11.4
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 *
	 * @return void
	 */
	protected function setUp(): void
	{
		parent::setUp();

		$this->object = new Statuses($this->options, $this->client);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Repositories\Statuses::create()
	 *
	 * @return void
	 */
	public function testCreate()
	{
		$this->response->code = 201;

		// Build the request data.
		$data = json_encode(
			array(
				'state' => 'success',
				'target_url' => 'http://example.com/my_url',
				'description' => 'Success is the only option - failure is not.',
				'context' => 'Joomla/Test'
			)
		);

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/joomla/joomla-platform/statuses/6dcb09b5b57875f334f61aebed695e2e4193db5e', $data)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->create(
				'joomla',
				'joomla-platform',
				'6dcb09b5b57875f334f61aebed695e2e4193db5e',
				'success',
				'http://example.com/my_url',
				'Success is the only option - failure is not.',
				'Joomla/Test'
			),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Repositories\Statuses::create()
	 *
	 * Failure
	 *
	 * @return void
	 */
	public function testCreateFailure()
	{
		$this->expectException(\DomainException::class);

		$this->response->code = 501;
		$this->response->body = $this->errorString;

		// Build the request data.
		$data = json_encode(
			array(
				'state' => 'pending'
			)
		);

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/joomla/joomla-platform/statuses/6dcb09b5b57875f334f61aebed695e2e4193db5e', $data)
			->will($this->returnValue($this->response));

		$this->object->create('joomla', 'joomla-platform', '6dcb09b5b57875f334f61aebed695e2e4193db5e', 'pending');
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Repositories\Statuses::create()
	 *
	 * Failure
	 *
	 * @return void
	 */
	public function testCreateInvalidState()
	{
		$this->expectException(\InvalidArgumentException::class);

		$this->response->code = 501;
		$this->response->body = $this->errorString;

		$this->object->create('joomla', 'joomla-platform', '6dcb09b5b57875f334f61aebed695e2e4193db5e', 'INVALID');
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Repositories\Statuses::getList()
	 *
	 * @return void
	 */
	public function testGetList()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/statuses/6dcb09b5b57875f334f61aebed695e2e4193db5e')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList('joomla', 'joomla-platform', '6dcb09b5b57875f334f61aebed695e2e4193db5e'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Repositories\Statuses::getList()
	 *
	 * Failure
	 *
	 * @return void
	 */
	public function testGetListFailure()
	{
		$this->expectException(\DomainException::class);

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/statuses/6dcb09b5b57875f334f61aebed695e2e4193db5e')
			->will($this->returnValue($this->response));

		$this->object->getList('joomla', 'joomla-platform', '6dcb09b5b57875f334f61aebed695e2e4193db5e');
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Repositories\Statuses::getCombinedStatus()
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetCombinedStatus()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/repos/{user}/{repo}/commits/{sha}/status')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getCombinedStatus('{user}', '{repo}', '{sha}'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}
}
