<?php
/**
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Orgs\Members;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class.
 *
 * @covers \Joomla\Github\Package\Orgs\Members
 *
 * @since  1.0
 */
class MembersTest extends GitHubTestCase
{
	/**
	 * @var Members
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

		$this->object = new Members($this->options, $this->client);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::getList()
	 *
	 * @return  void
	 */
	public function testGetList()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/orgs/joomla/members')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList('joomla'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::getList()
	 *
	 * @return  void
	 */
	public function testGetListNotAMember()
	{
		$this->response->code = 302;

		$this->client->expects($this->once())
			->method('get')
			->with('/orgs/joomla/members')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList('joomla'),
			$this->equalTo(false)
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::getList()
	 *
	 * @return  void
	 *
	 * @expectedException \UnexpectedValueException
	 */
	public function testGetListUnexpected()
	{
		$this->response->code = 666;

		$this->client->expects($this->once())
			->method('get')
			->with('/orgs/joomla/members')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList('joomla'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::check()
	 *
	 * @return  void
	 */
	public function testCheck()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('get')
			->with('/orgs/joomla/members/elkuku')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->check('joomla', 'elkuku'),
			$this->equalTo(true)
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::check()
	 *
	 * @return  void
	 */
	public function testCheckNoMember()
	{
		$this->response->code = 404;

		$this->client->expects($this->once())
			->method('get')
			->with('/orgs/joomla/members/elkuku')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->check('joomla', 'elkuku'),
			$this->equalTo(false)
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::check()
	 *
	 * @return  void
	 */
	public function testCheckRequesterNoMember()
	{
		$this->response->code = 302;

		$this->client->expects($this->once())
			->method('get')
			->with('/orgs/joomla/members/elkuku')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->check('joomla', 'elkuku'),
			$this->equalTo(false)
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::check()
	 *
	 * @return  void
	 *
	 * @expectedException \UnexpectedValueException
	 */
	public function testCheckUnexpectedr()
	{
		$this->response->code = 666;

		$this->client->expects($this->once())
			->method('get')
			->with('/orgs/joomla/members/elkuku')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->check('joomla', 'elkuku'),
			$this->equalTo(false)
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::remove()
	 *
	 * @return  void
	 */
	public function testRemove()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('delete')
			->with('/orgs/joomla/members/elkuku')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->remove('joomla', 'elkuku'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::getListPublic()
	 *
	 * @return  void
	 */
	public function testGetListPublic()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/orgs/joomla/public_members')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getListPublic('joomla'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::checkPublic()
	 *
	 * @return  void
	 */
	public function testCheckPublic()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('get')
			->with('/orgs/joomla/public_members/elkuku')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->checkPublic('joomla', 'elkuku'),
			$this->equalTo(true)
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::checkPublic()
	 *
	 * @return  void
	 */
	public function testCheckPublicNo()
	{
		$this->response->code = 404;

		$this->client->expects($this->once())
			->method('get')
			->with('/orgs/joomla/public_members/elkuku')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->checkPublic('joomla', 'elkuku'),
			$this->equalTo(false)
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::checkPublic()
	 *
	 * @return  void
	 *
	 * @expectedException \UnexpectedValueException
	 */
	public function testCheckPublicUnexpected()
	{
		$this->response->code = 666;

		$this->client->expects($this->once())
			->method('get')
			->with('/orgs/joomla/public_members/elkuku')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->checkPublic('joomla', 'elkuku'),
			$this->equalTo(false)
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::publicize()
	 *
	 * @return  void
	 */
	public function testPublicize()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('put')
			->with('/orgs/joomla/public_members/elkuku')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->publicize('joomla', 'elkuku'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::conceal()
	 *
	 * @return  void
	 */
	public function testConceal()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('delete')
			->with('/orgs/joomla/public_members/elkuku')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->conceal('joomla', 'elkuku'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::getMembership()
	 *
	 * @return  void
	 */
	public function testGetMembership()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/orgs/{org}/memberships/{user}')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getMembership('{org}', '{user}'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::updateMembership()
	 *
	 * @return  void
	 */
	public function testUpdateMembership()
	{
		$this->client->expects($this->once())
			->method('put')
			->with('/orgs/{org}/memberships/{user}')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->updateMembership('{org}', '{user}'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::updateMembership()
	 *
	 * @return  void
	 *
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage The user's role must be: member, admin
	 */
	public function testUpdateMembershipInvalidRole()
	{
		$this->object->updateMembership('{org}', '{user}', 'INVALID');
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::removeMembership()
	 *
	 * @return  void
	 */
	public function testRemoveMembership()
	{
		$this->response->code = 204;

		$this->client->expects($this->once())
			->method('delete')
			->with('/orgs/{org}/memberships/{user}')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->removeMembership('{org}', '{user}'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::listMemberships()
	 *
	 * @return  void
	 */
	public function testListMemberships()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/user/memberships/orgs')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->listMemberships(),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::listOrganizationMembership()
	 *
	 * @return  void
	 */
	public function testListOrganizationMemberships()
	{
		$this->client->expects($this->once())
			->method('get')
			->with('/user/memberships/orgs/{org}')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->listOrganizationMembership('{org}'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::editOrganizationMembership()
	 *
	 * @return  void
	 */
	public function testEditOrganizationMemberships()
	{
		$this->client->expects($this->once())
			->method('patch')
			->with('/user/memberships/orgs/{org}')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->editOrganizationMembership('{org}', 'active'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Test method.
	 *
	 * @covers \Joomla\Github\Package\Orgs\Members::editOrganizationMembership()
	 *
	 * @return  void
	 *
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage The state must be "active".
	 */
	public function testEditOrganizationMembershipsInvalidState()
	{
		$this->object->editOrganizationMembership('{org}', 'INVALID');
	}
}
