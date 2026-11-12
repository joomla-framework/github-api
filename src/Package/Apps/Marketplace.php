<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Apps;

use Joomla\Github\AbstractPackage;
use Joomla\Http\Exception\UnexpectedResponseException;

/**
 * GitHub API Apps Marketplace class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/apps/marketplace
 *
 * @since  __DEPLOY_VERSION__
 */
class Marketplace extends AbstractPackage
{
    /**
     * Get a subscription plan for an account.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   integer  $accountId  Account identifier.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/marketplace#get-a-subscription-plan-for-an-account
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getSubscriptionPlanForAccount(int $accountId)
    {
        // Build the request path.
        $path = '/marketplace_listing/accounts/' . $accountId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * List plans.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/apps/marketplace#list-plans
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListPlans(int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/marketplace_listing/plans';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * List accounts for a plan.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   integer  $planId   Plan identifier.
     * @param   array    $filters  Optional query parameters: sort, direction.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/apps/marketplace#list-accounts-for-a-plan
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListAccountsForPlan(int $planId, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/marketplace_listing/plans/' . $planId . '/accounts';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get a subscription plan for an account (stubbed).
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   integer  $accountId  Account identifier.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/marketplace#get-a-subscription-plan-for-an-account-stubbed
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getSubscriptionPlanForAccountStubbed(int $accountId)
    {
        // Build the request path.
        $path = '/marketplace_listing/stubbed/accounts/' . $accountId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * List plans (stubbed).
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/apps/marketplace#list-plans-stubbed
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListPlansStubbed(int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/marketplace_listing/stubbed/plans';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * List accounts for a plan (stubbed).
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   integer  $planId   Plan identifier.
     * @param   array    $filters  Optional query parameters: sort, direction.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/apps/marketplace#list-accounts-for-a-plan-stubbed
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListAccountsForPlanStubbed(int $planId, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/marketplace_listing/stubbed/plans/' . $planId . '/accounts';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * List subscriptions for the authenticated user.
     *
     * Authenticate with a user access token.
     *
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/apps/marketplace#list-subscriptions-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListSubscriptionsForAuthenticatedUser(int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/user/marketplace_purchases';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * List subscriptions for the authenticated user (stubbed).
     *
     * Authenticate with a user access token.
     *
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/apps/marketplace#list-subscriptions-for-the-authenticated-user-stubbed
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListSubscriptionsForAuthenticatedUserStubbed(int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/user/marketplace_purchases/stubbed';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }
}
