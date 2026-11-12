<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Actions;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Actions Cache class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/actions/cache
 *
 * @since  __DEPLOY_VERSION__
 */
class Cache extends AbstractPackage
{
    /**
     * Get GitHub Actions cache retention limit for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/cache#get-github-actions-cache-retention-limit-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getRetentionLimitForOrg(string $org)
    {
        // Build the request path.
        $path = '/organizations/' . $org . '/actions/cache/retention-limit';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set GitHub Actions cache retention limit for an organization.
     *
     * @param   string  $org      The organization name.
     * @param   array   $options  Optional body fields: max_cache_retention_days.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/cache#set-github-actions-cache-retention-limit-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setRetentionLimitForOrg(string $org, array $options = [])
    {
        // Build the request path.
        $path = '/organizations/' . $org . '/actions/cache/retention-limit';

        $data = (object) $options;

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Get GitHub Actions cache storage limit for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/cache#get-github-actions-cache-storage-limit-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getStorageLimitForOrg(string $org)
    {
        // Build the request path.
        $path = '/organizations/' . $org . '/actions/cache/storage-limit';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set GitHub Actions cache storage limit for an organization.
     *
     * @param   string  $org      The organization name.
     * @param   array   $options  Optional body fields: max_cache_size_gb.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/cache#set-github-actions-cache-storage-limit-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setStorageLimitForOrg(string $org, array $options = [])
    {
        // Build the request path.
        $path = '/organizations/' . $org . '/actions/cache/storage-limit';

        $data = (object) $options;

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Get GitHub Actions cache usage for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/cache#get-github-actions-cache-usage-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getUsageForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/cache/usage';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * List repositories with GitHub Actions cache usage for an organization.
     *
     * @param   string   $org    The organization name.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/cache#list-repositories-with-github-actions-cache-usage-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getListUsageByRepoForOrg(string $org, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/cache/usage-by-repository';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Get GitHub Actions cache retention limit for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/cache#get-github-actions-cache-retention-limit-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getRetentionLimitForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/cache/retention-limit';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set GitHub Actions cache retention limit for a repository.
     *
     * @param   string  $owner    The account owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   array   $options  Optional body fields: max_cache_retention_days.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/cache#set-github-actions-cache-retention-limit-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function setRetentionLimitForRepo(string $owner, string $repo, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/cache/retention-limit';

        $data = (object) $options;

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Get GitHub Actions cache storage limit for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/cache#get-github-actions-cache-storage-limit-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getStorageLimitForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/cache/storage-limit';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set GitHub Actions cache storage limit for a repository.
     *
     * @param   string  $owner    The account owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   array   $options  Optional body fields: max_cache_size_gb.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/cache#set-github-actions-cache-storage-limit-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function setStorageLimitForRepo(string $owner, string $repo, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/cache/storage-limit';

        $data = (object) $options;

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Get GitHub Actions cache usage for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/cache#get-github-actions-cache-usage-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getUsageForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/cache/usage';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * List GitHub Actions caches for a repository.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   array    $filters  Optional query parameters: ref, key, sort, direction.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/cache#list-github-actions-caches-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getListForRepo(string $owner, string $repo, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/caches';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Delete GitHub Actions caches for a repository (using a cache key).
     *
     * @param   string  $owner    The account owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   string  $key      A key for identifying the cache.
     * @param   array   $filters  Optional query parameters: ref.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/cache#delete-github-actions-caches-for-a-repository-using-a-cache-key
     * @since   __DEPLOY_VERSION__
     */
    public function deleteByKeyForRepo(string $owner, string $repo, string $key, array $filters = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/caches';

        $uri = $this->fetchUrl($path);

        $uri->setVar('key', $key);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse($this->client->delete($uri));
    }

    /**
     * Delete a GitHub Actions cache for a repository (using a cache ID).
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   integer  $cacheId  The ID of the cache.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/cache#delete-a-github-actions-cache-for-a-repository-using-a-cache-id
     * @since   __DEPLOY_VERSION__
     */
    public function deleteForRepo(string $owner, string $repo, int $cacheId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/caches/' . $cacheId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }
}
