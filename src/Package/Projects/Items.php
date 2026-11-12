<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Projects;

use Joomla\Github\AbstractPackage;
use Joomla\Http\Exception\UnexpectedResponseException;

/**
 * GitHub API Projects Items class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/projects/items
 *
 * @since  __DEPLOY_VERSION__
 */
class Items extends AbstractPackage
{
    /**
     * List items for an organization owned project.
     *
     * `fields` limits the returned fields by ID (comma-separated string, e.g. "123,456").
     * Cursor-based pagination: pass the `before` / `after` filters; GitHub uses only `$limit` (per_page), not `$page`.
     *
     * @param   string   $org            Organisation name.
     * @param   integer  $projectNumber  Project number.
     * @param   array    $filters        Optional query parameters: q, fields, before, after.
     * @param   integer  $page           The page number from which to get items.
     * @param   integer  $limit          The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/projects/items#list-items-for-an-organization-owned-project
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForOrg(string $org, int $projectNumber, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/projectsV2/' . $projectNumber . '/items';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Add item to organization owned project.
     *
     * Identify the issue or pull request either by `id`, or by `owner`, `repo` and `number`.
     *
     * @param   string   $org            Organisation name.
     * @param   integer  $projectNumber  Project number.
     * @param   string   $type           The type of item to add: Issue or PullRequest.
     * @param   array    $options        Optional request body fields: id, owner, repo, number.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/projects/items#add-item-to-organization-owned-project
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function addForOrg(string $org, int $projectNumber, string $type, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/projectsV2/' . $projectNumber . '/items';

        $data = json_encode(array_merge($options, ['type' => $type]));

        return $this->processResponse($this->client->post($this->fetchUrl($path), $data), 201);
    }

    /**
     * Get an item for an organization owned project.
     *
     * `fields` limits the returned fields by ID (comma-separated string, e.g. "123,456").
     *
     * @param   string   $org            Organisation name.
     * @param   integer  $projectNumber  Project number.
     * @param   integer  $itemId         Item identifier.
     * @param   array    $filters        Optional query parameters: fields.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/projects/items#get-an-item-for-an-organization-owned-project
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getForOrg(string $org, int $projectNumber, int $itemId, array $filters = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/projectsV2/' . $projectNumber . '/items/' . $itemId;

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Update project item for organization.
     *
     * @param   string   $org            Organisation name.
     * @param   integer  $projectNumber  Project number.
     * @param   integer  $itemId         Item identifier.
     * @param   array    $fields         The field values to set, each as ['id' => fieldId, 'value' => value].
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/projects/items#update-project-item-for-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function editForOrg(string $org, int $projectNumber, int $itemId, array $fields)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/projectsV2/' . $projectNumber . '/items/' . $itemId;

        $data = json_encode(['fields' => $fields]);

        return $this->processResponse($this->client->patch($this->fetchUrl($path), $data));
    }

    /**
     * Delete project item for organization.
     *
     * @param   string   $org            Organisation name.
     * @param   integer  $projectNumber  Project number.
     * @param   integer  $itemId         Item identifier.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/projects/items#delete-project-item-for-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteForOrg(string $org, int $projectNumber, int $itemId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/projectsV2/' . $projectNumber . '/items/' . $itemId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List items for an organization project view.
     *
     * `fields` limits the returned fields by ID (comma-separated string, e.g. "123,456").
     * Cursor-based pagination: pass the `before` / `after` filters; GitHub uses only `$limit` (per_page), not `$page`.
     *
     * @param   string   $org            Organisation name.
     * @param   integer  $projectNumber  Project number.
     * @param   integer  $viewNumber     View number.
     * @param   array    $filters        Optional query parameters: fields, before, after.
     * @param   integer  $page           The page number from which to get items.
     * @param   integer  $limit          The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/projects/items#list-items-for-an-organization-project-view
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForOrgView(string $org, int $projectNumber, int $viewNumber, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/projectsV2/' . $projectNumber . '/views/' . $viewNumber . '/items';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * List items for a user owned project.
     *
     * `fields` limits the returned fields by ID (comma-separated string, e.g. "123,456").
     * Cursor-based pagination: pass the `before` / `after` filters; GitHub uses only `$limit` (per_page), not `$page`.
     *
     * @param   string   $username       GitHub user name.
     * @param   integer  $projectNumber  Project number.
     * @param   array    $filters        Optional query parameters: before, after, q, fields.
     * @param   integer  $page           The page number from which to get items.
     * @param   integer  $limit          The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/projects/items#list-items-for-a-user-owned-project
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForUser(string $username, int $projectNumber, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/users/' . $username . '/projectsV2/' . $projectNumber . '/items';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Add item to user owned project.
     *
     * Identify the issue or pull request either by `id`, or by `owner`, `repo` and `number`.
     *
     * @param   string   $username       GitHub user name.
     * @param   integer  $projectNumber  Project number.
     * @param   string   $type           The type of item to add: Issue or PullRequest.
     * @param   array    $options        Optional request body fields: id, owner, repo, number.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/projects/items#add-item-to-user-owned-project
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function addForUser(string $username, int $projectNumber, string $type, array $options = [])
    {
        // Build the request path.
        $path = '/users/' . $username . '/projectsV2/' . $projectNumber . '/items';

        $data = json_encode(array_merge($options, ['type' => $type]));

        return $this->processResponse($this->client->post($this->fetchUrl($path), $data), 201);
    }

    /**
     * Get an item for a user owned project.
     *
     * `fields` limits the returned fields by ID (comma-separated string, e.g. "123,456").
     *
     * @param   string   $username       GitHub user name.
     * @param   integer  $projectNumber  Project number.
     * @param   integer  $itemId         Item identifier.
     * @param   array    $filters        Optional query parameters: fields.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/projects/items#get-an-item-for-a-user-owned-project
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getForUser(string $username, int $projectNumber, int $itemId, array $filters = [])
    {
        // Build the request path.
        $path = '/users/' . $username . '/projectsV2/' . $projectNumber . '/items/' . $itemId;

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Update project item for user.
     *
     * @param   string   $username       GitHub user name.
     * @param   integer  $projectNumber  Project number.
     * @param   integer  $itemId         Item identifier.
     * @param   array    $fields         The field values to set, each as ['id' => fieldId, 'value' => value].
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/projects/items#update-project-item-for-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function editForUser(string $username, int $projectNumber, int $itemId, array $fields)
    {
        // Build the request path.
        $path = '/users/' . $username . '/projectsV2/' . $projectNumber . '/items/' . $itemId;

        $data = json_encode(['fields' => $fields]);

        return $this->processResponse($this->client->patch($this->fetchUrl($path), $data));
    }

    /**
     * Delete project item for user.
     *
     * @param   string   $username       GitHub user name.
     * @param   integer  $projectNumber  Project number.
     * @param   integer  $itemId         Item identifier.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/projects/items#delete-project-item-for-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteForUser(string $username, int $projectNumber, int $itemId)
    {
        // Build the request path.
        $path = '/users/' . $username . '/projectsV2/' . $projectNumber . '/items/' . $itemId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List items for a user project view.
     *
     * `fields` limits the returned fields by ID (comma-separated string, e.g. "123,456").
     * Cursor-based pagination: pass the `before` / `after` filters; GitHub uses only `$limit` (per_page), not `$page`.
     *
     * @param   string   $username       GitHub user name.
     * @param   integer  $projectNumber  Project number.
     * @param   integer  $viewNumber     View number.
     * @param   array    $filters        Optional query parameters: fields, before, after.
     * @param   integer  $page           The page number from which to get items.
     * @param   integer  $limit          The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/projects/items#list-items-for-a-user-project-view
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForUserView(string $username, int $projectNumber, int $viewNumber, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/users/' . $username . '/projectsV2/' . $projectNumber . '/views/' . $viewNumber . '/items';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }
}
