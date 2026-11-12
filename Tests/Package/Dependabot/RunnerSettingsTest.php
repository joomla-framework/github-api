<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Dependabot;

use Joomla\Github\Package\Dependabot\RunnerSettings;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Dependabot\RunnerSettings.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(RunnerSettings::class)]
class RunnerSettingsTest extends GitHubTestCase
{
    /**
     * @var    RunnerSettings  Object under test.
     * @since  __DEPLOY_VERSION__
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new RunnerSettings($this->options, $this->client);
    }

    /**
     * Tests the get method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/dependabot/runner-settings', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->get('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the get method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/dependabot/runner-settings', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->get('joomla', 'joomla-platform');
    }

    /**
     * Tests the set method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testSet()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/dependabot/runner-settings', json_encode(['runner_labels' => ['self-hosted'], 'runner_type' => 'labeled']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->set('joomla', 'joomla-platform', 'labeled', ['runner_labels' => ['self-hosted']])
        );
    }

    /**
     * Tests the set method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testSetFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/dependabot/runner-settings', json_encode(['runner_type' => 'labeled']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->set('joomla', 'joomla-platform', 'labeled');
    }
}
