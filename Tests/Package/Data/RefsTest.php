<?php
/**
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Data\Refs;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for the GitHub API package.
 *
 * @since  1.0
 */
class RefsTest extends GitHubTestCase
{
	/**
	 * @var    Refs  Object under test.
	 * @since  1.0
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
	protected function setUp()
	{
		parent::setUp();

		$this->object = new Refs($this->options, $this->client);
	}

	/**
	 * Tests the get method
	 *
	 * @return void
	 */
	public function testGet()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/git/refs/heads/master')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->get('joomla', 'joomla-platform', 'heads/master'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the get method
	 *
	 * @expectedException \DomainException
	 *
	 * @return void
	 */
	public function testGetFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/git/refs/heads/master')
			->will($this->returnValue($this->response));

		$this->object->get('joomla', 'joomla-platform', 'heads/master');
	}

	/**
	 * Tests the create method
	 *
	 * @return void
	 */
	public function testCreate()
	{
		$this->response->code = 201;

		// Build the request data.
		$data = json_encode(
			array(
				'ref' => '/ref/heads/myhead',
				'sha' => 'This is the sha'
			)
		);

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/joomla/joomla-platform/git/refs', $data)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->create('joomla', 'joomla-platform', '/ref/heads/myhead', 'This is the sha'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the create method - failure
	 *
	 * @expectedException  \DomainException
	 *
	 * @return void
	 */
	public function testCreateFailure()
	{
		$this->response->code = 501;
		$this->response->body = $this->errorString;

		// Build the request data.
		$data = json_encode(
			array(
				'ref' => '/ref/heads/myhead',
				'sha' => 'This is the sha'
			)
		);

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/joomla/joomla-platform/git/refs', $data)
			->will($this->returnValue($this->response));

		$this->object->create('joomla', 'joomla-platform', '/ref/heads/myhead', 'This is the sha');
	}

	/**
	 * Tests the edit method
	 *
	 * @return void
	 */
	public function testEdit()
	{
		// Build the request data.
		$data = json_encode(
			array(
				'force' => true,
				'sha'   => 'This is the sha'
			)
		);

		$this->client->expects($this->once())
			->method('patch')
			->with('/repos/joomla/joomla-platform/git/refs/heads/master', $data)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->edit('joomla', 'joomla-platform', 'heads/master', 'This is the sha', true),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the edit method - failure
	 *
	 * @expectedException  \DomainException
	 *
	 * @return void
	 */
	public function testEditFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		// Build the request data.
		$data = json_encode(
			array(
				'sha' => 'This is the sha'
			)
		);

		$this->client->expects($this->once())
			->method('patch')
			->with('/repos/joomla/joomla-platform/git/refs/heads/master', $data)
			->will($this->returnValue($this->response));

		$this->object->edit('joomla', 'joomla-platform', 'heads/master', 'This is the sha');
	}

	/**
	 * Tests the getList method
	 *
	 * @return void
	 */
	public function testGetList()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/git/refs')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList('joomla', 'joomla-platform'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getList method with a namespace
	 *
	 * @return void
	 */
	public function testGetListWithNamespace()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/git/refs/tags')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList('joomla', 'joomla-platform', 'tags'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getList method - failure
	 *
	 * @expectedException  \DomainException
	 *
	 * @return void
	 */
	public function testGetListFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/git/refs')
			->will($this->returnValue($this->response));

		$this->object->getList('joomla', 'joomla-platform');
	}

	/**
	 * Tests the delete method
	 *
	 * @return void
	 */
	public function testDelete()
	{
		$this->response->code = 204;
		$this->response->body = '';

		$ref = 'refs/heads/sc/featureA';

		$this->client->expects($this->once())
			->method('delete')
			->with('/repos/joomla/joomla-platform/git/refs/' . $ref)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->delete('joomla', 'joomla-platform', $ref),
			$this->equalTo('')
		);
	}

	/**
	 * Tests the delete method - failure
	 *
	 * @expectedException  \DomainException
	 *
	 * @return void
	 */
	public function testDeleteFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$ref = 'refs/heads/sc/featureA';

		$this->client->expects($this->once())
			->method('delete')
			->with('/repos/joomla/joomla-platform/git/refs/' . $ref)
			->will($this->returnValue($this->response));

		$this->object->delete('joomla', 'joomla-platform', $ref);
	}
}
