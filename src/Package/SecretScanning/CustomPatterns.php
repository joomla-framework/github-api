<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\SecretScanning;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Secret Scanning Custom Patterns class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/secret-scanning/custom-patterns
 *
 * @since  __DEPLOY_VERSION__
 */
class CustomPatterns extends AbstractPackage
{
    /**
     * List organization custom patterns.
     *
     * @param   string  $org      The organization name.
     * @param   array   $filters  Optional query parameters: `state`, `push_protection`, `sort`, `direction`, `before`, `after`.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/secret-scanning/custom-patterns#list-organization-custom-patterns
     * @since   __DEPLOY_VERSION__
     */
    public function getListForOrg(string $org, array $filters = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/secret-scanning/custom-patterns';

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
     * Bulk create organization custom patterns.
     *
     * @param   string  $org       The organization name.
     * @param   array   $patterns  The custom patterns to create (each with `name`, `pattern`, ...).
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/secret-scanning/custom-patterns#bulk-create-organization-custom-patterns
     * @since   __DEPLOY_VERSION__
     */
    public function createForOrg(string $org, array $patterns)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/secret-scanning/custom-patterns';

        $data = ['patterns' => $patterns];

        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), json_encode($data)),
            201
        );
    }

    /**
     * Bulk delete organization custom patterns.
     *
     * @param   string  $org       The organization name.
     * @param   array   $patterns  The custom patterns to delete (each with `id` and `custom_pattern_version`).
     * @param   array   $options   Optional body fields: `post_delete_action`.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/secret-scanning/custom-patterns#bulk-delete-organization-custom-patterns
     * @since   __DEPLOY_VERSION__
     */
    public function deleteForOrg(string $org, array $patterns, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/secret-scanning/custom-patterns';

        $data = array_merge($options, ['patterns' => $patterns]);

        $this->processResponse(
            $this->client->delete($this->fetchUrl($path), [], null, json_encode($data)),
            204
        );
    }

    /**
     * Update an organization custom pattern.
     *
     * At least one of the optional fields must be given.
     *
     * @param   string   $org                   The organization name.
     * @param   integer  $patternId             The ID of the custom pattern.
     * @param   string   $customPatternVersion  The version of the pattern being updated.
     * @param   array    $options               Optional body fields: `pattern`, `start_delimiter`, `end_delimiter`, `must_match`, `must_not_match`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/secret-scanning/custom-patterns#update-an-organization-custom-pattern
     * @since   __DEPLOY_VERSION__
     */
    public function editForOrg(string $org, int $patternId, string $customPatternVersion, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/secret-scanning/custom-patterns/' . $patternId;

        $data = array_merge($options, ['custom_pattern_version' => $customPatternVersion]);

        return $this->processResponse(
            $this->client->patch($this->fetchUrl($path), json_encode($data)),
            200
        );
    }

    /**
     * List repository custom patterns.
     *
     * @param   string  $owner    The account owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   array   $filters  Optional query parameters: `state`, `push_protection`, `sort`, `direction`, `before`, `after`.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/secret-scanning/custom-patterns#list-repository-custom-patterns
     * @since   __DEPLOY_VERSION__
     */
    public function getListForRepo(string $owner, string $repo, array $filters = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/secret-scanning/custom-patterns';

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
     * Bulk create repository custom patterns.
     *
     * @param   string  $owner     The account owner of the repository.
     * @param   string  $repo      The name of the repository.
     * @param   array   $patterns  The custom patterns to create (each with `name`, `pattern`, ...).
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/secret-scanning/custom-patterns#bulk-create-repository-custom-patterns
     * @since   __DEPLOY_VERSION__
     */
    public function createForRepo(string $owner, string $repo, array $patterns)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/secret-scanning/custom-patterns';

        $data = ['patterns' => $patterns];

        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), json_encode($data)),
            201
        );
    }

    /**
     * Bulk delete repository custom patterns.
     *
     * @param   string  $owner     The account owner of the repository.
     * @param   string  $repo      The name of the repository.
     * @param   array   $patterns  The custom patterns to delete (each with `id` and `custom_pattern_version`).
     * @param   array   $options   Optional body fields: `post_delete_action`.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/secret-scanning/custom-patterns#bulk-delete-repository-custom-patterns
     * @since   __DEPLOY_VERSION__
     */
    public function deleteForRepo(string $owner, string $repo, array $patterns, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/secret-scanning/custom-patterns';

        $data = array_merge($options, ['patterns' => $patterns]);

        $this->processResponse(
            $this->client->delete($this->fetchUrl($path), [], null, json_encode($data)),
            204
        );
    }

    /**
     * Update a repository custom pattern.
     *
     * At least one of the optional fields must be given.
     *
     * @param   string   $owner                 The account owner of the repository.
     * @param   string   $repo                  The name of the repository.
     * @param   integer  $patternId             The ID of the custom pattern.
     * @param   string   $customPatternVersion  The version of the pattern being updated.
     * @param   array    $options               Optional body fields: `pattern`, `start_delimiter`, `end_delimiter`, `must_match`, `must_not_match`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/secret-scanning/custom-patterns#update-a-repository-custom-pattern
     * @since   __DEPLOY_VERSION__
     */
    public function editForRepo(string $owner, string $repo, int $patternId, string $customPatternVersion, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/secret-scanning/custom-patterns/' . $patternId;

        $data = array_merge($options, ['custom_pattern_version' => $customPatternVersion]);

        return $this->processResponse(
            $this->client->patch($this->fetchUrl($path), json_encode($data)),
            200
        );
    }
}
