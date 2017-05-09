<?php
/**
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Pulls;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for Pulls.
 *
 * @since  1.0
 */
class JGithubPackagePullsTest extends GitHubTestCase
{
	/**
	 * @var Pulls
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

		$this->object = new Pulls($this->options, $this->client);
	}

	/**
	 * Tests the create method
	 *
	 * @return void
	 */
	public function testCreate()
	{
		$this->response->code = 201;
		$this->response->body = $this->sampleString;

		$pull = new \stdClass;
		$pull->title = 'My Pull Request';
		$pull->base = 'staging';
		$pull->head = 'joomla-jenkins:mychanges';
		$pull->body = 'These are my changes - please review them';

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/joomla/joomla-platform/pulls', json_encode($pull))
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->create('joomla', 'joomla-platform', 'My Pull Request', 'staging', 'joomla-jenkins:mychanges',
				'These are my changes - please review them'
			),
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

		$pull = new \stdClass;
		$pull->title = 'My Pull Request';
		$pull->base = 'staging';
		$pull->head = 'joomla-jenkins:mychanges';
		$pull->body = 'These are my changes - please review them';

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/joomla/joomla-platform/pulls', json_encode($pull))
			->will($this->returnValue($this->response));

		$this->object->create('joomla', 'joomla-platform', 'My Pull Request', 'staging', 'joomla-jenkins:mychanges',
			'These are my changes - please review them'
		);
	}

	/**
	 * Tests the createFromIssue method
	 *
	 * @return void
	 */
	public function testCreateFromIssue()
	{
		$this->response->code = 201;
		$this->response->body = $this->sampleString;

		$pull = new \stdClass;
		$pull->issue = 254;
		$pull->base = 'staging';
		$pull->head = 'joomla-jenkins:mychanges';

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/joomla/joomla-platform/pulls', json_encode($pull))
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->createFromIssue('joomla', 'joomla-platform', 254, 'staging', 'joomla-jenkins:mychanges'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the createFromIssue method - failure
	 *
	 * @expectedException  \DomainException
	 *
	 * @return void
	 */
	public function testCreateFromIssueFailure()
	{
		$this->response->code = 501;
		$this->response->body = $this->errorString;

		$pull = new \stdClass;
		$pull->issue = 254;
		$pull->base = 'staging';
		$pull->head = 'joomla-jenkins:mychanges';

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/joomla/joomla-platform/pulls', json_encode($pull))
			->will($this->returnValue($this->response));

		$this->object->createFromIssue('joomla', 'joomla-platform', 254, 'staging', 'joomla-jenkins:mychanges');
	}

	/**
	 * Tests the edit method
	 *
	 * @return void
	 */
	public function testEdit()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$pull = new \stdClass;
		$pull->title = 'My Pull Request';
		$pull->body = 'These are my changes - please review them';
		$pull->state = 'Closed';
		$pull->base = 'new';

		$this->client->expects($this->once())
			->method('patch')
			->with('/repos/joomla/joomla-platform/pulls/523', json_encode($pull))
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->edit('joomla', 'joomla-platform', 523, 'My Pull Request', 'These are my changes - please review them', 'Closed', 'new'),
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

		$pull = new \stdClass;
		$pull->title = 'My Pull Request';
		$pull->body = 'These are my changes - please review them';

		$this->client->expects($this->once())
			->method('patch')
			->with('/repos/joomla/joomla-platform/pulls/523', json_encode($pull))
			->will($this->returnValue($this->response));

		$this->object->edit('joomla', 'joomla-platform', 523, 'My Pull Request', 'These are my changes - please review them');
	}

	/**
	 * Tests the get method
	 *
	 * @return void
	 */
	public function testGet()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/pulls/523')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->get('joomla', 'joomla-platform', 523),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the get method - failure
	 *
	 * @expectedException  \DomainException
	 *
	 * @return void
	 */
	public function testGetFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/pulls/523')
			->will($this->returnValue($this->response));

		$this->object->get('joomla', 'joomla-platform', 523);
	}

	/**
	 * Tests the getCommits method
	 *
	 * @return void
	 */
	public function testGetCommits()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/pulls/523/commits')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getCommits('joomla', 'joomla-platform', 523),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getCommits method - failure
	 *
	 * @expectedException  \DomainException
	 *
	 * @return void
	 */
	public function testGetCommitsFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/pulls/523/commits')
			->will($this->returnValue($this->response));

		$this->object->getCommits('joomla', 'joomla-platform', 523);
	}

	/**
	 * Tests the getFiles method
	 *
	 * @return void
	 */
	public function testGetFiles()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/pulls/523/files')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getFiles('joomla', 'joomla-platform', 523),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getFiles method - failure
	 *
	 * @expectedException  \DomainException
	 *
	 * @return void
	 */
	public function testGetFilesFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/pulls/523/files')
			->will($this->returnValue($this->response));

		$this->object->getFiles('joomla', 'joomla-platform', 523);
	}

	/**
	 * Tests the getList method
	 *
	 * @return void
	 */
	public function testGetList()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/pulls?state=closed')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList('joomla', 'joomla-platform', 'closed'),
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
			->with('/repos/joomla/joomla-platform/pulls')
			->will($this->returnValue($this->response));

		$this->object->getList('joomla', 'joomla-platform');
	}

	/**
	 * Tests the isMerged method when the pull request has been merged
	 *
	 * @return void
	 */
	public function testIsMergedTrue()
	{
		$this->response->code = 204;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/pulls/523/merge')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->isMerged('joomla', 'joomla-platform', 523),
			$this->equalTo(true)
		);
	}

	/**
	 * Tests the isMerged method when the pull request has not been merged
	 *
	 * @return void
	 */
	public function testIsMergedFalse()
	{
		$this->response->code = 404;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/pulls/523/merge')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->isMerged('joomla', 'joomla-platform', 523),
			$this->equalTo(false)
		);
	}

	/**
	 * Tests the isMerged method when the request fails
	 *
	 * @expectedException  \DomainException
	 *
	 * @return void
	 */
	public function testIsMergedFailure()
	{
		$this->response->code = 504;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/pulls/523/merge')
			->will($this->returnValue($this->response));

		$this->object->isMerged('joomla', 'joomla-platform', 523);
	}

	/**
	 * Tests the merge method
	 *
	 * @return void
	 */
	public function testMerge()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('put')
			->with('/repos/joomla/joomla-platform/pulls/523/merge')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->merge('joomla', 'joomla-platform', 523),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the merge method - failure
	 *
	 * @expectedException  \DomainException
	 *
	 * @return void
	 */
	public function testMergeFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('put')
			->with('/repos/joomla/joomla-platform/pulls/523/merge')
			->will($this->returnValue($this->response));

		$this->object->merge('joomla', 'joomla-platform', 523);
	}
}
