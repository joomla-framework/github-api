<?php
/**
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Activity\Feeds;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for the GitHub API package.
 *
 * @since  1.4.0
 */
class FeedsTest extends GitHubTestCase
{
	/**
	 * @var    Feeds  Object under test.
	 * @since  1.4.0
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @since   1.4.0
	 *
	 * @return  void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->object = new Feeds($this->options, $this->client);
	}

	/**
	 * Tests the getFeeds method
	 *
	 * @return  void
	 */
	public function testGetFeeds()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/feeds')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getFeeds(),
			$this->equalTo(json_decode($this->response->body))
		);
	}
}
