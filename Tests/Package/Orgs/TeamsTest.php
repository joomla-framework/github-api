<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
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
    protected function setUp(): void
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
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->getList('joomla'),
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
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/teams')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->create('joomla', 'TheTeam', ['joomla-platform'], 'admin'),
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
    public function testCreateWrongPermission()
    {
        $this->expectException(\UnexpectedValueException::class);

        $this->response = $this->getResponseObject($this->sampleString, 201);

        $this->object->create('joomla', 'TheTeam', ['joomla-platform'], 'invalid');
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
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->getUserTeams(),
            $this->equalTo(json_decode($this->sampleString))
        );
    }
}
