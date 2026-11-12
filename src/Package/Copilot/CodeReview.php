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
 * GitHub API Copilot code review class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/copilot/copilot-code-review
 *
 * @since  __DEPLOY_VERSION__
 */
class CodeReview extends AbstractPackage
{
    /**
     * Get the Copilot code review runner configuration for an organisation.
     *
     * @param   string  $org  The organisation name.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-code-review#get-the-copilot-code-review-runner-configuration-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getRunnerForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/code-review/runner';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set the Copilot code review runner configuration for an organisation.
     *
     * @param   string  $org         The organisation name.
     * @param   string  $runnerType  The type of runner to use for Copilot code review.
     * @param   array   $options     Optional body fields: `runner_labels`, `runner_group_name`, `allow_repository_customization`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-code-review#set-the-copilot-code-review-runner-configuration-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setRunnerForOrg(string $org, string $runnerType, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/code-review/runner';

        $data = array_merge($options, ['runner_type' => $runnerType]);

        return $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Get Copilot code review settings for an organisation.
     *
     * @param   string  $org  The organisation name.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-code-review#get-copilot-code-review-settings-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getSettingsForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/code-review/settings';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Update Copilot code review settings for an organisation.
     *
     * @param   string  $org      The organisation name.
     * @param   array   $options  Optional body fields: `default_review_effort`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-code-review#update-copilot-code-review-settings-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function editSettingsForOrg(string $org, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/code-review/settings';

        $data = (object) $options;

        return $this->processResponse($this->client->patch($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Get the Copilot code review policy for an organisation.
     *
     * @param   string  $org  The organisation name.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-code-review#get-the-copilot-code-review-policy-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getPolicyForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/policies/code-review';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set the Copilot code review policy for an organisation.
     *
     * @param   string  $org    The organisation name.
     * @param   string  $state  The state of the code review policy.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/copilot/copilot-code-review#set-the-copilot-code-review-policy-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setPolicyForOrg(string $org, string $state)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/policies/code-review';

        $data = ['state' => $state];

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Get Copilot code review settings for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-code-review#get-copilot-code-review-settings-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getSettingsForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/copilot/code-review/settings';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Update Copilot code review settings for a repository.
     *
     * @param   string  $owner    The account owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   array   $options  Optional body fields: `review_effort`, `severity_filter`, `custom_instructions_enabled`, `mcp_enabled`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-code-review#update-copilot-code-review-settings-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function editSettingsForRepo(string $owner, string $repo, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/copilot/code-review/settings';

        $data = (object) $options;

        return $this->processResponse($this->client->patch($this->fetchUrl($path), json_encode($data)));
    }
}
