<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Billing;

use Joomla\Github\Package\Billing\Usage;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Billing\Usage.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Usage::class)]
class UsageTest extends GitHubTestCase
{
    /**
     * @var    Usage  Object under test.
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

        $this->object = new Usage($this->options, $this->client);
    }

    /**
     * Tests the getAiCreditReportForOrg method.
     *
     * @return  void
     */
    public function testGetAiCreditReportForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/organizations/joomla/settings/billing/ai_credit/usage?year=2026', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getAiCreditReportForOrg('joomla', ['year' => 2026])
        );
    }

    /**
     * Tests the getAiCreditReportForOrg method.
     *
     * @return  void
     */
    public function testGetAiCreditReportForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/organizations/joomla/settings/billing/ai_credit/usage?year=2026', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getAiCreditReportForOrg('joomla', ['year' => 2026]);
    }

    /**
     * Tests the getPremiumRequestReportForOrg method.
     *
     * @return  void
     */
    public function testGetPremiumRequestReportForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/organizations/joomla/settings/billing/premium_request/usage?year=2026', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getPremiumRequestReportForOrg('joomla', ['year' => 2026])
        );
    }

    /**
     * Tests the getPremiumRequestReportForOrg method.
     *
     * @return  void
     */
    public function testGetPremiumRequestReportForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/organizations/joomla/settings/billing/premium_request/usage?year=2026', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getPremiumRequestReportForOrg('joomla', ['year' => 2026]);
    }

    /**
     * Tests the getReportForOrg method.
     *
     * @return  void
     */
    public function testGetReportForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/organizations/joomla/settings/billing/usage?year=2026', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getReportForOrg('joomla', ['year' => 2026])
        );
    }

    /**
     * Tests the getReportForOrg method.
     *
     * @return  void
     */
    public function testGetReportForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/organizations/joomla/settings/billing/usage?year=2026', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getReportForOrg('joomla', ['year' => 2026]);
    }

    /**
     * Tests the getSummaryForOrg method.
     *
     * @return  void
     */
    public function testGetSummaryForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/organizations/joomla/settings/billing/usage/summary?year=2026', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getSummaryForOrg('joomla', ['year' => 2026])
        );
    }

    /**
     * Tests the getSummaryForOrg method.
     *
     * @return  void
     */
    public function testGetSummaryForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/organizations/joomla/settings/billing/usage/summary?year=2026', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getSummaryForOrg('joomla', ['year' => 2026]);
    }

    /**
     * Tests the getAiCreditReportForUser method.
     *
     * @return  void
     */
    public function testGetAiCreditReportForUser(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/settings/billing/ai_credit/usage?year=2026', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getAiCreditReportForUser('octocat', ['year' => 2026])
        );
    }

    /**
     * Tests the getAiCreditReportForUser method.
     *
     * @return  void
     */
    public function testGetAiCreditReportForUserFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/settings/billing/ai_credit/usage?year=2026', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getAiCreditReportForUser('octocat', ['year' => 2026]);
    }

    /**
     * Tests the getPremiumRequestReportForUser method.
     *
     * @return  void
     */
    public function testGetPremiumRequestReportForUser(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/settings/billing/premium_request/usage?year=2026', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getPremiumRequestReportForUser('octocat', ['year' => 2026])
        );
    }

    /**
     * Tests the getPremiumRequestReportForUser method.
     *
     * @return  void
     */
    public function testGetPremiumRequestReportForUserFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/settings/billing/premium_request/usage?year=2026', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getPremiumRequestReportForUser('octocat', ['year' => 2026]);
    }

    /**
     * Tests the getReportForUser method.
     *
     * @return  void
     */
    public function testGetReportForUser(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/settings/billing/usage?year=2026', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getReportForUser('octocat', ['year' => 2026])
        );
    }

    /**
     * Tests the getReportForUser method.
     *
     * @return  void
     */
    public function testGetReportForUserFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/settings/billing/usage?year=2026', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getReportForUser('octocat', ['year' => 2026]);
    }

    /**
     * Tests the getSummaryForUser method.
     *
     * @return  void
     */
    public function testGetSummaryForUser(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/settings/billing/usage/summary?year=2026', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getSummaryForUser('octocat', ['year' => 2026])
        );
    }

    /**
     * Tests the getSummaryForUser method.
     *
     * @return  void
     */
    public function testGetSummaryForUserFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/settings/billing/usage/summary?year=2026', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getSummaryForUser('octocat', ['year' => 2026]);
    }
}
