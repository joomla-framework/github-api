<?php
/**
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Pulls;

use Joomla\Github\Package\Pulls\Comments;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class.
 *
 * @covers \Joomla\Github\Package\Pulls\Comments
 *
 * @since  1.0
 */
class CommentsTest extends GitHubTestCase
{
	/**
	 * @var Comments
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

		$this->object = new Comments($this->options, $this->client);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Pulls\Comments::create()
	 *
	 * @return  void
	 */
	public function testCreate()
	{
		$this->response->code = 201;
		$data = '{"body":"The Body","commit_id":"123abc","path":"a\/b\/c","position":456}';

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/joomla/joomla-platform/pulls/1/comments', $data, array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->create('joomla', 'joomla-platform', 1, 'The Body', '123abc', 'a/b/c', 456),
			$this->equalTo(json_decode($this->response->body))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Pulls\Comments::createReply()
	 *
	 * @return  void
	 */
	public function testCreateReply()
	{
		$this->response->code = 201;

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/joomla/joomla-platform/pulls/1/comments', '{"body":"The Body","in_reply_to":456}', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->createReply('joomla', 'joomla-platform', 1, 'The Body', 456),
			$this->equalTo(json_decode($this->response->body))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Pulls\Comments::delete()
	 *
	 * @return  void
	 */
	public function testDelete()
	{
		$this->response->code = 204;
		$this->response->body = '';

		$this->client->expects($this->once())
			->method('delete')
			->with('/repos/joomla/joomla-platform/pulls/comments/456', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->delete('joomla', 'joomla-platform', 456),
			$this->equalTo(json_decode($this->response->body))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Pulls\Comments::edit()
	 *
	 * @return  void
	 */
	public function testEdit()
	{
		$this->response->code = 200;
		$this->response->body = '';

		$this->client->expects($this->once())
			->method('patch')
			->with('/repos/joomla/joomla-platform/pulls/comments/456', '{"body":"Hello"}', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->edit('joomla', 'joomla-platform', 456, 'Hello'),
			$this->equalTo(json_decode($this->response->body))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Pulls\Comments::get()
	 *
	 * @return  void
	 */
	public function testGet()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/pulls/comments/456', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->get('joomla', 'joomla-platform', 456),
			$this->equalTo(json_decode($this->response->body))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Pulls\Comments::getList()
	 *
	 * @return  void
	 */
	public function testGetList()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/pulls/456/comments', array(), 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList('joomla', 'joomla-platform', 456),
			$this->equalTo(json_decode($this->response->body))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Pulls\Comments::getListForRepo()
	 *
	 * @return  void
	 */
	public function testGetListForRepo()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/repos/{user}/{repo}/pulls/comments', [], 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getListForRepo('{user}', '{repo}'),
			$this->equalTo(json_decode($this->response->body))
		);
	}
}
