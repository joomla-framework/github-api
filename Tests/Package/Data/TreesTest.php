<?php
/**
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Data\Trees;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for the GitHub API package.
 *
 * @since  1.0
 */
class TreesTest extends GitHubTestCase
{
	/**
	 * @var    Trees  Object under test.
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

		$this->object = new Trees($this->options, $this->client);
	}

	/**
	 * Tests the get method
	 *
	 * @return  void
	 */
	public function testGet()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/git/trees/12345', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->get('joomla', 'joomla-platform', '12345'),
			$this->equalTo(json_decode($this->response->body))
		);
	}

	/**
	 * Tests the getRecursively method
	 *
	 * @return  void
	 */
	public function testGetRecursively()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/git/trees/12345?recursive=1', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getRecursively('joomla', 'joomla-platform', '12345'),
			$this->equalTo(json_decode($this->response->body))
		);
	}

	/**
	 * Tests the create method
	 *
	 * @return  void
	 */
	public function testCreate()
	{
		$this->response->code = 201;

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/joomla/joomla-platform/git/trees', '{"tree":"12345","base_tree":"678"}', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->create('joomla', 'joomla-platform', '12345', '678'),
			$this->equalTo(json_decode($this->response->body))
		);
	}
}
