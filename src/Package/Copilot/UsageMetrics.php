<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Copilot;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Copilot usage metrics class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/copilot/copilot-usage-metrics
 *
 * @since  __DEPLOY_VERSION__
 */
class UsageMetrics extends AbstractPackage
{
    /**
     * Get Copilot organisation usage metrics for a specific day.
     *
     * @param   string  $org  The organisation name.
     * @param   string  $day  The day to request data for, in `YYYY-MM-DD` format.
     *
     * @return  object|array|null  Null when GitHub answers 204 No Content.
     *
     * @link    https://docs.github.com/rest/copilot/copilot-usage-metrics#get-copilot-organization-usage-metrics-for-a-specific-day
     * @since   __DEPLOY_VERSION__
     */
    public function getOrganizationReport(string $org, string $day)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/metrics/reports/organization-1-day';

        $uri = $this->fetchUrl($path);
        $uri->setVar('day', $day);

        $response = $this->client->get($uri);

        return $this->processResponse(
            $response,
            \in_array($response->getStatusCode(), [200, 204], true) ? $response->getStatusCode() : 200
        );
    }

    /**
     * Get the latest 28-day Copilot organisation usage metrics.
     *
     * @param   string  $org  The organisation name.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-usage-metrics#get-copilot-organization-usage-metrics
     * @since   __DEPLOY_VERSION__
     */
    public function getOrganizationLatestReport(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/metrics/reports/organization-28-day/latest';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Get the Copilot organisation repository report for a specific day.
     *
     * @param   string  $org  The organisation name.
     * @param   string  $day  The day to request data for, in `YYYY-MM-DD` format.
     *
     * @return  object|array|null  Null when GitHub answers 204 No Content.
     *
     * @link    https://docs.github.com/rest/copilot/copilot-usage-metrics#get-copilot-organization-repository-report-for-a-specific-day
     * @since   __DEPLOY_VERSION__
     */
    public function getRepositoriesReport(string $org, string $day)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/metrics/reports/repos-1-day';

        $uri = $this->fetchUrl($path);
        $uri->setVar('day', $day);

        $response = $this->client->get($uri);

        return $this->processResponse(
            $response,
            \in_array($response->getStatusCode(), [200, 204], true) ? $response->getStatusCode() : 200
        );
    }

    /**
     * Get the Copilot organisation user-teams report for a specific day.
     *
     * @param   string  $org  The organisation name.
     * @param   string  $day  The day to request data for, in `YYYY-MM-DD` format.
     *
     * @return  object|array|null  Null when GitHub answers 204 No Content.
     *
     * @link    https://docs.github.com/rest/copilot/copilot-usage-metrics#get-copilot-organization-user-teams-report-for-a-specific-day
     * @since   __DEPLOY_VERSION__
     */
    public function getUserTeamsReport(string $org, string $day)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/metrics/reports/user-teams-1-day';

        $uri = $this->fetchUrl($path);
        $uri->setVar('day', $day);

        $response = $this->client->get($uri);

        return $this->processResponse(
            $response,
            \in_array($response->getStatusCode(), [200, 204], true) ? $response->getStatusCode() : 200
        );
    }

    /**
     * Get Copilot organisation users usage metrics for a specific day.
     *
     * @param   string  $org  The organisation name.
     * @param   string  $day  The day to request data for, in `YYYY-MM-DD` format.
     *
     * @return  object|array|null  Null when GitHub answers 204 No Content.
     *
     * @link    https://docs.github.com/rest/copilot/copilot-usage-metrics#get-copilot-organization-users-usage-metrics-for-a-specific-day
     * @since   __DEPLOY_VERSION__
     */
    public function getUsersReport(string $org, string $day)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/metrics/reports/users-1-day';

        $uri = $this->fetchUrl($path);
        $uri->setVar('day', $day);

        $response = $this->client->get($uri);

        return $this->processResponse(
            $response,
            \in_array($response->getStatusCode(), [200, 204], true) ? $response->getStatusCode() : 200
        );
    }

    /**
     * Get the latest 28-day Copilot organisation users usage metrics.
     *
     * @param   string  $org  The organisation name.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-usage-metrics#get-copilot-organization-users-usage-metrics
     * @since   __DEPLOY_VERSION__
     */
    public function getUsersLatestReport(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/metrics/reports/users-28-day/latest';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }
}
