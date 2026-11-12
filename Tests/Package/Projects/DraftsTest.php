<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Projects;

use Joomla\Github\Package\Projects\Drafts;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Projects\Drafts.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Drafts::class)]
class DraftsTest extends GitHubTestCase
{
    /**
     * @var    Drafts  Object under test.
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

        $this->object = new Drafts($this->options, $this->client);
    }

    /**
     * Tests the createForOrg method.
     *
     * @return  void
     */
    public function testCreateForOrg()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);
        $body = '{"body":"Details","title":"Write the docs"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/projectsV2/6/drafts', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createForOrg('joomla', 6, 'Write the docs', ['body' => 'Details'])
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

        $this->object->createForOrg('joomla', 6, 'Write the docs', ['body' => 'Details']);
    }

    /**
     * Tests the createForUser method.
     *
     * @return  void
     */
    public function testCreateForUser()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);
        $body = '{"body":"Details","title":"Write the docs"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/583231/projectsV2/6/drafts', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createForUser('583231', 6, 'Write the docs', ['body' => 'Details'])
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

        $this->object->createForUser('583231', 6, 'Write the docs', ['body' => 'Details']);
    }
}
