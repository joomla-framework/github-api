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
 * GitHub API Actions OpenID Connect class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/actions/oidc
 *
 * @since  __DEPLOY_VERSION__
 */
class Oidc extends AbstractPackage
{
    /**
     * List OIDC custom property inclusions for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/actions/oidc#list-oidc-custom-property-inclusions-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getListCustomPropertyInclusionsForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/oidc/customization/properties/repo';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Create an OIDC custom property inclusion for an organization.
     *
     * @param   string  $org                 The organization name.
     * @param   string  $customPropertyName  The name of the custom property to include in the OIDC token.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/oidc#create-an-oidc-custom-property-inclusion-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function createCustomPropertyInclusionForOrg(string $org, string $customPropertyName)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/oidc/customization/properties/repo';

        $data = [
            'custom_property_name' => $customPropertyName,
        ];

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Delete an OIDC custom property inclusion for an organization.
     *
     * @param   string  $org                 The organization name.
     * @param   string  $customPropertyName  The name of the custom property.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/oidc#delete-an-oidc-custom-property-inclusion-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function deleteCustomPropertyInclusionForOrg(string $org, string $customPropertyName)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/oidc/customization/properties/repo/' . rawurlencode($customPropertyName);

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Get the customization template for an OIDC subject claim for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/oidc#get-the-customization-template-for-an-oidc-subject-claim-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getCustomSubClaimForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/oidc/customization/sub';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set the customization template for an OIDC subject claim for an organization.
     *
     * @param   string  $org      The organization name.
     * @param   array   $options  Optional body fields: include_claim_keys, use_immutable_subject.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/oidc#set-the-customization-template-for-an-oidc-subject-claim-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function editCustomSubClaimForOrg(string $org, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/oidc/customization/sub';

        $data = (object) $options;

        return $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Get the customization template for an OIDC subject claim for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/oidc#get-the-customization-template-for-an-oidc-subject-claim-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getCustomSubClaimForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/oidc/customization/sub';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set the customization template for an OIDC subject claim for a repository.
     *
     * @param   string   $owner       The account owner of the repository.
     * @param   string   $repo        The name of the repository.
     * @param   boolean  $useDefault  Whether to use the default template or not.
     * @param   array    $options     Optional body fields: include_claim_keys, use_immutable_subject.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/oidc#set-the-customization-template-for-an-oidc-subject-claim-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function setCustomSubClaimForRepo(string $owner, string $repo, bool $useDefault, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/oidc/customization/sub';

        $data = array_merge(
            $options,
            [
                'use_default' => $useDefault,
            ]
        );

        return $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 201);
    }
}
