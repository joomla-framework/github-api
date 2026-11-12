<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Codespaces;

use Joomla\Github\Package\Codespaces\Organizations;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Codespaces\Organizations.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Organizations::class)]
class OrganizationsTest extends GitHubTestCase
{
    /**
     * @var    Organizations  Object under test.
     * @since  __DEPLOY_VERSION__
     */
    protected $object;

    /**
     * Sets up the fixture.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Organizations($this->options, $this->client);
    }

    /**
     * Test the getList method.
     *
     * @return  void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/codespaces?page=2&per_page=30', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getList('joomla', 2, 30)
        );
    }

    /**
     * Test the getList method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/codespaces?page=2&per_page=30', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getList('joomla', 2, 30);
    }

    /**
     * Test the getListForUser method.
     *
     * @return  void
     */
    public function testGetListForUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/members/octocat/codespaces?page=2&per_page=30', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForUser('joomla', 'octocat', 2, 30)
        );
    }

    /**
     * Test the getListForUser method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListForUserFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/members/octocat/codespaces?page=2&per_page=30', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getListForUser('joomla', 'octocat', 2, 30);
    }

    /**
     * Test the delete method.
     *
     * @return  void
     */
    public function testDelete()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/members/octocat/codespaces/monalisa-octocat-hello-world-g4wpq6h95q', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 202));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->delete('joomla', 'octocat', 'monalisa-octocat-hello-world-g4wpq6h95q')
        );
    }

    /**
     * Test the delete method with an unexpected response.
     *
     * @return  void
     */
    public function testDeleteFailure()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/members/octocat/codespaces/monalisa-octocat-hello-world-g4wpq6h95q', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->delete('joomla', 'octocat', 'monalisa-octocat-hello-world-g4wpq6h95q');
    }

    /**
     * Test the stop method.
     *
     * @return  void
     */
    public function testStop()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/members/octocat/codespaces/monalisa-octocat-hello-world-g4wpq6h95q/stop', '', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->stop('joomla', 'octocat', 'monalisa-octocat-hello-world-g4wpq6h95q')
        );
    }

    /**
     * Test the stop method with an unexpected response.
     *
     * @return  void
     */
    public function testStopFailure()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/members/octocat/codespaces/monalisa-octocat-hello-world-g4wpq6h95q/stop', '', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->stop('joomla', 'octocat', 'monalisa-octocat-hello-world-g4wpq6h95q');
    }
}
