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
 * GitHub API Actions Policies class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/actions/policies
 *
 * @since  __DEPLOY_VERSION__
 */
class Policies extends AbstractPackage
{
    /**
     * List organization Actions policies.
     *
     * @param   string   $org      The organization name.
     * @param   array    $filters  Optional query parameters: has_parents.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/policies#list-organization-actions-policies
     * @since   __DEPLOY_VERSION__
     */
    public function getListForOrg(string $org, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/policies';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Create an organization Actions policy.
     *
     * @param   string  $org          The organization name.
     * @param   string  $name         The name of the policy.
     * @param   string  $enforcement  The enforcement level of the ruleset.
     * @param   array   $options      Optional body fields: conditions, rules.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/policies#create-an-organization-actions-policy
     * @since   __DEPLOY_VERSION__
     */
    public function createForOrg(string $org, string $name, string $enforcement, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/policies';

        $data = array_merge(
            $options,
            [
                'name'        => $name,
                'enforcement' => $enforcement,
            ]
        );

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Get an organization Actions policy.
     *
     * @param   string   $org       The organization name.
     * @param   integer  $policyId  The ID of the policy.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/policies#get-an-organization-actions-policy
     * @since   __DEPLOY_VERSION__
     */
    public function getForOrg(string $org, int $policyId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/policies/' . $policyId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Update an organization Actions policy.
     *
     * @param   string   $org       The organization name.
     * @param   integer  $policyId  The ID of the policy.
     * @param   array    $options   Optional body fields: name, enforcement, conditions, rules.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/policies#update-an-organization-actions-policy
     * @since   __DEPLOY_VERSION__
     */
    public function editForOrg(string $org, int $policyId, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/policies/' . $policyId;

        $data = (object) $options;

        return $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Delete an organization Actions policy.
     *
     * @param   string   $org       The organization name.
     * @param   integer  $policyId  The ID of the policy.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/policies#delete-an-organization-actions-policy
     * @since   __DEPLOY_VERSION__
     */
    public function deleteForOrg(string $org, int $policyId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/policies/' . $policyId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List repository Actions policies.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   array    $filters  Optional query parameters: has_parents.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/policies#list-repository-actions-policies
     * @since   __DEPLOY_VERSION__
     */
    public function getListForRepo(string $owner, string $repo, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/policies';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Create a repository Actions policy.
     *
     * @param   string  $owner        The account owner of the repository.
     * @param   string  $repo         The name of the repository.
     * @param   string  $name         The name of the policy.
     * @param   string  $enforcement  The enforcement level of the ruleset.
     * @param   array   $options      Optional body fields: conditions, rules.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/policies#create-a-repository-actions-policy
     * @since   __DEPLOY_VERSION__
     */
    public function createForRepo(string $owner, string $repo, string $name, string $enforcement, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/policies';

        $data = array_merge(
            $options,
            [
                'name'        => $name,
                'enforcement' => $enforcement,
            ]
        );

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Get a repository Actions policy.
     *
     * @param   string   $owner     The account owner of the repository.
     * @param   string   $repo      The name of the repository.
     * @param   integer  $policyId  The ID of the policy.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/policies#get-a-repository-actions-policy
     * @since   __DEPLOY_VERSION__
     */
    public function getForRepo(string $owner, string $repo, int $policyId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/policies/' . $policyId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Update a repository Actions policy.
     *
     * @param   string   $owner     The account owner of the repository.
     * @param   string   $repo      The name of the repository.
     * @param   integer  $policyId  The ID of the policy.
     * @param   array    $options   Optional body fields: name, enforcement, conditions, rules.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/policies#update-a-repository-actions-policy
     * @since   __DEPLOY_VERSION__
     */
    public function editForRepo(string $owner, string $repo, int $policyId, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/policies/' . $policyId;

        $data = (object) $options;

        return $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Delete a repository Actions policy.
     *
     * @param   string   $owner     The account owner of the repository.
     * @param   string   $repo      The name of the repository.
     * @param   integer  $policyId  The ID of the policy.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/policies#delete-a-repository-actions-policy
     * @since   __DEPLOY_VERSION__
     */
    public function deleteForRepo(string $owner, string $repo, int $policyId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/policies/' . $policyId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }
}
