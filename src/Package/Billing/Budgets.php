<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Billing;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Billing Budgets class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/billing/budgets
 *
 * @since  __DEPLOY_VERSION__
 */
class Budgets extends AbstractPackage
{
    /**
     * Get all budgets for an organisation.
     *
     * @param   string  $org      The organisation name.
     * @param   array   $filters  Optional query parameters: `scope`, `user`.
     * @param   int     $page     The page number from which to get items.
     * @param   int     $limit    The number of items on a page.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/billing/budgets#get-all-budgets-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getListForOrg(string $org, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/organizations/' . $org . '/settings/billing/budgets';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Create a budget for an organisation.
     *
     * @param   string  $org      The organisation name.
     * @param   array   $options  Optional body fields: `budget_amount`, `prevent_further_usage`, `budget_alerting`, `budget_scope`, `budget_entity_name`, `budget_type`, `budget_product_sku`, `user`, `expires_at`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/billing/budgets#create-a-budget-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function createForOrg(string $org, array $options = [])
    {
        // Build the request path.
        $path = '/organizations/' . $org . '/settings/billing/budgets';

        $data = (object) $options;

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Get a budget by ID for an organisation.
     *
     * @param   string  $org       The organisation name.
     * @param   string  $budgetId  The ID of the budget.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/billing/budgets#get-a-budget-by-id-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getForOrg(string $org, string $budgetId)
    {
        // Build the request path.
        $path = '/organizations/' . $org . '/settings/billing/budgets/' . $budgetId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Update a budget for an organisation.
     *
     * @param   string  $org       The organisation name.
     * @param   string  $budgetId  The ID of the budget.
     * @param   array   $options   Optional body fields: `budget_amount`, `prevent_further_usage`, `budget_alerting`, `expires_at`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/billing/budgets#update-a-budget-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function editForOrg(string $org, string $budgetId, array $options = [])
    {
        // Build the request path.
        $path = '/organizations/' . $org . '/settings/billing/budgets/' . $budgetId;

        $data = (object) $options;

        return $this->processResponse($this->client->patch($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Delete a budget for an organisation.
     *
     * @param   string  $org       The organisation name.
     * @param   string  $budgetId  The ID of the budget.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/billing/budgets#delete-a-budget-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function deleteForOrg(string $org, string $budgetId)
    {
        // Build the request path.
        $path = '/organizations/' . $org . '/settings/billing/budgets/' . $budgetId;

        return $this->processResponse($this->client->delete($this->fetchUrl($path)));
    }
}
