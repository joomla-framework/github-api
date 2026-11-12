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
 * GitHub API Actions Self-hosted Runners class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/actions/self-hosted-runners
 *
 * @since  __DEPLOY_VERSION__
 */
class Runners extends AbstractPackage
{
    /**
     * List self-hosted runners for an organization.
     *
     * @param   string   $org      The organization name.
     * @param   array    $filters  Optional query parameters: name.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#list-self-hosted-runners-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getListForOrg(string $org, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runners';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get runner version end-of-life schedule for an organization.
     *
     * @param   string  $org      The organization name.
     * @param   string  $version  The runner version.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#get-runner-version-end-of-life-schedule-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getVersionDeprecationForOrg(string $org, string $version)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runners/deprecations/' . rawurlencode($version);

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * List runner applications for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#list-runner-applications-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getListApplicationsForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runners/downloads';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Create configuration for a just-in-time runner for an organization.
     *
     * @param   string   $org            The organization name.
     * @param   string   $name           The name of the new runner.
     * @param   integer  $runnerGroupId  The ID of the runner group to register the runner to.
     * @param   array    $labels         The names of the custom labels to add to the runner.
     * @param   array    $options        Optional body fields: work_folder.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#create-configuration-for-a-just-in-time-runner-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function generateJitConfigForOrg(string $org, string $name, int $runnerGroupId, array $labels, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runners/generate-jitconfig';

        $data = array_merge(
            $options,
            [
                'name'            => $name,
                'runner_group_id' => $runnerGroupId,
                'labels'          => $labels,
            ]
        );

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Create a registration token for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#create-a-registration-token-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function createRegistrationTokenForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runners/registration-token';

        return $this->processResponse($this->client->post($this->fetchUrl($path), ''), 201);
    }

    /**
     * Create a remove token for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#create-a-remove-token-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function createRemoveTokenForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runners/remove-token';

        return $this->processResponse($this->client->post($this->fetchUrl($path), ''), 201);
    }

    /**
     * Get a self-hosted runner for an organization.
     *
     * @param   string   $org       The organization name.
     * @param   integer  $runnerId  The ID of the self-hosted runner.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#get-a-self-hosted-runner-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getForOrg(string $org, int $runnerId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runners/' . $runnerId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Delete a self-hosted runner from an organization.
     *
     * @param   string   $org       The organization name.
     * @param   integer  $runnerId  The ID of the self-hosted runner.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#delete-a-self-hosted-runner-from-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function deleteForOrg(string $org, int $runnerId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runners/' . $runnerId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List labels for a self-hosted runner for an organization.
     *
     * @param   string   $org       The organization name.
     * @param   integer  $runnerId  The ID of the self-hosted runner.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#list-labels-for-a-self-hosted-runner-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getListLabelsForOrg(string $org, int $runnerId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runners/' . $runnerId . '/labels';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Add custom labels to a self-hosted runner for an organization.
     *
     * @param   string   $org       The organization name.
     * @param   integer  $runnerId  The ID of the self-hosted runner.
     * @param   array    $labels    The names of the custom labels to add to the runner.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#add-custom-labels-to-a-self-hosted-runner-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function addLabelsForOrg(string $org, int $runnerId, array $labels)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runners/' . $runnerId . '/labels';

        $data = [
            'labels' => $labels,
        ];

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Set custom labels for a self-hosted runner for an organization.
     *
     * @param   string   $org       The organization name.
     * @param   integer  $runnerId  The ID of the self-hosted runner.
     * @param   array    $labels    The names of the custom labels to set for the runner.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#set-custom-labels-for-a-self-hosted-runner-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setLabelsForOrg(string $org, int $runnerId, array $labels)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runners/' . $runnerId . '/labels';

        $data = [
            'labels' => $labels,
        ];

        return $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Remove all custom labels from a self-hosted runner for an organization.
     *
     * @param   string   $org       The organization name.
     * @param   integer  $runnerId  The ID of the self-hosted runner.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#remove-all-custom-labels-from-a-self-hosted-runner-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function removeAllLabelsForOrg(string $org, int $runnerId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runners/' . $runnerId . '/labels';

        return $this->processResponse($this->client->delete($this->fetchUrl($path)));
    }

    /**
     * Remove a custom label from a self-hosted runner for an organization.
     *
     * @param   string   $org       The organization name.
     * @param   integer  $runnerId  The ID of the self-hosted runner.
     * @param   string   $name      The name of the custom label.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#remove-a-custom-label-from-a-self-hosted-runner-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function removeLabelForOrg(string $org, int $runnerId, string $name)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runners/' . $runnerId . '/labels/' . rawurlencode($name);

        return $this->processResponse($this->client->delete($this->fetchUrl($path)));
    }

    /**
     * List self-hosted runners for a repository.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   array    $filters  Optional query parameters: name.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#list-self-hosted-runners-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getListForRepo(string $owner, string $repo, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runners';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get runner version end-of-life schedule for a repository.
     *
     * @param   string  $owner    The account owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   string  $version  The runner version.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#get-runner-version-end-of-life-schedule-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getVersionDeprecationForRepo(string $owner, string $repo, string $version)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runners/deprecations/' . rawurlencode($version);

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * List runner applications for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#list-runner-applications-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getListApplicationsForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runners/downloads';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Create configuration for a just-in-time runner for a repository.
     *
     * @param   string   $owner          The account owner of the repository.
     * @param   string   $repo           The name of the repository.
     * @param   string   $name           The name of the new runner.
     * @param   integer  $runnerGroupId  The ID of the runner group to register the runner to.
     * @param   array    $labels         The names of the custom labels to add to the runner.
     * @param   array    $options        Optional body fields: work_folder.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#create-configuration-for-a-just-in-time-runner-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function generateJitConfigForRepo(string $owner, string $repo, string $name, int $runnerGroupId, array $labels, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runners/generate-jitconfig';

        $data = array_merge(
            $options,
            [
                'name'            => $name,
                'runner_group_id' => $runnerGroupId,
                'labels'          => $labels,
            ]
        );

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Create a registration token for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#create-a-registration-token-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function createRegistrationTokenForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runners/registration-token';

        return $this->processResponse($this->client->post($this->fetchUrl($path), ''), 201);
    }

    /**
     * Create a remove token for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#create-a-remove-token-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function createRemoveTokenForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runners/remove-token';

        return $this->processResponse($this->client->post($this->fetchUrl($path), ''), 201);
    }

    /**
     * Get a self-hosted runner for a repository.
     *
     * @param   string   $owner     The account owner of the repository.
     * @param   string   $repo      The name of the repository.
     * @param   integer  $runnerId  The ID of the self-hosted runner.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#get-a-self-hosted-runner-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getForRepo(string $owner, string $repo, int $runnerId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runners/' . $runnerId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Delete a self-hosted runner from a repository.
     *
     * @param   string   $owner     The account owner of the repository.
     * @param   string   $repo      The name of the repository.
     * @param   integer  $runnerId  The ID of the self-hosted runner.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#delete-a-self-hosted-runner-from-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function deleteForRepo(string $owner, string $repo, int $runnerId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runners/' . $runnerId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List labels for a self-hosted runner for a repository.
     *
     * @param   string   $owner     The account owner of the repository.
     * @param   string   $repo      The name of the repository.
     * @param   integer  $runnerId  The ID of the self-hosted runner.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#list-labels-for-a-self-hosted-runner-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getListLabelsForRepo(string $owner, string $repo, int $runnerId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runners/' . $runnerId . '/labels';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Add custom labels to a self-hosted runner for a repository.
     *
     * @param   string   $owner     The account owner of the repository.
     * @param   string   $repo      The name of the repository.
     * @param   integer  $runnerId  The ID of the self-hosted runner.
     * @param   array    $labels    The names of the custom labels to add to the runner.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#add-custom-labels-to-a-self-hosted-runner-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function addLabelsForRepo(string $owner, string $repo, int $runnerId, array $labels)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runners/' . $runnerId . '/labels';

        $data = [
            'labels' => $labels,
        ];

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Set custom labels for a self-hosted runner for a repository.
     *
     * @param   string   $owner     The account owner of the repository.
     * @param   string   $repo      The name of the repository.
     * @param   integer  $runnerId  The ID of the self-hosted runner.
     * @param   array    $labels    The names of the custom labels to set for the runner.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#set-custom-labels-for-a-self-hosted-runner-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function setLabelsForRepo(string $owner, string $repo, int $runnerId, array $labels)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runners/' . $runnerId . '/labels';

        $data = [
            'labels' => $labels,
        ];

        return $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Remove all custom labels from a self-hosted runner for a repository.
     *
     * @param   string   $owner     The account owner of the repository.
     * @param   string   $repo      The name of the repository.
     * @param   integer  $runnerId  The ID of the self-hosted runner.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#remove-all-custom-labels-from-a-self-hosted-runner-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function removeAllLabelsForRepo(string $owner, string $repo, int $runnerId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runners/' . $runnerId . '/labels';

        return $this->processResponse($this->client->delete($this->fetchUrl($path)));
    }

    /**
     * Remove a custom label from a self-hosted runner for a repository.
     *
     * @param   string   $owner     The account owner of the repository.
     * @param   string   $repo      The name of the repository.
     * @param   integer  $runnerId  The ID of the self-hosted runner.
     * @param   string   $name      The name of the custom label.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runners#remove-a-custom-label-from-a-self-hosted-runner-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function removeLabelForRepo(string $owner, string $repo, int $runnerId, string $name)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runners/' . $runnerId . '/labels/' . rawurlencode($name);

        return $this->processResponse($this->client->delete($this->fetchUrl($path)));
    }
}
