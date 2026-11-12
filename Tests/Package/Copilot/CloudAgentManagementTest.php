<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Copilot;

use Joomla\Github\Package\Copilot\CloudAgentManagement;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Copilot\CloudAgentManagement.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(CloudAgentManagement::class)]
class CloudAgentManagementTest extends GitHubTestCase
{
    /**
     * @var    CloudAgentManagement  Object under test.
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

        $this->object = new CloudAgentManagement($this->options, $this->client);
    }

    /**
     * Tests the getConfiguration method.
     *
     * @return  void
     */
    public function testGetConfiguration(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/copilot/cloud-agent/configuration', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getConfiguration('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the getConfiguration method.
     *
     * @return  void
     */
    public function testGetConfigurationFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/copilot/cloud-agent/configuration', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getConfiguration('joomla', 'joomla-platform');
    }
}
