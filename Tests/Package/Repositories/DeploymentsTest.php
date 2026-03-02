<?php
/**
 * @copyright  Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Repositories\Deployments;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for Deployments.
 *
 * @since  1.0
 */
class DeploymentsTest extends GitHubTestCase
{
	/**
	 * @var Deployments
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

		$this->object = new Deployments($this->options, $this->client);
	}

	/**
	 * Tests the GetList method.
	 *
	 * @return  void
	 */
	public function testGetList()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/repos/{owner}/{repo}/deployments?sha={sha}&ref={ref}&task={task}&environment={environment}')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList('{owner}', '{repo}', '{sha}', '{ref}', '{task}', '{environment}'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the Create method.
	 *
	 * @return  void
	 */
	public function testCreate()
	{
		$this->response->code = 201;

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/{owner}/{repo}/deployments')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->create(
				'{owner}', '{repo}', '{ref}', '{task}', '{automerge}', array('{requiredContexts}'),
				'{payload}', '{environment}', '{description}'
			),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the Create method.
	 *
	 * @return  void
	 */
	public function testCreateMergeConflict()
	{
		$this->expectException(\RuntimeException::class);

		$this->response->code = 409;

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/{owner}/{repo}/deployments')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->create('{owner}', '{repo}', '{ref}'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the Create method.
	 *
	 * @return  void
	 */
	public function testCreateFailure()
	{
		$this->expectException(\UnexpectedValueException::class);

		$this->response->code = 666;

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/{owner}/{repo}/deployments')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->create('{owner}', '{repo}', '{ref}'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the GetDeploymentStatuses method.
	 *
	 * @return  void
	 */
	public function testGetDeploymentStatuses()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/repos/{owner}/{repo}/deployments/123/statuses')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getDeploymentStatuses('{owner}', '{repo}', 123),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the CreateStatus method.
	 *
	 * @return  void
	 */
	public function testCreateStatus()
	{
		$this->response->code = 201;

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/{owner}/{repo}/deployments/123/statuses')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->createStatus('{owner}', '{repo}', 123, 'success', '{targetUrl}', '{description}'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the CreateStatus method.
	 *
	 * @return  void
	 */
	public function testCreateStatusFailure()
	{
		$this->expectException(\InvalidArgumentException::class);

		$this->object->createStatus('{owner}', '{repo}', 123, '{invalid}');
	}
}
