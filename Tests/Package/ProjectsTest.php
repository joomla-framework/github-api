<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\Projects;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Projects.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Projects::class)]
class ProjectsTest extends GitHubTestCase
{
    /**
     * @var    Projects  Object under test.
     * @since  __DEPLOY_VERSION__
     */
    protected $object;

    /**
     * Sets up the fixture.
     *
     * @return  void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Projects($this->options, $this->client);
    }

    /**
     * Tests the getListForOrg method.
     *
     * @return  void
     */
    public function testGetListForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/projectsV2?page=2&per_page=10&q=roadmap', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForOrg('joomla', ['q' => 'roadmap'], 2, 10)
        );
    }

    /**
     * Tests the getListForOrg method - failure.
     *
     * @return  void
     */
    public function testGetListForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForOrg('joomla', ['q' => 'roadmap'], 2, 10);
    }

    /**
     * Tests the getForOrg method.
     *
     * @return  void
     */
    public function testGetForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/projectsV2/6', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getForOrg('joomla', 6)
        );
    }

    /**
     * Tests the getForOrg method - failure.
     *
     * @return  void
     */
    public function testGetForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getForOrg('joomla', 6);
    }

    /**
     * Tests the getListForUser method.
     *
     * @return  void
     */
    public function testGetListForUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/projectsV2?page=2&per_page=10&after=Y3Vyc29yOnYyOpK5', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForUser('octocat', ['after' => 'Y3Vyc29yOnYyOpK5'], 2, 10)
        );
    }

    /**
     * Tests the getListForUser method - failure.
     *
     * @return  void
     */
    public function testGetListForUserFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForUser('octocat', ['after' => 'Y3Vyc29yOnYyOpK5'], 2, 10);
    }

    /**
     * Tests the getForUser method.
     *
     * @return  void
     */
    public function testGetForUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/projectsV2/6', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getForUser('octocat', 6)
        );
    }

    /**
     * Tests the getForUser method - failure.
     *
     * @return  void
     */
    public function testGetForUserFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getForUser('octocat', 6);
    }
}
