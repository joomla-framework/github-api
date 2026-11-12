<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Secret Scanning class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/secret-scanning
 *
 * @since  __DEPLOY_VERSION__
 *
 * @property-read  SecretScanning\CustomPatterns  $customPatterns  GitHub API object for secret scanning custom patterns.
 * @property-read  SecretScanning\PushProtection  $pushProtection  GitHub API object for secret scanning push protection pattern configurations.
 */
class SecretScanning extends AbstractPackage
{
    /**
     * List secret scanning alerts for an organization.
     *
     * @param   string   $org      The organization name.
     * @param   array    $filters  Optional query parameters: `state`, `secret_type`, `exclude_secret_types`, `exclude_providers`, `providers`, `resolution`, `assignee`, `sort`, `direction`, `before`, `after`, `validity`, `is_publicly_leaked`, `is_multi_repo`, `hide_secret`, `is_bypassed`, `included_metadata`, `owner_email_hash`.
     * @param   integer  $page     The page number to fetch.
     * @param   integer  $limit    The number of results per page (max 100).
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/secret-scanning/secret-scanning#list-secret-scanning-alerts-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getListForOrg(string $org, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/secret-scanning/alerts';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse(
            $this->client->get($uri),
            200
        );
    }

    /**
     * List secret scanning alerts for a repository.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   array    $filters  Optional query parameters: `state`, `secret_type`, `exclude_secret_types`, `exclude_providers`, `providers`, `resolution`, `assignee`, `sort`, `direction`, `before`, `after`, `validity`, `is_publicly_leaked`, `is_multi_repo`, `hide_secret`, `is_bypassed`, `included_metadata`, `owner_email_hash`.
     * @param   integer  $page     The page number to fetch.
     * @param   integer  $limit    The number of results per page (max 100).
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/secret-scanning/secret-scanning#list-secret-scanning-alerts-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getListForRepo(string $owner, string $repo, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/secret-scanning/alerts';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse(
            $this->client->get($uri),
            200
        );
    }

    /**
     * Get a secret scanning alert.
     *
     * @param   string   $owner        The account owner of the repository.
     * @param   string   $repo         The name of the repository.
     * @param   integer  $alertNumber  The number that identifies the alert.
     * @param   array    $filters      Optional query parameters: `hide_secret`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/secret-scanning/secret-scanning#get-a-secret-scanning-alert
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $owner, string $repo, int $alertNumber, array $filters = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/secret-scanning/alerts/' . $alertNumber;

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse(
            $this->client->get($uri),
            200
        );
    }

    /**
     * Update a secret scanning alert.
     *
     * At least one of `state`, `assignee` or `validity` must be given.
     *
     * @param   string   $owner        The account owner of the repository.
     * @param   string   $repo         The name of the repository.
     * @param   integer  $alertNumber  The number that identifies the alert.
     * @param   array    $options      Optional body fields: `state`, `resolution`, `resolution_comment`, `assignee`, `validity`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/secret-scanning/secret-scanning#update-a-secret-scanning-alert
     * @since   __DEPLOY_VERSION__
     */
    public function edit(string $owner, string $repo, int $alertNumber, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/secret-scanning/alerts/' . $alertNumber;

        $data = (object) $options;

        return $this->processResponse(
            $this->client->patch($this->fetchUrl($path), json_encode($data)),
            200
        );
    }

    /**
     * List locations for a secret scanning alert.
     *
     * @param   string   $owner        The account owner of the repository.
     * @param   string   $repo         The name of the repository.
     * @param   integer  $alertNumber  The number that identifies the alert.
     * @param   integer  $page         The page number to fetch.
     * @param   integer  $limit        The number of results per page (max 100).
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/secret-scanning/secret-scanning#list-locations-for-a-secret-scanning-alert
     * @since   __DEPLOY_VERSION__
     */
    public function getLocations(string $owner, string $repo, int $alertNumber, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/secret-scanning/alerts/' . $alertNumber . '/locations';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path, $page, $limit)),
            200
        );
    }

    /**
     * Create a push protection bypass.
     *
     * @param   string  $owner          The account owner of the repository.
     * @param   string  $repo           The name of the repository.
     * @param   string  $reason         Why the secret is pushed: `false_positive`, `used_in_tests` or `will_fix_later`.
     * @param   string  $placeholderId  The ID of the push protection bypass placeholder.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/secret-scanning/secret-scanning#create-a-push-protection-bypass
     * @since   __DEPLOY_VERSION__
     */
    public function createPushProtectionBypass(string $owner, string $repo, string $reason, string $placeholderId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/secret-scanning/push-protection-bypasses';

        $data = ['reason' => $reason, 'placeholder_id' => $placeholderId];

        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), json_encode($data)),
            200
        );
    }

    /**
     * Get secret scanning scan history for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/secret-scanning/secret-scanning#get-secret-scanning-scan-history-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getScanHistory(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/secret-scanning/scan-history';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }
}
