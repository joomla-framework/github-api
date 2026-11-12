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
 * GitHub API Actions GitHub-hosted Runners class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/actions/hosted-runners
 *
 * @since  __DEPLOY_VERSION__
 */
class HostedRunners extends AbstractPackage
{
    /**
     * List GitHub-hosted runners for an organization.
     *
     * @param   string   $org    The organization name.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/hosted-runners#list-github-hosted-runners-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getList(string $org, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/hosted-runners';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Create a GitHub-hosted runner for an organization.
     *
     * @param   string   $org            The organization name.
     * @param   string   $name           Name of the runner.
     * @param   array    $image          The image of runner.
     * @param   string   $size           The machine size of the runner.
     * @param   integer  $runnerGroupId  The existing runner group to add this runner to.
     * @param   array    $options        Optional body fields: maximum_runners, enable_static_ip, image_gen.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/hosted-runners#create-a-github-hosted-runner-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function create(string $org, string $name, array $image, string $size, int $runnerGroupId, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/hosted-runners';

        $data = array_merge(
            $options,
            [
                'name'            => $name,
                'image'           => $image,
                'size'            => $size,
                'runner_group_id' => $runnerGroupId,
            ]
        );

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Get a GitHub-hosted runner for an organization.
     *
     * @param   string   $org             The organization name.
     * @param   integer  $hostedRunnerId  The ID of the GitHub-hosted runner.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/hosted-runners#get-a-github-hosted-runner-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $org, int $hostedRunnerId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/hosted-runners/' . $hostedRunnerId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Update a GitHub-hosted runner for an organization.
     *
     * @param   string   $org             The organization name.
     * @param   integer  $hostedRunnerId  The ID of the GitHub-hosted runner.
     * @param   array    $options         Optional body fields: name, runner_group_id, maximum_runners, enable_static_ip, size, image_source, image_id, image_version, image_gen.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/hosted-runners#update-a-github-hosted-runner-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function edit(string $org, int $hostedRunnerId, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/hosted-runners/' . $hostedRunnerId;

        $data = (object) $options;

        return $this->processResponse($this->client->patch($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Delete a GitHub-hosted runner for an organization.
     *
     * @param   string   $org             The organization name.
     * @param   integer  $hostedRunnerId  The ID of the GitHub-hosted runner.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/hosted-runners#delete-a-github-hosted-runner-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function delete(string $org, int $hostedRunnerId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/hosted-runners/' . $hostedRunnerId;

        return $this->processResponse($this->client->delete($this->fetchUrl($path)), 202);
    }

    /**
     * List custom images for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/hosted-runners#list-custom-images-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getListCustomImages(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/hosted-runners/images/custom';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Get a custom image definition for GitHub Actions Hosted Runners.
     *
     * @param   string   $org                The organization name.
     * @param   integer  $imageDefinitionId  The ID of the custom image definition.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/hosted-runners#get-a-custom-image-definition-for-github-actions-hosted-runners
     * @since   __DEPLOY_VERSION__
     */
    public function getCustomImage(string $org, int $imageDefinitionId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/hosted-runners/images/custom/' . $imageDefinitionId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Delete a custom image from the organization.
     *
     * @param   string   $org                The organization name.
     * @param   integer  $imageDefinitionId  The ID of the custom image definition.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/hosted-runners#delete-a-custom-image-from-the-organization
     * @since   __DEPLOY_VERSION__
     */
    public function deleteCustomImage(string $org, int $imageDefinitionId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/hosted-runners/images/custom/' . $imageDefinitionId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List image versions of a custom image for an organization.
     *
     * @param   string   $org                The organization name.
     * @param   integer  $imageDefinitionId  The ID of the custom image definition.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/hosted-runners#list-image-versions-of-a-custom-image-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getListCustomImageVersions(string $org, int $imageDefinitionId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/hosted-runners/images/custom/' . $imageDefinitionId . '/versions';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Get an image version of a custom image for GitHub Actions Hosted Runners.
     *
     * @param   string   $org                The organization name.
     * @param   integer  $imageDefinitionId  The ID of the custom image definition.
     * @param   string   $version            The version of the custom image.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/hosted-runners#get-an-image-version-of-a-custom-image-for-github-actions-hosted-runners
     * @since   __DEPLOY_VERSION__
     */
    public function getCustomImageVersion(string $org, int $imageDefinitionId, string $version)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/hosted-runners/images/custom/' . $imageDefinitionId . '/versions/' . rawurlencode($version);

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Delete an image version of custom image from the organization.
     *
     * @param   string   $org                The organization name.
     * @param   integer  $imageDefinitionId  The ID of the custom image definition.
     * @param   string   $version            The version of the custom image.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/hosted-runners#delete-an-image-version-of-custom-image-from-the-organization
     * @since   __DEPLOY_VERSION__
     */
    public function deleteCustomImageVersion(string $org, int $imageDefinitionId, string $version)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/hosted-runners/images/custom/' . $imageDefinitionId . '/versions/' . rawurlencode($version);

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Get GitHub-owned images for GitHub-hosted runners in an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/hosted-runners#get-github-owned-images-for-github-hosted-runners-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getGithubOwnedImages(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/hosted-runners/images/github-owned';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Get partner images for GitHub-hosted runners in an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/hosted-runners#get-partner-images-for-github-hosted-runners-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getPartnerImages(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/hosted-runners/images/partner';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Get limits on GitHub-hosted runners for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/hosted-runners#get-limits-on-github-hosted-runners-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getLimits(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/hosted-runners/limits';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Get GitHub-hosted runners machine specs for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/hosted-runners#get-github-hosted-runners-machine-specs-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getMachineSizes(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/hosted-runners/machine-sizes';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Get platforms for GitHub-hosted runners in an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/hosted-runners#get-platforms-for-github-hosted-runners-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getPlatforms(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/hosted-runners/platforms';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }
}
