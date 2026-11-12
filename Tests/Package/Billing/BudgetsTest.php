<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Billing;

use Joomla\Github\Package\Billing\Budgets;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Billing\Budgets.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Budgets::class)]
class BudgetsTest extends GitHubTestCase
{
    /**
     * @var    Budgets  Object under test.
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

        $this->object = new Budgets($this->options, $this->client);
    }

    /**
     * Tests the getListForOrg method.
     *
     * @return  void
     */
    public function testGetListForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/organizations/joomla/settings/billing/budgets?page=2&per_page=10&scope=organization', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForOrg('joomla', ['scope' => 'organization'], 2, 10)
        );
    }

    /**
     * Tests the getListForOrg method.
     *
     * @return  void
     */
    public function testGetListForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/organizations/joomla/settings/billing/budgets?page=2&per_page=10&scope=organization', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getListForOrg('joomla', ['scope' => 'organization'], 2, 10);
    }

    /**
     * Tests the createForOrg method.
     *
     * @return  void
     */
    public function testCreateForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/organizations/joomla/settings/billing/budgets', json_encode(['budget_amount' => 'value']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createForOrg('joomla', ['budget_amount' => 'value'])
        );
    }

    /**
     * Tests the createForOrg method.
     *
     * @return  void
     */
    public function testCreateForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/organizations/joomla/settings/billing/budgets', json_encode(['budget_amount' => 'value']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->createForOrg('joomla', ['budget_amount' => 'value']);
    }

    /**
     * Tests the getForOrg method.
     *
     * @return  void
     */
    public function testGetForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/organizations/joomla/settings/billing/budgets/abc123', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getForOrg('joomla', 'abc123')
        );
    }

    /**
     * Tests the getForOrg method.
     *
     * @return  void
     */
    public function testGetForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/organizations/joomla/settings/billing/budgets/abc123', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getForOrg('joomla', 'abc123');
    }

    /**
     * Tests the editForOrg method.
     *
     * @return  void
     */
    public function testEditForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/organizations/joomla/settings/billing/budgets/abc123', json_encode(['budget_amount' => 'value']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->editForOrg('joomla', 'abc123', ['budget_amount' => 'value'])
        );
    }

    /**
     * Tests the editForOrg method.
     *
     * @return  void
     */
    public function testEditForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/organizations/joomla/settings/billing/budgets/abc123', json_encode(['budget_amount' => 'value']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->editForOrg('joomla', 'abc123', ['budget_amount' => 'value']);
    }

    /**
     * Tests the deleteForOrg method.
     *
     * @return  void
     */
    public function testDeleteForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/organizations/joomla/settings/billing/budgets/abc123', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->deleteForOrg('joomla', 'abc123')
        );
    }

    /**
     * Tests the deleteForOrg method.
     *
     * @return  void
     */
    public function testDeleteForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/organizations/joomla/settings/billing/budgets/abc123', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->deleteForOrg('joomla', 'abc123');
    }
}
