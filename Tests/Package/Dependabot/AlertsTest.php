<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Dependabot;

use Joomla\Github\Package\Dependabot\Alerts;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Dependabot\Alerts.
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
            ->with('/orgs/joomla/dependabot/alerts?per_page=30&state=open', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForOrg('joomla', ['state' => 'open'], 30)
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
            ->with('/orgs/joomla/dependabot/alerts', [], 0)
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
            ->with('/repos/joomla/joomla-platform/dependabot/alerts?per_page=30&severity=high', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForRepo('joomla', 'joomla-platform', ['severity' => 'high'], 30)
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
            ->with('/repos/joomla/joomla-platform/dependabot/alerts', [], 0)
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
            ->with('/repos/joomla/joomla-platform/dependabot/alerts/42', [], 0)
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
            ->with('/repos/joomla/joomla-platform/dependabot/alerts/42', [], 0)
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
            ->with('/repos/joomla/joomla-platform/dependabot/alerts/42', json_encode(['state' => 'dismissed', 'dismissed_reason' => 'tolerable_risk']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->edit('joomla', 'joomla-platform', 42, ['state' => 'dismissed', 'dismissed_reason' => 'tolerable_risk'])
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
            ->with('/repos/joomla/joomla-platform/dependabot/alerts/42', '{}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->edit('joomla', 'joomla-platform', 42);
    }
}
