<?php
/**
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Gists;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for Gists.
 *
 * @since  1.0
 */
class GistsTest extends GitHubTestCase
{
	/**
	 * @var Gists
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

		$this->object = new Gists($this->options, $this->client);
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
				'files' => array(
					'file2.txt' => array('content' => 'This is the second file')
				),
				'public' => true,
				'description' => 'This is a gist'
			)
		);

		$this->client->expects($this->once())
			->method('post')
			->with('/gists', $data)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->create(
				array(
					'file2.txt' => 'This is the second file'
				),
				true,
				'This is a gist'
			),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the create method loading file content from a file
	 *
	 * @return void
	 */
	public function testCreateGistFromFile()
	{
		$this->response->code = 201;

		// Build the request data.
		$data = json_encode(
			array(
				'files' => array(
					'gittest' => array('content' => 'GistContent' . PHP_EOL)
				),
				'public' => true,
				'description' => 'This is a gist'
			)
		);

		$this->client->expects($this->once())
			->method('post')
			->with('/gists', $data)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->create(
				array(
					__DIR__ . '/../data/gittest'
				),
				true,
				'This is a gist'
			),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the create method loading file content from a file - file does not exist
	 *
	 * @expectedException \InvalidArgumentException
	 *
	 * @return void
	 */
	public function testCreateGistFromFileNotFound()
	{
		$this->response->code = 501;

		$this->object->create(
			array(
				'/file/not/found'
			),
			true,
			'This is a gist'
		);
	}

	/**
	 * Tests the create method
	 *
	 * @return void
	 */
	public function testCreateFailure()
	{
		$exception = false;

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		// Build the request data.
		$data = json_encode(
			array('files' => array(), 'public' => true, 'description' => 'This is a gist')
		);

		$this->client->expects($this->once())
			->method('post')
			->with('/gists', $data)
			->will($this->returnValue($this->response));

		try
		{
			$this->object->create(array(), true, 'This is a gist');
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
	}

	/**
	 * Tests the createComment method - simulated failure
	 *
	 * @return void
	 */
	public function testCreateComment()
	{
		$this->response->code = 201;

		$gist = new \stdClass;
		$gist->body = 'My Insightful Comment';

		$this->client->expects($this->once())
			->method('post')
			->with('/gists/523/comments', json_encode($gist))
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->comments->create(523, 'My Insightful Comment'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the createComment method - simulated failure
	 *
	 * @return void
	 */
	public function testCreateCommentFailure()
	{
		$exception = false;

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$gist = new \stdClass;
		$gist->body = 'My Insightful Comment';

		$this->client->expects($this->once())
			->method('post')
			->with('/gists/523/comments', json_encode($gist))
			->will($this->returnValue($this->response));

		try
		{
			$this->object->comments->create(523, 'My Insightful Comment');
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
	}

	/**
	 * Tests the delete method
	 *
	 * @return void
	 */
	public function testDelete()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('delete')
			->with('/gists/254')
			->will($this->returnValue($this->response));

		$this->object->delete(254);
	}

	/**
	 * Tests the delete method - simulated failure
	 *
	 * @return void
	 */
	public function testDeleteFailure()
	{
		$exception = false;

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('delete')
			->with('/gists/254')
			->will($this->returnValue($this->response));

		try
		{
			$this->object->delete(254);
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
	}

	/**
	 * Tests the deleteComment method
	 *
	 * @return void
	 */
	public function testDeleteComment()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('delete')
			->with('/gists/comments/254')
			->will($this->returnValue($this->response));

		$this->object->comments->delete(254);
	}

	/**
	 * Tests the deleteComment method - simulated failure
	 *
	 * @return void
	 */
	public function testDeleteCommentFailure()
	{
		$exception = false;

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('delete')
			->with('/gists/comments/254')
			->will($this->returnValue($this->response));

		try
		{
			$this->object->comments->delete(254);
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
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
				'description' => 'This is a gist',
				'public' => true,
				'files' => array(
					'file1.txt' => array('content' => 'This is the first file'),
					'file2.txt' => array('content' => 'This is the second file')
				)
			)
		);

		$this->client->expects($this->once())
			->method('patch')
			->with('/gists/512', $data)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->edit(
				512,
				array(
					'file1.txt' => 'This is the first file',
					'file2.txt' => 'This is the second file'
				),
				true,
				'This is a gist'
			),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the edit method - simulated failure
	 *
	 * @return void
	 */
	public function testEditFailure()
	{
		$exception = false;

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		// Build the request data.
		$data = json_encode(
			array(
				'description' => 'This is a gist',
				'public' => true,
				'files' => array(
					'file1.txt' => array('content' => 'This is the first file'),
					'file2.txt' => array('content' => 'This is the second file')
				)
			)
		);

		$this->client->expects($this->once())
			->method('patch')
			->with('/gists/512', $data)
			->will($this->returnValue($this->response));

		try
		{
			$this->object->edit(
				512,
				array(
					'file1.txt' => 'This is the first file',
					'file2.txt' => 'This is the second file'
				),
				true,
				'This is a gist'
			);
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
	}

	/**
	 * Tests the editComment method
	 *
	 * @return void
	 */
	public function testEditComment()
	{
		$gist = new \stdClass;
		$gist->body = 'This comment is now even more insightful';

		$this->client->expects($this->once())
			->method('patch')
			->with('/gists/comments/523', json_encode($gist))
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->comments->edit(523, 'This comment is now even more insightful'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the editComment method - simulated failure
	 *
	 * @return void
	 */
	public function testEditCommentFailure()
	{
		$exception = false;

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$gist = new \stdClass;
		$gist->body = 'This comment is now even more insightful';

		$this->client->expects($this->once())
			->method('patch')
			->with('/gists/comments/523', json_encode($gist))
			->will($this->returnValue($this->response));

		try
		{
			$this->object->comments->edit(523, 'This comment is now even more insightful');
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
	}

	/**
	 * Tests the fork method
	 *
	 * @return void
	 */
	public function testFork()
	{
		$this->response->code = 201;

		$this->client->expects($this->once())
			->method('post')
			->with('/gists/523/forks')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->fork(523),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the fork method - simulated failure
	 *
	 * @return void
	 */
	public function testForkFailure()
	{
		$exception = false;

		$this->response->code = 501;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('post')
			->with('/gists/523/forks')
			->will($this->returnValue($this->response));

		try
		{
			$this->object->fork(523);
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
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
			->with('/gists/523')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->get(523),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the get method - simulated failure
	 *
	 * @return void
	 */
	public function testGetFailure()
	{
		$exception = false;

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/gists/523')
			->will($this->returnValue($this->response));

		try
		{
			$this->object->get(523);
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
	}

	/**
	 * Tests the getComment method
	 *
	 * @return void
	 */
	public function testGetComment()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/gists/comments/523')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->comments->get(523),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getComment method - simulated failure
	 *
	 * @return void
	 */
	public function testGetCommentFailure()
	{
		$exception = false;

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/gists/comments/523')
			->will($this->returnValue($this->response));

		try
		{
			$this->object->comments->get(523);
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
	}

	/**
	 * Tests the getComments method
	 *
	 * @return void
	 */
	public function testGetComments()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/gists/523/comments')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->comments->getList(523),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getComments method - simulated failure
	 *
	 * @return void
	 */
	public function testGetCommentsFailure()
	{
		$exception = false;

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/gists/523/comments')
			->will($this->returnValue($this->response));

		try
		{
			$this->object->comments->getList(523);
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
	}

	/**
	 * Tests the getCommitList method
	 *
	 * @return void
	 */
	public function testGetCommitList()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/gists/523/commits')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getCommitList(523),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getCommitList method - simulated failure
	 *
	 * @return void
	 */
	public function testGetCommitListFailure()
	{
		$exception = false;

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/gists/523/commits')
			->will($this->returnValue($this->response));

		try
		{
			$this->object->getCommitList(523);
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
	}

	/**
	 * Tests the getForkList method
	 *
	 * @return void
	 */
	public function testGetForkList()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/gists/523/forks')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getForkList(523),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getForkList method - simulated failure
	 *
	 * @return void
	 */
	public function testGetForkListFailure()
	{
		$exception = false;

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/gists/523/forks')
			->will($this->returnValue($this->response));

		try
		{
			$this->object->getForkList(523);
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
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
			->with('/gists')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList(),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getList method - simulated failure
	 *
	 * @return void
	 */
	public function testGetListFailure()
	{
		$exception = false;

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/gists')
			->will($this->returnValue($this->response));

		try
		{
			$this->object->getList();
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
	}

	/**
	 * Tests the getListByUser method
	 *
	 * @return void
	 */
	public function testGetListByUser()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/users/joomla/gists')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getListByUser('joomla'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getListByUser method - simulated failure
	 *
	 * @return void
	 */
	public function testGetListByUserFailure()
	{
		$exception = false;

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/users/joomla/gists')
			->will($this->returnValue($this->response));

		try
		{
			$this->object->getListByUser('joomla');
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
	}

	/**
	 * Tests the getListPublic method
	 *
	 * @return void
	 */
	public function testGetListPublic()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/gists/public')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getListPublic(),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getListPublic method - simulated failure
	 *
	 * @return void
	 */
	public function testGetListPublicFailure()
	{
		$exception = false;

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/gists/public')
			->will($this->returnValue($this->response));

		try
		{
			$this->object->getListPublic();
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
	}

	/**
	 * Tests the getListStarred method
	 *
	 * @return void
	 */
	public function testGetListStarred()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/gists/starred')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getListStarred(),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getListStarred method - simulated failure
	 *
	 * @return void
	 */
	public function testGetListStarredFailure()
	{
		$exception = false;

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/gists/starred')
			->will($this->returnValue($this->response));

		try
		{
			$this->object->getListStarred();
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
	}

	/**
	 * Tests the getRevision method
	 *
	 * @return void
	 */
	public function testGetRevision()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/gists/523/a1b2c3')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getRevision(523, 'a1b2c3'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getRevision method - simulated failure
	 *
	 * @return void
	 */
	public function testGetRevisionFailure()
	{
		$exception = false;

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/gists/523/a1b2c3')
			->will($this->returnValue($this->response));

		try
		{
			$this->object->getRevision(523, 'a1b2c3');
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
	}

	/**
	 * Tests the isStarred method when the gist has been starred
	 *
	 * @return void
	 */
	public function testIsStarredTrue()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('get')
			->with('/gists/523/star')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->isStarred(523),
			$this->equalTo(true)
		);
	}

	/**
	 * Tests the isStarred method when the gist has not been starred
	 *
	 * @return void
	 */
	public function testIsStarredFalse()
	{
		$this->response->code = 404;

		$this->client->expects($this->once())
			->method('get')
			->with('/gists/523/star')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->isStarred(523),
			$this->equalTo(false)
		);
	}

	/**
	 * Tests the isStarred method expecting a failure response
	 *
	 * @return void
	 */
	public function testIsStarredFailure()
	{
		$exception = false;

		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/gists/523/star')
			->will($this->returnValue($this->response));

		try
		{
			$this->object->isStarred(523);
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
	}

	/**
	 * Tests the star method
	 *
	 * @return void
	 */
	public function testStar()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('put')
			->with('/gists/523/star', '')
			->will($this->returnValue($this->response));

		$this->object->star(523);
	}

	/**
	 * Tests the star method - simulated failure
	 *
	 * @return void
	 */
	public function testStarFailure()
	{
		$exception = false;

		$this->response->code = 504;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('put')
			->with('/gists/523/star', '')
			->will($this->returnValue($this->response));

		try
		{
			$this->object->star(523);
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
	}

	/**
	 * Tests the unstar method
	 *
	 * @return void
	 */
	public function testUnstar()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('delete')
			->with('/gists/523/star')
			->will($this->returnValue($this->response));

		$this->object->unstar(523);
	}

	/**
	 * Tests the unstar method - simulated failure
	 *
	 * @return void
	 */
	public function testUnstarFailure()
	{
		$exception = false;

		$this->response->code = 504;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('delete')
			->with('/gists/523/star')
			->will($this->returnValue($this->response));

		try
		{
			$this->object->unstar(523);
		}
		catch (\DomainException $e)
		{
			$exception = true;

			$this->assertThat(
				$e->getMessage(),
				$this->equalTo(json_decode($this->errorString)->message)
			);
		}

		$this->assertTrue($exception);
	}
}
