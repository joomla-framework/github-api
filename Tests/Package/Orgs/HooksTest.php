<?php
/**
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Orgs;

use Joomla\Github\Package\Orgs\Hooks;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class.
 *
 * @covers \Joomla\Github\Package\Orgs\Hooks
 *
 * @since  1.0
 */
class HooksTest extends GitHubTestCase
{
	/**
	 * @var Hooks
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

		$this->object = new Hooks($this->options, $this->client);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Hooks::getList()
	 *
	 * @return  void
	 */
	public function testGetList()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/orgs/joomla/hooks')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList('joomla'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Hooks::get()
	 *
	 * @return  void
	 */
	public function testGet()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/orgs/joomla/hooks/123')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->get('joomla', 123),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Hooks::create()
	 *
	 * @return  void
	 */
	public function testCreate()
	{
		$this->response->code = 201;

		$this->client->expects($this->once())
			->method('post')
			->with('/orgs/joomla/hooks')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->create('joomla', '{url}', 'json', '{secret}'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Hooks::create()
	 *
	 * @return  void
	 */
	public function testCreateFailure()
	{
		$this->expectException(\UnexpectedValueException::class);
		$this->expectExceptionMessage('Content type must be either "form" or "json"');

		$this->object->create('joomla', '{url}', '{invalid}');
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Hooks::create()
	 *
	 * @return  void
	 */
	public function testCreateInvalidEvent()
	{
		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('Your events array contains an unauthorized event.');

		$this->object->create('{org}', '{url}', 'form', null, false, ['{invalid}']);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Hooks::edit()
	 *
	 * @return  void
	 */
	public function testEdit()
	{
		$this->response->code = 201;

		$this->client->expects($this->once())
			->method('post')
			->with('/orgs/{org}/hooks')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->edit('{org}', '{url}', 'json', '{secret}', 1, array('create'), true),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Hooks::edit()
	 *
	 * @return  void
	 */
	public function testEditFailure()
	{
		$this->expectException(\UnexpectedValueException::class);

		$this->object->edit('{org}', '{url}', '{invalid}');
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Hooks::edit()
	 *
	 * @return  void
	 */
	public function testEditFailure2()
	{
		$this->expectException(\RuntimeException::class);

		$this->object->edit('{org}', '{url}', 'json', '{secret}', 1, array('{invalid}'));
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Hooks::ping()
	 *
	 * @return  void
	 */
	public function testPing()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('post')
			->with('/orgs/{org}/hooks/123/pings')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->ping('{org}', 123),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Hooks::delete()
	 *
	 * @return  void
	 */
	public function testDelete()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('delete')
			->with('/orgs/joomla/hooks/123')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->delete('joomla', 123),
			$this->equalTo(json_decode($this->sampleString))
		);
	}
}
