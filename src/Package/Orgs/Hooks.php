<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Orgs;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Orgs Hooks class for the Joomla Framework.
 *
 * All actions against organization webhooks require the authenticated user to be an admin of the organization being managed.
 * Additionally, OAuth tokens require the "admin:org_hook" scope.
 *
 * @link   https://developer.github.com/v3/orgs/hooks/
 *
 * @since  1.4.0
 */
class Hooks extends AbstractPackage
{
    /**
     * List hooks.
     *
     * @param   string  $org  The name of the organization.
     *
     * @return  object
     *
     * @since   1.4.0
     */
    public function getList($org)
    {
        // Build the request path.
        $path = "/orgs/$org/hooks";

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Get single hook.
     *
     * @param   string   $org  The name of the organization.
     * @param   integer  $id   The hook id.
     *
     * @return  object
     *
     * @since   1.4.0
     */
    public function get($org, $id)
    {
        // Build the request path.
        $path = "/orgs/$org/hooks/" . (int) $id;

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Create a hook.
     *
     * @param   string   $org          The name of the organization.
     * @param   string   $url          The URL to which the payloads will be delivered.
     * @param   string   $contentType  The media type used to serialize the payloads. Supported values include "json" and "form".
     * @param   string   $secret       If provided, payloads will be delivered with an X-Hub-Signature header.
     *                                 The value of this header is computed as the
     *                                 [HMAC hex digest of the body, using the secret as the key][hub-signature].
     * @param   boolean  $insecureSsl  Determines whether the SSL certificate of the host for url will be verified when delivering payloads.
     *                                 If false, verification is performed.  If true, verification is not performed.
     * @param   array    $events       Determines what events the hook is triggered for.
     * @param   boolean  $active       Determines whether the hook is actually triggered on pushes.
     *
     * @return  object
     *
     * @since   1.4.0
     * @throws  \UnexpectedValueException
     */
    public function create($org, $url, $contentType = 'form', $secret = null, $insecureSsl = false, array $events = ['push'], $active = true)
    {
        // Build the request path.
        $path = "/orgs/$org/hooks";

        if (\in_array($contentType, ['form', 'json']) == false) {
            throw new \UnexpectedValueException('Content type must be either "form" or "json".');
        }

        $config = [
            'url'          => $url,
            'content_type' => $contentType,
            'insecure_ssl' => (int) $insecureSsl,
        ];

        if ($secret) {
            $config['secret'] = $secret;
        }

        $data = [
            'name'   => 'web',
            'active' => $active,
            'config' => (object) $config,
        ];

        if (!empty($events)) {
            // Check to ensure all events are in the allowed list
            foreach ($events as $event) {
                if (!\in_array($event, $this->hookEvents)) {
                    throw new \RuntimeException('Your events array contains an unauthorized event.');
                }
            }

            $data['events'] = $events;
        }

        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), $data),
            201
        );
    }

    /**
     * Edit a hook.
     *
     * This method never edited a hook: it sent the request to the endpoint that creates one, and it has no parameter
     * for the hook ID. It now throws an exception instead of creating a duplicate hook.
     *
     * @param   string   $org          The name of the organization.
     * @param   string   $url          The URL to which the payloads will be delivered.
     * @param   string   $contentType  The media type used to serialize the payloads. Supported values include "json" and "form".
     * @param   string   $secret       If provided, payloads will be delivered with an X-Hub-Signature header.
     *                                 The value of this header is computed as the
     *                                 [HMAC hex digest of the body, using the secret as the key][hub-signature].
     * @param   boolean  $insecureSsl  Determines whether the SSL certificate of the host for url will be verified when delivering payloads.
     *                                 If false, verification is performed.  If true, verification is not performed.
     * @param   array    $events       Determines what events the hook is triggered for.
     * @param   boolean  $active       Determines whether the hook is actually triggered on pushes.
     *
     * @return  object
     *
     * @since   1.4.0
     * @throws  \BadMethodCallException
     * @deprecated  5.0 Use editHook() instead.
     */
    public function edit($org, $url, $contentType = null, $secret = null, $insecureSsl = null, array $events = [], $active = null)
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, use %s::editHook() instead.',
            __METHOD__,
            self::class
        );

        throw new \BadMethodCallException(
            sprintf('%s() cannot edit a hook because it has no hook ID; use %s::editHook() instead.', __METHOD__, self::class)
        );
    }

    /**
     * Edit a hook.
     *
     * Only the given values are changed.
     *
     * @param   string        $org          The name of the organization.
     * @param   integer       $id           The hook ID.
     * @param   string|null   $url          The URL to which the payloads will be delivered.
     * @param   string|null   $contentType  The media type used to serialize the payloads. Supported values are "json" and "form".
     * @param   string|null   $secret       If provided, payloads will be delivered with an X-Hub-Signature header.
     * @param   boolean|null  $insecureSsl  Determines whether the SSL certificate of the host for url will be verified when
     *                                      delivering payloads. If false, verification is performed. If true, it is not.
     * @param   array         $events       Determines what events the hook is triggered for. Empty to leave them unchanged.
     * @param   boolean|null  $active       Determines whether the hook is actually triggered.
     *
     * @return  object
     *
     * @since   __DEPLOY_VERSION__
     * @throws  \UnexpectedValueException
     * @throws  \RuntimeException
     */
    public function editHook(
        string $org,
        int $id,
        ?string $url = null,
        ?string $contentType = null,
        ?string $secret = null,
        ?bool $insecureSsl = null,
        array $events = [],
        ?bool $active = null
    ) {
        // Build the request path.
        $path = "/orgs/$org/hooks/" . $id;

        $config = [];

        if ($url !== null) {
            $config['url'] = $url;
        }

        if ($contentType !== null) {
            if (\in_array($contentType, ['form', 'json']) == false) {
                throw new \UnexpectedValueException('Content type must be either "form" or "json".');
            }

            $config['content_type'] = $contentType;
        }

        if ($insecureSsl !== null) {
            $config['insecure_ssl'] = (int) $insecureSsl;
        }

        if ($secret !== null) {
            $config['secret'] = $secret;
        }

        $data = [];

        if ($config) {
            $data['config'] = $config;
        }

        if ($active !== null) {
            $data['active'] = $active;
        }

        if (!empty($events)) {
            // Check to ensure all events are in the allowed list
            foreach ($events as $event) {
                if (!\in_array($event, $this->hookEvents)) {
                    throw new \RuntimeException('Your events array contains an unauthorized event.');
                }
            }

            $data['events'] = $events;
        }

        return $this->processResponse(
            $this->client->patch($this->fetchUrl($path), json_encode($data))
        );
    }

    /**
     * Ping a hook.
     *
     * @param   string   $org  The name of the organization
     * @param   integer  $id   ID of the hook to ping
     *
     * @return  object
     *
     * @since   1.4.0
     * @throws  \DomainException
     */
    public function ping($org, $id)
    {
        // Build the request path.
        $path = "/orgs/$org/hooks/$id/pings";

        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), json_encode('')),
            204
        );
    }

    /**
     * Delete a hook.
     *
     * @param   string   $org  The name of the organization
     * @param   integer  $id   ID of the hook to delete
     *
     * @return  object
     *
     * @since   1.4.0
     */
    public function delete($org, $id)
    {
        // Build the request path.
        $path = "/orgs/$org/hooks/$id";

        return $this->processResponse(
            $this->client->delete($this->fetchUrl($path)),
            204
        );
    }
}
