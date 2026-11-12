<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Apps;

use Joomla\Github\Package\Apps\Marketplace;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Apps\Marketplace.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Marketplace::class)]
class MarketplaceTest extends GitHubTestCase
{
    /**
     * @var    Marketplace  Object under test.
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

        $this->object = new Marketplace($this->options, $this->client);
    }

    /**
     * Tests the getSubscriptionPlanForAccount method.
     *
     * @return  void
     */
    public function testGetSubscriptionPlanForAccount()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/marketplace_listing/accounts/3', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getSubscriptionPlanForAccount(3)
        );
    }

    /**
     * Tests the getSubscriptionPlanForAccount method - failure.
     *
     * @return  void
     */
    public function testGetSubscriptionPlanForAccountFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getSubscriptionPlanForAccount(3);
    }

    /**
     * Tests the getListPlans method.
     *
     * @return  void
     */
    public function testGetListPlans()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/marketplace_listing/plans?page=2&per_page=10', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListPlans(2, 10)
        );
    }

    /**
     * Tests the getListPlans method - failure.
     *
     * @return  void
     */
    public function testGetListPlansFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListPlans(2, 10);
    }

    /**
     * Tests the getListAccountsForPlan method.
     *
     * @return  void
     */
    public function testGetListAccountsForPlan()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/marketplace_listing/plans/2/accounts?page=2&per_page=10&sort=updated&direction=asc', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListAccountsForPlan(2, ['sort' => 'updated', 'direction' => 'asc'], 2, 10)
        );
    }

    /**
     * Tests the getListAccountsForPlan method - failure.
     *
     * @return  void
     */
    public function testGetListAccountsForPlanFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListAccountsForPlan(2, ['sort' => 'updated', 'direction' => 'asc'], 2, 10);
    }

    /**
     * Tests the getSubscriptionPlanForAccountStubbed method.
     *
     * @return  void
     */
    public function testGetSubscriptionPlanForAccountStubbed()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/marketplace_listing/stubbed/accounts/3', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getSubscriptionPlanForAccountStubbed(3)
        );
    }

    /**
     * Tests the getSubscriptionPlanForAccountStubbed method - failure.
     *
     * @return  void
     */
    public function testGetSubscriptionPlanForAccountStubbedFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getSubscriptionPlanForAccountStubbed(3);
    }

    /**
     * Tests the getListPlansStubbed method.
     *
     * @return  void
     */
    public function testGetListPlansStubbed()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/marketplace_listing/stubbed/plans?page=2&per_page=10', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListPlansStubbed(2, 10)
        );
    }

    /**
     * Tests the getListPlansStubbed method - failure.
     *
     * @return  void
     */
    public function testGetListPlansStubbedFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListPlansStubbed(2, 10);
    }

    /**
     * Tests the getListAccountsForPlanStubbed method.
     *
     * @return  void
     */
    public function testGetListAccountsForPlanStubbed()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/marketplace_listing/stubbed/plans/2/accounts?page=2&per_page=10&sort=created', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListAccountsForPlanStubbed(2, ['sort' => 'created'], 2, 10)
        );
    }

    /**
     * Tests the getListAccountsForPlanStubbed method - failure.
     *
     * @return  void
     */
    public function testGetListAccountsForPlanStubbedFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListAccountsForPlanStubbed(2, ['sort' => 'created'], 2, 10);
    }

    /**
     * Tests the getListSubscriptionsForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testGetListSubscriptionsForAuthenticatedUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/marketplace_purchases?page=2&per_page=10', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListSubscriptionsForAuthenticatedUser(2, 10)
        );
    }

    /**
     * Tests the getListSubscriptionsForAuthenticatedUser method - failure.
     *
     * @return  void
     */
    public function testGetListSubscriptionsForAuthenticatedUserFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListSubscriptionsForAuthenticatedUser(2, 10);
    }

    /**
     * Tests the getListSubscriptionsForAuthenticatedUserStubbed method.
     *
     * @return  void
     */
    public function testGetListSubscriptionsForAuthenticatedUserStubbed()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/marketplace_purchases/stubbed?page=2&per_page=10', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListSubscriptionsForAuthenticatedUserStubbed(2, 10)
        );
    }

    /**
     * Tests the getListSubscriptionsForAuthenticatedUserStubbed method - failure.
     *
     * @return  void
     */
    public function testGetListSubscriptionsForAuthenticatedUserStubbedFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListSubscriptionsForAuthenticatedUserStubbed(2, 10);
    }
}
