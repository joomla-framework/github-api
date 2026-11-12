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
 * GitHub API Projects Fields class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/projects/fields
 *
 * @since  __DEPLOY_VERSION__
 */
class Fields extends AbstractPackage
{
    /**
     * List project fields for organization.
     *
     * Cursor-based pagination: pass the `before` / `after` filters; GitHub uses only `$limit` (per_page), not `$page`.
     *
     * @param   string   $org            Organisation name.
     * @param   integer  $projectNumber  Project number.
     * @param   array    $filters        Optional query parameters: before, after.
     * @param   integer  $page           The page number from which to get items.
     * @param   integer  $limit          The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/projects/fields#list-project-fields-for-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForOrg(string $org, int $projectNumber, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/projectsV2/' . $projectNumber . '/fields';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Add a field to an organization-owned project.
     *
     * The request body is one of several variants without a common required field, so it is passed as a whole.
     *
     * @param   string   $org            Organisation name.
     * @param   integer  $projectNumber  Project number.
     * @param   array    $field          The field definition: either `issue_field_id`, or `name` and `data_type` plus `single_select_options` / `iteration_configuration` where the type needs them.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/projects/fields#add-a-field-to-an-organization-owned-project
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function addForOrg(string $org, int $projectNumber, array $field)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/projectsV2/' . $projectNumber . '/fields';

        $data = json_encode($field);

        return $this->processResponse($this->client->post($this->fetchUrl($path), $data), 201);
    }

    /**
     * Get project field for organization.
     *
     * @param   string   $org            Organisation name.
     * @param   integer  $projectNumber  Project number.
     * @param   integer  $fieldId        Field identifier.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/projects/fields#get-project-field-for-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getForOrg(string $org, int $projectNumber, int $fieldId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/projectsV2/' . $projectNumber . '/fields/' . $fieldId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * List project fields for user.
     *
     * Cursor-based pagination: pass the `before` / `after` filters; GitHub uses only `$limit` (per_page), not `$page`.
     *
     * @param   string   $username       GitHub user name.
     * @param   integer  $projectNumber  Project number.
     * @param   array    $filters        Optional query parameters: before, after.
     * @param   integer  $page           The page number from which to get items.
     * @param   integer  $limit          The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/projects/fields#list-project-fields-for-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForUser(string $username, int $projectNumber, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/users/' . $username . '/projectsV2/' . $projectNumber . '/fields';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Add field to user owned project.
     *
     * @param   string   $username       GitHub user name.
     * @param   integer  $projectNumber  Project number.
     * @param   string   $name           The name of the field.
     * @param   string   $dataType       The field type: text, number, date, single_select or iteration.
     * @param   array    $options        Optional request body fields: single_select_options, iteration_configuration.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/projects/fields#add-field-to-user-owned-project
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function addForUser(string $username, int $projectNumber, string $name, string $dataType, array $options = [])
    {
        // Build the request path.
        $path = '/users/' . $username . '/projectsV2/' . $projectNumber . '/fields';

        $data = json_encode(array_merge($options, ['name' => $name, 'data_type' => $dataType]));

        return $this->processResponse($this->client->post($this->fetchUrl($path), $data), 201);
    }

    /**
     * Get project field for user.
     *
     * @param   string   $username       GitHub user name.
     * @param   integer  $projectNumber  Project number.
     * @param   integer  $fieldId        Field identifier.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/projects/fields#get-project-field-for-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getForUser(string $username, int $projectNumber, int $fieldId)
    {
        // Build the request path.
        $path = '/users/' . $username . '/projectsV2/' . $projectNumber . '/fields/' . $fieldId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }
}
