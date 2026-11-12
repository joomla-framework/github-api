<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\CodeScanning;

use Joomla\Github\Package\CodeScanning\Alerts;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for CodeScanning\Alerts.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Alerts::class)]
class AlertsTest extends GitHubTestCase
{
    /**
     * @var    Alerts  Object under test.
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

        $this->object = new Alerts($this->options, $this->client);
    }

    /**
     * Tests the getListForOrg method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetListForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/code-scanning/alerts?page=2&per_page=30&state=open', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForOrg('joomla', ['state' => 'open'], 2, 30)
        );
    }

    /**
     * Tests the getListForOrg method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetListForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/code-scanning/alerts', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getListForOrg('joomla');
    }

    /**
     * Tests the getListForRepo method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetListForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/code-scanning/alerts?page=2&per_page=30&ref=main', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForRepo('joomla', 'joomla-platform', ['ref' => 'main'], 2, 30)
        );
    }

    /**
     * Tests the getListForRepo method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetListForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/code-scanning/alerts', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getListForRepo('joomla', 'joomla-platform');
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
            ->with('/repos/joomla/joomla-platform/code-scanning/alerts/42', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->get('joomla', 'joomla-platform', 42)
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
            ->with('/repos/joomla/joomla-platform/code-scanning/alerts/42', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->get('joomla', 'joomla-platform', 42);
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
            ->with('/repos/joomla/joomla-platform/code-scanning/alerts/42', json_encode(['state' => 'dismissed', 'dismissed_reason' => 'false positive']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->edit('joomla', 'joomla-platform', 42, ['state' => 'dismissed', 'dismissed_reason' => 'false positive'])
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
            ->with('/repos/joomla/joomla-platform/code-scanning/alerts/42', '{}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->edit('joomla', 'joomla-platform', 42);
    }

    /**
     * Tests the getInstances method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetInstances()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/code-scanning/alerts/42/instances?page=2&per_page=30&ref=main', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getInstances('joomla', 'joomla-platform', 42, ['ref' => 'main'], 2, 30)
        );
    }

    /**
     * Tests the getInstances method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetInstancesFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/code-scanning/alerts/42/instances', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getInstances('joomla', 'joomla-platform', 42);
    }
}
