<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\CodeScanning;

use Joomla\Github\Package\CodeScanning\AiScan;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for CodeScanning\AiScan.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(AiScan::class)]
class AiScanTest extends GitHubTestCase
{
    /**
     * @var    AiScan  Object under test.
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

        $this->object = new AiScan($this->options, $this->client);
    }

    /**
     * Tests the getForOrg method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/code-scanning/ai-scan', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getForOrg('joomla')
        );
    }

    /**
     * Tests the getForOrg method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/code-scanning/ai-scan', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getForOrg('joomla');
    }

    /**
     * Tests the editForOrg method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testEditForOrg()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/code-scanning/ai-scan', json_encode(['pr_scan' => 'enabled']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->editForOrg('joomla', ['pr_scan' => 'enabled'])
        );
    }

    /**
     * Tests the editForOrg method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testEditForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/code-scanning/ai-scan', '{}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->editForOrg('joomla');
    }

    /**
     * Tests the getForRepo method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/code-scanning/ai-scan', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getForRepo('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the getForRepo method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/code-scanning/ai-scan', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the editForRepo method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testEditForRepo()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/code-scanning/ai-scan', json_encode(['repository_scan' => 'disabled']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->editForRepo('joomla', 'joomla-platform', ['repository_scan' => 'disabled'])
        );
    }

    /**
     * Tests the editForRepo method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testEditForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/code-scanning/ai-scan', '{}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->editForRepo('joomla', 'joomla-platform');
    }
}
