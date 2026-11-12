<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\CodeScanning;

use Joomla\Github\Package\CodeScanning\DefaultSetup;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for CodeScanning\DefaultSetup.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(DefaultSetup::class)]
class DefaultSetupTest extends GitHubTestCase
{
    /**
     * @var    DefaultSetup  Object under test.
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

        $this->object = new DefaultSetup($this->options, $this->client);
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
            ->with('/repos/joomla/joomla-platform/code-scanning/default-setup', [], 0)
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
            ->with('/repos/joomla/joomla-platform/code-scanning/default-setup', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->get('joomla', 'joomla-platform');
    }

    /**
     * Tests the edit method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testEdit()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/code-scanning/default-setup', json_encode(['state' => 'configured', 'query_suite' => 'extended']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->edit('joomla', 'joomla-platform', ['state' => 'configured', 'query_suite' => 'extended'])
        );
    }

    /**
     * Tests the edit method with a 202 response.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testEdit202()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/code-scanning/default-setup', json_encode(['state' => 'configured', 'query_suite' => 'extended']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 202));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->edit('joomla', 'joomla-platform', ['state' => 'configured', 'query_suite' => 'extended'])
        );
    }

    /**
     * Tests the edit method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testEditFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/code-scanning/default-setup', '{}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->edit('joomla', 'joomla-platform');
    }
}
