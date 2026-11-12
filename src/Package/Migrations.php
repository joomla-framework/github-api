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
 * GitHub API Migrations class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/migrations
 *
 * @since  __DEPLOY_VERSION__
 */
class Migrations extends AbstractPackage
{
    /**
     * List organisation migrations.
     *
     * @param   string  $org      The organisation name.
     * @param   array   $filters  Optional query parameters: `exclude`.
     * @param   int     $page     The page number from which to get items.
     * @param   int     $limit    The number of items on a page.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/migrations/orgs#list-organization-migrations
     * @since   __DEPLOY_VERSION__
     */
    public function getListForOrg(string $org, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/migrations';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            if (\is_array($value)) {
                $value = implode(',', $value);
            }

            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Start an organisation migration.
     *
     * @param   string  $org           The organisation name.
     * @param   array   $repositories  List of repository names to migrate.
     * @param   array   $options       Optional body fields: `lock_repositories`, `exclude_metadata`, `exclude_git_data`, `exclude_attachments`, `exclude_releases`, `exclude_owner_projects`, `org_metadata_only`, `exclude`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/migrations/orgs#start-an-organization-migration
     * @since   __DEPLOY_VERSION__
     */
    public function startForOrg(string $org, array $repositories, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/migrations';

        $data = array_merge($options, ['repositories' => $repositories]);

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Get an organisation migration status.
     *
     * @param   string  $org          The organisation name.
     * @param   int     $migrationId  The unique identifier of the migration.
     * @param   array   $filters      Optional query parameters: `exclude`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/migrations/orgs#get-an-organization-migration-status
     * @since   __DEPLOY_VERSION__
     */
    public function getStatusForOrg(string $org, int $migrationId, array $filters = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/migrations/' . $migrationId;

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            if (\is_array($value)) {
                $value = implode(',', $value);
            }

            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Download an organisation migration archive.
     *
     * @param   string  $org          The organisation name.
     * @param   int     $migrationId  The unique identifier of the migration.
     *
     * @return  string  The URL of the archive (the `Location` of the redirect).
     *
     * @link    https://docs.github.com/rest/migrations/orgs#download-an-organization-migration-archive
     * @since   __DEPLOY_VERSION__
     */
    public function downloadArchiveForOrg(string $org, int $migrationId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/migrations/' . $migrationId . '/archive';

        $response = $this->client->get($this->fetchUrl($path));

        if ($response->getStatusCode() !== 302) {
            $this->processResponse($response, 302);
        }

        return $response->getHeaderLine('Location');
    }

    /**
     * Delete an organisation migration archive.
     *
     * @param   string  $org          The organisation name.
     * @param   int     $migrationId  The unique identifier of the migration.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/migrations/orgs#delete-an-organization-migration-archive
     * @since   __DEPLOY_VERSION__
     */
    public function deleteArchiveForOrg(string $org, int $migrationId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/migrations/' . $migrationId . '/archive';

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Unlock an organisation repository.
     *
     * @param   string  $org          The organisation name.
     * @param   int     $migrationId  The unique identifier of the migration.
     * @param   string  $repoName     The name of the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/migrations/orgs#unlock-an-organization-repository
     * @since   __DEPLOY_VERSION__
     */
    public function unlockRepoForOrg(string $org, int $migrationId, string $repoName)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/migrations/' . $migrationId . '/repos/' . $repoName . '/lock';

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List repositories in an organisation migration.
     *
     * @param   string  $org          The organisation name.
     * @param   int     $migrationId  The unique identifier of the migration.
     * @param   int     $page         The page number from which to get items.
     * @param   int     $limit        The number of items on a page.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/migrations/orgs#list-repositories-in-an-organization-migration
     * @since   __DEPLOY_VERSION__
     */
    public function getRepositoriesForOrg(string $org, int $migrationId, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/migrations/' . $migrationId . '/repositories';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * List user migrations.
     *
     * @param   int  $page   The page number from which to get items.
     * @param   int  $limit  The number of items on a page.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/migrations/users#list-user-migrations
     * @since   __DEPLOY_VERSION__
     */
    public function getListForAuthenticatedUser(int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/user/migrations';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Start a user migration.
     *
     * @param   array  $repositories  List of repository names to migrate.
     * @param   array  $options       Optional body fields: `lock_repositories`, `exclude_metadata`, `exclude_git_data`, `exclude_attachments`, `exclude_releases`, `exclude_owner_projects`, `org_metadata_only`, `exclude`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/migrations/users#start-a-user-migration
     * @since   __DEPLOY_VERSION__
     */
    public function startForAuthenticatedUser(array $repositories, array $options = [])
    {
        // Build the request path.
        $path = '/user/migrations';

        $data = array_merge($options, ['repositories' => $repositories]);

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Get a user migration status.
     *
     * @param   int    $migrationId  The unique identifier of the migration.
     * @param   array  $filters      Optional query parameters: `exclude`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/migrations/users#get-a-user-migration-status
     * @since   __DEPLOY_VERSION__
     */
    public function getStatusForAuthenticatedUser(int $migrationId, array $filters = [])
    {
        // Build the request path.
        $path = '/user/migrations/' . $migrationId;

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            if (\is_array($value)) {
                $value = implode(',', $value);
            }

            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Download a user migration archive.
     *
     * @param   int  $migrationId  The unique identifier of the migration.
     *
     * @return  string  The URL of the archive (the `Location` of the redirect).
     *
     * @link    https://docs.github.com/rest/migrations/users#download-a-user-migration-archive
     * @since   __DEPLOY_VERSION__
     */
    public function downloadArchiveForAuthenticatedUser(int $migrationId)
    {
        // Build the request path.
        $path = '/user/migrations/' . $migrationId . '/archive';

        $response = $this->client->get($this->fetchUrl($path));

        if ($response->getStatusCode() !== 302) {
            $this->processResponse($response, 302);
        }

        return $response->getHeaderLine('Location');
    }

    /**
     * Delete a user migration archive.
     *
     * @param   int  $migrationId  The unique identifier of the migration.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/migrations/users#delete-a-user-migration-archive
     * @since   __DEPLOY_VERSION__
     */
    public function deleteArchiveForAuthenticatedUser(int $migrationId)
    {
        // Build the request path.
        $path = '/user/migrations/' . $migrationId . '/archive';

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Unlock a user repository.
     *
     * @param   int     $migrationId  The unique identifier of the migration.
     * @param   string  $repoName     The name of the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/migrations/users#unlock-a-user-repository
     * @since   __DEPLOY_VERSION__
     */
    public function unlockRepoForAuthenticatedUser(int $migrationId, string $repoName)
    {
        // Build the request path.
        $path = '/user/migrations/' . $migrationId . '/repos/' . $repoName . '/lock';

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List repositories for a user migration.
     *
     * @param   int  $migrationId  The unique identifier of the migration.
     * @param   int  $page         The page number from which to get items.
     * @param   int  $limit        The number of items on a page.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/migrations/users#list-repositories-for-a-user-migration
     * @since   __DEPLOY_VERSION__
     */
    public function getRepositoriesForAuthenticatedUser(int $migrationId, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/user/migrations/' . $migrationId . '/repositories';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }
}
