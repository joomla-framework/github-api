<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Apps;

use Joomla\Github\AbstractPackage;
use Joomla\Http\Exception\UnexpectedResponseException;

/**
 * GitHub API Apps Webhooks class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/apps/webhooks
 *
 * @since  __DEPLOY_VERSION__
 */
class Webhooks extends AbstractPackage
{
    /**
     * Get a webhook configuration for an app.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/webhooks#get-a-webhook-configuration-for-an-app
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getConfig()
    {
        // Build the request path.
        $path = '/app/hook/config';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Update a webhook configuration for an app.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   array  $options  Optional request body fields: url, content_type, secret, insecure_ssl.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/webhooks#update-a-webhook-configuration-for-an-app
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function editConfig(array $options = [])
    {
        // Build the request path.
        $path = '/app/hook/config';

        $data = json_encode((object) $options);

        return $this->processResponse($this->client->patch($this->fetchUrl($path), $data));
    }

    /**
     * List deliveries for an app webhook.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * This endpoint uses cursor-based pagination: pass the `cursor` filter from the `Link` header;
     * GitHub ignores `$page`, only `$limit` (per_page) is used.
     *
     * @param   array    $filters  Optional query parameters: cursor, status.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/apps/webhooks#list-deliveries-for-an-app-webhook
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListDeliveries(array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/app/hook/deliveries';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get a delivery for an app webhook.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   integer  $deliveryId  Webhook delivery identifier.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/webhooks#get-a-delivery-for-an-app-webhook
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getDelivery(int $deliveryId)
    {
        // Build the request path.
        $path = '/app/hook/deliveries/' . $deliveryId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Redeliver a delivery for an app webhook.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   integer  $deliveryId  Webhook delivery identifier.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/webhooks#redeliver-a-delivery-for-an-app-webhook
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function redeliver(int $deliveryId)
    {
        // Build the request path.
        $path = '/app/hook/deliveries/' . $deliveryId . '/attempts';

        return $this->processResponse($this->client->post($this->fetchUrl($path), ''), 202);
    }
}
