<?php
/**
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Repositories\Contents;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for Contents.
 *
 * @since  1.0
 */
class ContentsTest extends GitHubTestCase
{
	/**
	 * @var Contents
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

		$this->object = new Contents($this->options, $this->client);
	}

	/**
	 * Tests the GetReadme method.
	 *
	 * @return  void
	 */
	public function testGetReadme()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/readme')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getReadme('joomla', 'joomla-platform'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the GetReadmeRef method.
	 *
	 * @return  void
	 */
	public function testGetReadmeRef()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/readme?ref=123abc')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getReadme('joomla', 'joomla-platform', '123abc'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the Get method.
	 *
	 * @return  void
	 */
	public function testGet()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/contents/path/to/file.php')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->get('joomla', 'joomla-platform', 'path/to/file.php'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the GetRef method.
	 *
	 * @return  void
	 */
	public function testGetRef()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/contents/path/to/file.php?ref=123abc')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->get('joomla', 'joomla-platform', 'path/to/file.php', '123abc'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the GetArchiveLink method.
	 *
	 * @return  void
	 */
	public function testGetArchiveLink()
	{
		$this->response->code = 302;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/zipball')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getArchiveLink('joomla', 'joomla-platform'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the GetArchiveLinkRef method.
	 *
	 * @return  void
	 */
	public function testGetArchiveLinkRef()
	{
		$this->response->code = 302;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/zipball?ref=123abc')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getArchiveLink('joomla', 'joomla-platform', 'zipball', '123abc'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the GetArchiveLinkInvalidFormat method.
	 *
	 * @return  void
	 *
	 * @expectedException \UnexpectedValueException
	 */
	public function testGetArchiveLinkInvalidFormat()
	{
		$this->response->code = 302;

		$this->object->getArchiveLink('joomla', 'joomla-platform', 'invalid');
	}

	/**
	 * Tests the create method.
	 *
	 * @return  void
	 */
	public function testCreate()
	{
		$this->response->code = 201;

		$this->client->expects($this->once())
			->method('put')
			->with('/repos/joomla/joomla-platform/contents/src/foo')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->create(
				'joomla', 'joomla-platform', 'src/foo', 'my Message', 'ABC123def', 'xxbranch',
				'eddieajau', 'eddieajau@example.com', 'elkuku', 'elkuku@example.com'
			),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the create method with missing author e-mail.
	 *
	 * @expectedException \UnexpectedValueException
	 *
	 * @return  void
	 */
	public function testCreateFail1()
	{
		$this->object->create(
			'joomla', 'joomla-platform', 'src/foo', 'my Message', 'ABC123def', 'xxbranch',
			'eddieajau', '', 'elkuku', 'elkuku@example.com'
		);
	}

	/**
	 * Tests the create method with missing committer e-mail.
	 *
	 * @expectedException \UnexpectedValueException
	 *
	 * @return  void
	 */
	public function testCreateFail2()
	{
		$this->object->create(
			'joomla', 'joomla-platform', 'src/foo', 'my Message', 'ABC123def', 'xxbranch',
			'eddieajau', 'eddieajau@example.com', 'elkuku', ''
		);
	}

	/**
	 * Tests the update method.
	 *
	 * @return  void
	 */
	public function testUpdate()
	{
		$this->client->expects($this->once())
			->method('put')
			->with('/repos/joomla/joomla-platform/contents/src/foo')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->update(
				'joomla', 'joomla-platform', 'src/foo', 'my Message', 'ABC123def', 'abcd1234', 'xxbranch',
				'eddieajau', 'eddieajau@example.com', 'elkuku', 'elkuku@example.com'
			),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the update method with missing author e-mail.
	 *
	 * @expectedException \UnexpectedValueException
	 *
	 * @return  void
	 */
	public function testUpdateFail1()
	{
		$this->object->update(
			'joomla', 'joomla-platform', 'src/foo', 'my Message', 'ABC123def', 'abcd1234', 'xxbranch',
			'eddieajau', '', 'elkuku', 'elkuku@example.com'
		);
	}

	/**
	 * Tests the update method with missing committer e-mail.
	 *
	 * @expectedException \UnexpectedValueException
	 *
	 * @return  void
	 */
	public function testUpdateFail2()
	{
		$this->object->update(
			'joomla', 'joomla-platform', 'src/foo', 'my Message', 'ABC123def', 'abcd1234', 'xxbranch',
			'eddieajau', 'eddieajau@example.com', 'elkuku', ''
		);
	}

	/**
	 * Tests the delete method.
	 *
	 * @return  void
	 */
	public function testDelete()
	{
		$this->client->expects($this->once())
			->method('delete')
			->with('/repos/joomla/joomla-platform/contents/src/foo')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->delete(
				'joomla', 'joomla-platform', 'src/foo', 'my Message', 'ABC123def', 'xxbranch',
				'eddieajau', 'eddieajau@example.com', 'elkuku', 'elkuku@example.com'
			),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the delete method with missing author e-mail.
	 *
	 * @expectedException \UnexpectedValueException
	 *
	 * @return  void
	 */
	public function testDeleteFail1()
	{
		$this->object->delete(
			'joomla', 'joomla-platform', 'src/foo', 'my Message', 'ABC123def', 'xxbranch',
			'eddieajau', '', 'elkuku', 'elkuku@example.com'
		);
	}

	/**
	 * Tests the update method with missing committer e-mail.
	 *
	 * @expectedException \UnexpectedValueException
	 *
	 * @return  void
	 */
	public function testDeleteFail2()
	{
		$this->object->delete(
			'joomla', 'joomla-platform', 'src/foo', 'my Message', 'ABC123def', 'xxbranch',
			'eddieajau', 'eddieajau@example.com', 'elkuku', ''
		);
	}
}
