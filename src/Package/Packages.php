<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package;

use Joomla\Github\AbstractPackage;
use Joomla\Http\Exception\UnexpectedResponseException;

/**
 * GitHub API Packages class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/packages/packages
 *
 * @since  __DEPLOY_VERSION__
 */
class Packages extends AbstractPackage
{
    /**
     * List packages for an organization.
     *
     * @param   string   $org          The organization name.
     * @param   string   $packageType  The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   array    $filters      Optional query parameters: visibility.
     * @param   integer  $page         The page number from which to get items.
     * @param   integer  $limit        The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/packages/packages#list-packages-for-an-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForOrg(string $org, string $packageType, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/packages';

        $uri = $this->fetchUrl($path, $page, $limit);
        $uri->setVar('package_type', $packageType);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri), 200);
    }

    /**
     * Get a package for an organization.
     *
     * @param   string  $org          The organization name.
     * @param   string  $packageType  The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string  $packageName  The name of the package.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/packages/packages#get-a-package-for-an-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getForOrg(string $org, string $packageType, string $packageName)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/packages/' . $packageType . '/' . rawurlencode($packageName);

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Delete a package for an organization.
     *
     * @param   string  $org          The organization name.
     * @param   string  $packageType  The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string  $packageName  The name of the package.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/packages/packages#delete-a-package-for-an-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteForOrg(string $org, string $packageType, string $packageName)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/packages/' . $packageType . '/' . rawurlencode($packageName);

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Restore a package for an organization.
     *
     * @param   string  $org          The organization name.
     * @param   string  $packageType  The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string  $packageName  The name of the package.
     * @param   array   $filters      Optional query parameters: token.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/packages/packages#restore-a-package-for-an-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function restoreForOrg(string $org, string $packageType, string $packageName, array $filters = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/packages/' . $packageType . '/' . rawurlencode($packageName) . '/restore';

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        $this->processResponse($this->client->post($uri, ''), 204);
    }

    /**
     * List package versions for a package owned by an organization.
     *
     * @param   string   $org          The organization name.
     * @param   string   $packageType  The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string   $packageName  The name of the package.
     * @param   array    $filters      Optional query parameters: state.
     * @param   integer  $page         The page number from which to get items.
     * @param   integer  $limit        The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/packages/packages#list-package-versions-for-a-package-owned-by-an-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListVersionsForOrg(string $org, string $packageType, string $packageName, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/packages/' . $packageType . '/' . rawurlencode($packageName) . '/versions';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri), 200);
    }

    /**
     * Get a package version for an organization.
     *
     * @param   string   $org               The organization name.
     * @param   string   $packageType       The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string   $packageName       The name of the package.
     * @param   integer  $packageVersionId  The unique identifier of the package version.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/packages/packages#get-a-package-version-for-an-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getVersionForOrg(string $org, string $packageType, string $packageName, int $packageVersionId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/packages/' . $packageType . '/' . rawurlencode($packageName) . '/versions/' . $packageVersionId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Delete package version for an organization.
     *
     * @param   string   $org               The organization name.
     * @param   string   $packageType       The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string   $packageName       The name of the package.
     * @param   integer  $packageVersionId  The unique identifier of the package version.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/packages/packages#delete-package-version-for-an-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteVersionForOrg(string $org, string $packageType, string $packageName, int $packageVersionId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/packages/' . $packageType . '/' . rawurlencode($packageName) . '/versions/' . $packageVersionId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Restore package version for an organization.
     *
     * @param   string   $org               The organization name.
     * @param   string   $packageType       The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string   $packageName       The name of the package.
     * @param   integer  $packageVersionId  The unique identifier of the package version.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/packages/packages#restore-package-version-for-an-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function restoreVersionForOrg(string $org, string $packageType, string $packageName, int $packageVersionId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/packages/' . $packageType . '/' . rawurlencode($packageName) . '/versions/' . $packageVersionId . '/restore';

        $this->processResponse($this->client->post($this->fetchUrl($path), ''), 204);
    }

    /**
     * Get list of conflicting packages during Docker migration for organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/packages/packages#get-list-of-conflicting-packages-during-docker-migration-for-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListDockerConflictsForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/docker/conflicts';

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * List packages for a user.
     *
     * @param   string   $username     The handle for the GitHub user account.
     * @param   string   $packageType  The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   array    $filters      Optional query parameters: visibility.
     * @param   integer  $page         The page number from which to get items.
     * @param   integer  $limit        The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/packages/packages#list-packages-for-a-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForUser(string $username, string $packageType, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/users/' . $username . '/packages';

        $uri = $this->fetchUrl($path, $page, $limit);
        $uri->setVar('package_type', $packageType);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri), 200);
    }

    /**
     * Get a package for a user.
     *
     * @param   string  $username     The handle for the GitHub user account.
     * @param   string  $packageType  The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string  $packageName  The name of the package.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/packages/packages#get-a-package-for-a-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getForUser(string $username, string $packageType, string $packageName)
    {
        // Build the request path.
        $path = '/users/' . $username . '/packages/' . $packageType . '/' . rawurlencode($packageName);

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Delete a package for a user.
     *
     * @param   string  $username     The handle for the GitHub user account.
     * @param   string  $packageType  The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string  $packageName  The name of the package.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/packages/packages#delete-a-package-for-a-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteForUser(string $username, string $packageType, string $packageName)
    {
        // Build the request path.
        $path = '/users/' . $username . '/packages/' . $packageType . '/' . rawurlencode($packageName);

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Restore a package for a user.
     *
     * @param   string  $username     The handle for the GitHub user account.
     * @param   string  $packageType  The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string  $packageName  The name of the package.
     * @param   array   $filters      Optional query parameters: token.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/packages/packages#restore-a-package-for-a-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function restoreForUser(string $username, string $packageType, string $packageName, array $filters = [])
    {
        // Build the request path.
        $path = '/users/' . $username . '/packages/' . $packageType . '/' . rawurlencode($packageName) . '/restore';

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        $this->processResponse($this->client->post($uri, ''), 204);
    }

    /**
     * List package versions for a package owned by a user.
     *
     * @param   string  $username     The handle for the GitHub user account.
     * @param   string  $packageType  The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string  $packageName  The name of the package.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/packages/packages#list-package-versions-for-a-package-owned-by-a-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListVersionsForUser(string $username, string $packageType, string $packageName)
    {
        // Build the request path.
        $path = '/users/' . $username . '/packages/' . $packageType . '/' . rawurlencode($packageName) . '/versions';

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Get a package version for a user.
     *
     * @param   string   $username          The handle for the GitHub user account.
     * @param   string   $packageType       The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string   $packageName       The name of the package.
     * @param   integer  $packageVersionId  The unique identifier of the package version.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/packages/packages#get-a-package-version-for-a-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getVersionForUser(string $username, string $packageType, string $packageName, int $packageVersionId)
    {
        // Build the request path.
        $path = '/users/' . $username . '/packages/' . $packageType . '/' . rawurlencode($packageName) . '/versions/' . $packageVersionId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Delete package version for a user.
     *
     * @param   string   $username          The handle for the GitHub user account.
     * @param   string   $packageType       The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string   $packageName       The name of the package.
     * @param   integer  $packageVersionId  The unique identifier of the package version.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/packages/packages#delete-package-version-for-a-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteVersionForUser(string $username, string $packageType, string $packageName, int $packageVersionId)
    {
        // Build the request path.
        $path = '/users/' . $username . '/packages/' . $packageType . '/' . rawurlencode($packageName) . '/versions/' . $packageVersionId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Restore package version for a user.
     *
     * @param   string   $username          The handle for the GitHub user account.
     * @param   string   $packageType       The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string   $packageName       The name of the package.
     * @param   integer  $packageVersionId  The unique identifier of the package version.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/packages/packages#restore-package-version-for-a-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function restoreVersionForUser(string $username, string $packageType, string $packageName, int $packageVersionId)
    {
        // Build the request path.
        $path = '/users/' . $username . '/packages/' . $packageType . '/' . rawurlencode($packageName) . '/versions/' . $packageVersionId . '/restore';

        $this->processResponse($this->client->post($this->fetchUrl($path), ''), 204);
    }

    /**
     * Get list of conflicting packages during Docker migration for user.
     *
     * @param   string  $username  The handle for the GitHub user account.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/packages/packages#get-list-of-conflicting-packages-during-docker-migration-for-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListDockerConflictsForUser(string $username)
    {
        // Build the request path.
        $path = '/users/' . $username . '/docker/conflicts';

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * List packages for the authenticated user's namespace.
     *
     * @param   string   $packageType  The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   array    $filters      Optional query parameters: visibility.
     * @param   integer  $page         The page number from which to get items.
     * @param   integer  $limit        The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/packages/packages#list-packages-for-the-authenticated-users-namespace
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForAuthenticatedUser(string $packageType, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/user/packages';

        $uri = $this->fetchUrl($path, $page, $limit);
        $uri->setVar('package_type', $packageType);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri), 200);
    }

    /**
     * Get a package for the authenticated user.
     *
     * @param   string  $packageType  The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string  $packageName  The name of the package.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/packages/packages#get-a-package-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getForAuthenticatedUser(string $packageType, string $packageName)
    {
        // Build the request path.
        $path = '/user/packages/' . $packageType . '/' . rawurlencode($packageName);

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Delete a package for the authenticated user.
     *
     * @param   string  $packageType  The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string  $packageName  The name of the package.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/packages/packages#delete-a-package-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteForAuthenticatedUser(string $packageType, string $packageName)
    {
        // Build the request path.
        $path = '/user/packages/' . $packageType . '/' . rawurlencode($packageName);

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Restore a package for the authenticated user.
     *
     * @param   string  $packageType  The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string  $packageName  The name of the package.
     * @param   array   $filters      Optional query parameters: token.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/packages/packages#restore-a-package-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function restoreForAuthenticatedUser(string $packageType, string $packageName, array $filters = [])
    {
        // Build the request path.
        $path = '/user/packages/' . $packageType . '/' . rawurlencode($packageName) . '/restore';

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        $this->processResponse($this->client->post($uri, ''), 204);
    }

    /**
     * List package versions for a package owned by the authenticated user.
     *
     * @param   string   $packageType  The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string   $packageName  The name of the package.
     * @param   array    $filters      Optional query parameters: state.
     * @param   integer  $page         The page number from which to get items.
     * @param   integer  $limit        The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/packages/packages#list-package-versions-for-a-package-owned-by-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListVersionsForAuthenticatedUser(string $packageType, string $packageName, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/user/packages/' . $packageType . '/' . rawurlencode($packageName) . '/versions';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri), 200);
    }

    /**
     * Get a package version for the authenticated user.
     *
     * @param   string   $packageType       The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string   $packageName       The name of the package.
     * @param   integer  $packageVersionId  The unique identifier of the package version.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/packages/packages#get-a-package-version-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getVersionForAuthenticatedUser(string $packageType, string $packageName, int $packageVersionId)
    {
        // Build the request path.
        $path = '/user/packages/' . $packageType . '/' . rawurlencode($packageName) . '/versions/' . $packageVersionId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Delete a package version for the authenticated user.
     *
     * @param   string   $packageType       The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string   $packageName       The name of the package.
     * @param   integer  $packageVersionId  The unique identifier of the package version.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/packages/packages#delete-a-package-version-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteVersionForAuthenticatedUser(string $packageType, string $packageName, int $packageVersionId)
    {
        // Build the request path.
        $path = '/user/packages/' . $packageType . '/' . rawurlencode($packageName) . '/versions/' . $packageVersionId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Restore a package version for the authenticated user.
     *
     * @param   string   $packageType       The type of package (npm, maven, rubygems, docker, nuget or container).
     * @param   string   $packageName       The name of the package.
     * @param   integer  $packageVersionId  The unique identifier of the package version.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/packages/packages#restore-a-package-version-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function restoreVersionForAuthenticatedUser(string $packageType, string $packageName, int $packageVersionId)
    {
        // Build the request path.
        $path = '/user/packages/' . $packageType . '/' . rawurlencode($packageName) . '/versions/' . $packageVersionId . '/restore';

        $this->processResponse($this->client->post($this->fetchUrl($path), ''), 204);
    }

    /**
     * Get list of conflicting packages during Docker migration for authenticated-user.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/packages/packages#get-list-of-conflicting-packages-during-docker-migration-for-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListDockerConflictsForAuthenticatedUser()
    {
        // Build the request path.
        $path = '/user/docker/conflicts';

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }
}
