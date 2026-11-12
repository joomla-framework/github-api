<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Copilot;

use Joomla\Github\Package\Copilot\UsageMetrics;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Copilot\UsageMetrics.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(UsageMetrics::class)]
class UsageMetricsTest extends GitHubTestCase
{
    /**
     * @var    UsageMetrics  Object under test.
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

        $this->object = new UsageMetrics($this->options, $this->client);
    }

    /**
     * Tests the getOrganizationReport method.
     *
     * @return  void
     */
    public function testGetOrganizationReport(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/metrics/reports/organization-1-day?day=2026-01-01', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getOrganizationReport('joomla', '2026-01-01')
        );
    }

    /**
     * Tests the getOrganizationReport method.
     *
     * @return  void
     */
    public function testGetOrganizationReportWithStatus204(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/metrics/reports/organization-1-day?day=2026-01-01', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->getOrganizationReport('joomla', '2026-01-01'));
    }

    /**
     * Tests the getOrganizationReport method.
     *
     * @return  void
     */
    public function testGetOrganizationReportFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/metrics/reports/organization-1-day?day=2026-01-01', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getOrganizationReport('joomla', '2026-01-01');
    }

    /**
     * Tests the getOrganizationLatestReport method.
     *
     * @return  void
     */
    public function testGetOrganizationLatestReport(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/metrics/reports/organization-28-day/latest', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getOrganizationLatestReport('joomla')
        );
    }

    /**
     * Tests the getOrganizationLatestReport method.
     *
     * @return  void
     */
    public function testGetOrganizationLatestReportFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/metrics/reports/organization-28-day/latest', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getOrganizationLatestReport('joomla');
    }

    /**
     * Tests the getRepositoriesReport method.
     *
     * @return  void
     */
    public function testGetRepositoriesReport(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/metrics/reports/repos-1-day?day=2026-01-01', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getRepositoriesReport('joomla', '2026-01-01')
        );
    }

    /**
     * Tests the getRepositoriesReport method.
     *
     * @return  void
     */
    public function testGetRepositoriesReportWithStatus204(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/metrics/reports/repos-1-day?day=2026-01-01', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->getRepositoriesReport('joomla', '2026-01-01'));
    }

    /**
     * Tests the getRepositoriesReport method.
     *
     * @return  void
     */
    public function testGetRepositoriesReportFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/metrics/reports/repos-1-day?day=2026-01-01', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getRepositoriesReport('joomla', '2026-01-01');
    }

    /**
     * Tests the getUserTeamsReport method.
     *
     * @return  void
     */
    public function testGetUserTeamsReport(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/metrics/reports/user-teams-1-day?day=2026-01-01', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getUserTeamsReport('joomla', '2026-01-01')
        );
    }

    /**
     * Tests the getUserTeamsReport method.
     *
     * @return  void
     */
    public function testGetUserTeamsReportWithStatus204(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/metrics/reports/user-teams-1-day?day=2026-01-01', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->getUserTeamsReport('joomla', '2026-01-01'));
    }

    /**
     * Tests the getUserTeamsReport method.
     *
     * @return  void
     */
    public function testGetUserTeamsReportFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/metrics/reports/user-teams-1-day?day=2026-01-01', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getUserTeamsReport('joomla', '2026-01-01');
    }

    /**
     * Tests the getUsersReport method.
     *
     * @return  void
     */
    public function testGetUsersReport(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/metrics/reports/users-1-day?day=2026-01-01', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getUsersReport('joomla', '2026-01-01')
        );
    }

    /**
     * Tests the getUsersReport method.
     *
     * @return  void
     */
    public function testGetUsersReportWithStatus204(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/metrics/reports/users-1-day?day=2026-01-01', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->getUsersReport('joomla', '2026-01-01'));
    }

    /**
     * Tests the getUsersReport method.
     *
     * @return  void
     */
    public function testGetUsersReportFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/metrics/reports/users-1-day?day=2026-01-01', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getUsersReport('joomla', '2026-01-01');
    }

    /**
     * Tests the getUsersLatestReport method.
     *
     * @return  void
     */
    public function testGetUsersLatestReport(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/metrics/reports/users-28-day/latest', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getUsersLatestReport('joomla')
        );
    }

    /**
     * Tests the getUsersLatestReport method.
     *
     * @return  void
     */
    public function testGetUsersLatestReportFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/metrics/reports/users-28-day/latest', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getUsersLatestReport('joomla');
    }
}
