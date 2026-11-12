<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Copilot;

use Joomla\Github\Package\Copilot\TeamCustomizations;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Copilot\TeamCustomizations.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(TeamCustomizations::class)]
class TeamCustomizationsTest extends GitHubTestCase
{
    /**
     * @var    TeamCustomizations  Object under test.
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

        $this->object = new TeamCustomizations($this->options, $this->client);
    }

    /**
     * Tests the get method.
     *
     * @return  void
     */
    public function testGet(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/teams/core/copilot/customizations', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->get('joomla', 'core')
        );
    }

    /**
     * Tests the get method.
     *
     * @return  void
     */
    public function testGetFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/teams/core/copilot/customizations', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->get('joomla', 'core');
    }

    /**
     * Tests the set method.
     *
     * @return  void
     */
    public function testSet(): void
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/teams/core/copilot/customizations', json_encode(['pluginAssignments' => 'value']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->set('joomla', 'core', ['pluginAssignments' => 'value'])
        );
    }

    /**
     * Tests the set method.
     *
     * @return  void
     */
    public function testSetFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/teams/core/copilot/customizations', json_encode(['pluginAssignments' => 'value']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->set('joomla', 'core', ['pluginAssignments' => 'value']);
    }

    /**
     * Tests the delete method.
     *
     * @return  void
     */
    public function testDelete(): void
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/teams/core/copilot/customizations', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 204));

        $this->assertNull($this->object->delete('joomla', 'core'));
    }

    /**
     * Tests the delete method.
     *
     * @return  void
     */
    public function testDeleteFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/teams/core/copilot/customizations', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->delete('joomla', 'core');
    }
}
