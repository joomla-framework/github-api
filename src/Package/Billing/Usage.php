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
 * GitHub API Billing Usage class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/billing/usage
 *
 * @since  __DEPLOY_VERSION__
 */
class Usage extends AbstractPackage
{
    /**
     * Get the billing AI credit usage report for an organisation.
     *
     * @param   string  $org      The organisation name.
     * @param   array   $filters  Optional query parameters: `year`, `month`, `day`, `user`, `model`, `product`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/billing/usage#get-billing-ai-credit-usage-report-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getAiCreditReportForOrg(string $org, array $filters = [])
    {
        // Build the request path.
        $path = '/organizations/' . $org . '/settings/billing/ai_credit/usage';

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get the billing premium request usage report for an organisation.
     *
     * @param   string  $org      The organisation name.
     * @param   array   $filters  Optional query parameters: `year`, `month`, `day`, `user`, `model`, `product`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/billing/usage#get-billing-premium-request-usage-report-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getPremiumRequestReportForOrg(string $org, array $filters = [])
    {
        // Build the request path.
        $path = '/organizations/' . $org . '/settings/billing/premium_request/usage';

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get the billing usage report for an organisation.
     *
     * @param   string  $org      The organisation name.
     * @param   array   $filters  Optional query parameters: `year`, `month`, `day`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/billing/usage#get-billing-usage-report-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getReportForOrg(string $org, array $filters = [])
    {
        // Build the request path.
        $path = '/organizations/' . $org . '/settings/billing/usage';

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get the billing usage summary for an organisation.
     *
     * @param   string  $org      The organisation name.
     * @param   array   $filters  Optional query parameters: `year`, `month`, `day`, `repository`, `product`, `sku`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/billing/usage#get-billing-usage-summary-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getSummaryForOrg(string $org, array $filters = [])
    {
        // Build the request path.
        $path = '/organizations/' . $org . '/settings/billing/usage/summary';

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get the billing AI credit usage report for a user.
     *
     * @param   string  $username  The handle for the GitHub user account.
     * @param   array   $filters   Optional query parameters: `year`, `month`, `day`, `model`, `product`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/billing/usage#get-billing-ai-credit-usage-report-for-a-user
     * @since   __DEPLOY_VERSION__
     */
    public function getAiCreditReportForUser(string $username, array $filters = [])
    {
        // Build the request path.
        $path = '/users/' . $username . '/settings/billing/ai_credit/usage';

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get the billing premium request usage report for a user.
     *
     * @param   string  $username  The handle for the GitHub user account.
     * @param   array   $filters   Optional query parameters: `year`, `month`, `day`, `model`, `product`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/billing/usage#get-billing-premium-request-usage-report-for-a-user
     * @since   __DEPLOY_VERSION__
     */
    public function getPremiumRequestReportForUser(string $username, array $filters = [])
    {
        // Build the request path.
        $path = '/users/' . $username . '/settings/billing/premium_request/usage';

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get the billing usage report for a user.
     *
     * @param   string  $username  The handle for the GitHub user account.
     * @param   array   $filters   Optional query parameters: `year`, `month`, `day`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/billing/usage#get-billing-usage-report-for-a-user
     * @since   __DEPLOY_VERSION__
     */
    public function getReportForUser(string $username, array $filters = [])
    {
        // Build the request path.
        $path = '/users/' . $username . '/settings/billing/usage';

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get the billing usage summary for a user.
     *
     * @param   string  $username  The handle for the GitHub user account.
     * @param   array   $filters   Optional query parameters: `year`, `month`, `day`, `repository`, `product`, `sku`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/billing/usage#get-billing-usage-summary-for-a-user
     * @since   __DEPLOY_VERSION__
     */
    public function getSummaryForUser(string $username, array $filters = [])
    {
        // Build the request path.
        $path = '/users/' . $username . '/settings/billing/usage/summary';

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }
}
