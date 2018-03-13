<?php
/**
 * @copyright  Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Orgs\Teams;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test method.
 *
 * @covers \Joomla\Github\Package\Orgs\Teams
 *
 * @since  1.0
 */
class TeamsTest extends GitHubTestCase
{
	/**
	 * @var Teams
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

		$this->object = new Teams($this->options, $this->client);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::getList()
	 *
	 * @return  void
	 */
	public function testGetList()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/orgs/joomla/teams')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList('joomla'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::get()
	 *
	 * @return  void
	 */
	public function testGet()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/teams/123')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->get(123),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::create()
	 *
	 * @return  void
	 */
	public function testCreate()
	{
		$this->response->code = 201;

		$this->client->expects($this->once())
			->method('post')
			->with('/orgs/joomla/teams')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->create('joomla', 'TheTeam', array('joomla-platform'), 'admin'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::create()
	 *
	 * @return  void
	 *
	 * @expectedException \UnexpectedValueException
	 */
	public function testCreateWrongPermission()
	{
		$this->response->code = 201;

		$this->object->create('joomla', 'TheTeam', array('joomla-platform'), 'invalid');
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::edit()
	 *
	 * @return  void
	 */
	public function testEdit()
	{
		$this->client->expects($this->once())
			->method('patch')
			->with('/teams/123')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->edit(123, 'TheTeam', 'admin'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::edit()
	 *
	 * @return  void
	 *
	 * @expectedException \UnexpectedValueException
	 */
	public function testEditWrongPermission()
	{
		$this->object->edit(123, 'TheTeam', 'invalid');
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::delete()
	 *
	 * @return  void
	 */
	public function testDelete()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('delete')
			->with('/teams/123')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->delete(123),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::getListMembers()
	 *
	 * @return  void
	 */
	public function testGetListMembers()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/teams/123/members')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getListMembers(123),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::isMember()
	 *
	 * @deprecated
	 *
	 * @return  void
	 */
	public function testIsMember()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('get')
			->with('/teams/123/members/elkuku')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->isMember(123, 'elkuku'),
			$this->equalTo(json_decode(true))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::isMember()
	 *
	 * @deprecated
	 *
	 * @return  void
	 */
	public function testIsMemberNo()
	{
		$this->response->code = 404;

		$this->client->expects($this->once())
			->method('get')
			->with('/teams/123/members/elkuku')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->isMember(123, 'elkuku'),
			$this->equalTo(json_decode(false))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::isMember()
	 *
	 * @deprecated
	 *
	 * @return  void
	 *
	 * @expectedException \UnexpectedValueException
	 */
	public function testIsMemberUnexpected()
	{
		$this->response->code = 666;

		$this->client->expects($this->once())
			->method('get')
			->with('/teams/123/members/elkuku')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->isMember(123, 'elkuku'),
			$this->equalTo(json_decode(true))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::addMember()
	 *
	 * @deprecated
	 *
	 * @return  void
	 */
	public function testAddMember()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('put')
			->with('/teams/123/members/elkuku')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->addMember(123, 'elkuku'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::removeMember()
	 *
	 * @deprecated
	 *
	 * @return  void
	 */
	public function testRemoveMember()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('delete')
			->with('/teams/123/members/elkuku')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->removeMember(123, 'elkuku'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::getListRepos()
	 *
	 * @return  void
	 */
	public function testGetListRepos()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/teams/123/repos')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getListRepos(123),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::checkRepo()
	 *
	 * @return  void
	 */
	public function testCheckRepo()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('get')
			->with('/teams/123/repos/joomla/cms')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->checkRepo(123, 'joomla', 'cms'),
			$this->equalTo(true)
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::checkRepo()
	 *
	 * @return  void
	 */
	public function testCheckRepoNo()
	{
		$this->response->code = 404;

		$this->client->expects($this->once())
			->method('get')
			->with('/teams/123/repos/joomla/cms')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->checkRepo(123, 'joomla', 'cms'),
			$this->equalTo(false)
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::checkRepo()
	 *
	 * @return  void
	 *
	 * @expectedException \UnexpectedValueException
	 */
	public function testCheckRepoUnexpected()
	{
		$this->response->code = 666;

		$this->client->expects($this->once())
			->method('get')
			->with('/teams/123/repos/joomla/cms')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->checkRepo(123, 'joomla', 'cms'),
			$this->equalTo(true)
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::addRepo()
	 *
	 * @return  void
	 */
	public function testAddRepo()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('put')
			->with('/teams/123/repos/joomla/joomla-platform')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->addRepo(123, 'joomla', 'joomla-platform'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::removeRepo()
	 *
	 * @return  void
	 */
	public function testRemoveRepo()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('delete')
			->with('/teams/123/repos/joomla/joomla-platform')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->removeRepo(123, 'joomla', 'joomla-platform'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::getTeamMembership()
	 *
	 * @return  void
	 */
	public function testGetTeamMemberships()
	{
		$this->response->code = 200;
		$this->response->body = '{"state":"TEST"}';

		$this->client->expects($this->once())
			->method('get')
			->with('/teams/123/memberships/{user}')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getTeamMembership(123, '{user}'),
			$this->equalTo('TEST')
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::getTeamMembership()
	 *
	 * Response if user is not a member
	 *
	 * @return  void
	 */
	public function testGetTeamMembershipsFailure1()
	{
		$this->response->code = 404;
		$this->response->body = '{"state":"TEST"}';

		$this->client->expects($this->once())
			->method('get')
			->with('/teams/123/memberships/{user}')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getTeamMembership(123, '{user}'),
			$this->equalTo(false)
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::getTeamMembership()
	 *
	 * Unexpected Response
	 *
	 * @return  void
	 *
	 * @expectedException \UnexpectedValueException
	 * @expectedExceptionMessage Unexpected response code: 666
	 */
	public function testGetTeamMembershipsFailure2()
	{
		$this->response->code = 666;
		$this->response->body = '{"state":"TEST"}';

		$this->client->expects($this->once())
			->method('get')
			->with('/teams/123/memberships/{user}')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getTeamMembership(123, '{user}'),
			$this->equalTo('TEST')
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::addTeamMembership()
	 *
	 * @return  void
	 */
	public function testAddTeamMemberships()
	{
		$this->client->expects($this->once())
			->method('put')
			->with('/teams/123/memberships/{user}')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->addTeamMembership(123, '{user}'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::addTeamMembership()
	 *
	 * Invalid role
	 *
	 * @return  void
	 *
	 * @expectedException \UnexpectedValueException
	 * @expectedExceptionMessage Roles must be either "member" or "maintainer".
	 */
	public function testAddTeamMembershipsFailure()
	{
		$this->object->addTeamMembership(123, '{user}', 'INVALID');
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::removeTeamMembership()
	 *
	 * @return  void
	 */
	public function testRemoveTeamMemberships()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('delete')
			->with('/teams/123/memberships/{user}')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->removeTeamMembership(123, '{user}'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Teams::getUserTeams()
	 *
	 * @return  void
	 */
	public function testGetUserTeams()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/user/teams')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getUserTeams(),
			$this->equalTo(json_decode($this->sampleString))
		);
	}
}
