<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Projects;

use Joomla\Github\Package\Projects\Views;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Projects\Views.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Views::class)]
class ViewsTest extends GitHubTestCase
{
    /**
     * @var    Views  Object under test.
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

        $this->object = new Views($this->options, $this->client);
    }

    /**
     * Tests the createForOrg method.
     *
     * @return  void
     */
    public function testCreateForOrg()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);
        $body = '{"filter":"is:issue","name":"Board","layout":"board"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/projectsV2/6/views', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createForOrg('joomla', 6, 'Board', 'board', ['filter' => 'is:issue'])
        );
    }

    /**
     * Tests the createForOrg method - failure.
     *
     * @return  void
     */
    public function testCreateForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->createForOrg('joomla', 6, 'Board', 'board', ['filter' => 'is:issue']);
    }

    /**
     * Tests the createForUser method.
     *
     * @return  void
     */
    public function testCreateForUser()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);
        $body = '{"visible_fields":[1,2],"name":"Board","layout":"board"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/users/583231/projectsV2/6/views', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createForUser('583231', 6, 'Board', 'board', ['visible_fields' => [1, 2]])
        );
    }

    /**
     * Tests the createForUser method - failure.
     *
     * @return  void
     */
    public function testCreateForUserFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->createForUser('583231', 6, 'Board', 'board', ['visible_fields' => [1, 2]]);
    }
}
