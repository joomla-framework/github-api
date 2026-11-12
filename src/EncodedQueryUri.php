<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github;

use Joomla\Uri\Uri;

/**
 * URI that percent-encodes the query values it renders.
 *
 * Joomla\Uri\Uri decodes the query it builds from its variables, so a value containing "&", "#", "+" or a space
 * would break the request or add parameters. This class encodes the query according to RFC 3986 instead.
 *
 * @since       __DEPLOY_VERSION__
 * @internal
 */
final class EncodedQueryUri extends Uri
{
    /**
     * Build a query from an array of variables, percent-encoded according to RFC 3986.
     *
     * @param   array  $params  The query variables.
     *
     * @return  string  The encoded query.
     *
     * @since   __DEPLOY_VERSION__
     */
    protected static function buildQuery(array $params)
    {
        return http_build_query($params, '', '&', \PHP_QUERY_RFC3986);
    }
}
