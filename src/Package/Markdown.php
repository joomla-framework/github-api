<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package;

use Joomla\Github\AbstractPackage;
use Joomla\Http\Exception\UnexpectedResponseException;

/**
 * GitHub API Markdown class.
 *
 * @link   https://developer.github.com/v3/markdown
 *
 * @since  1.0
 */
class Markdown extends AbstractPackage
{
    /**
     * Render an arbitrary Markdown document.
     *
     * @param   string  $text     The text object being parsed.
     * @param   string  $mode     The parsing mode; valid options are 'markdown' or 'gfm'.
     * @param   string  $context  An optional repository context, only used in 'gfm' mode.
     *
     * @return  string  Formatted HTML
     *
     * @since   1.0
     * @throws  UnexpectedResponseException
     * @throws  \InvalidArgumentException
     */
    public function render($text, $mode = 'gfm', $context = null)
    {
        // The valid modes
        $validModes = ['gfm', 'markdown'];

        // Make sure the scope is valid
        if (!\in_array($mode, $validModes)) {
            throw new \InvalidArgumentException(sprintf('The %s mode is not valid. Valid modes are "gfm" or "markdown".', $mode));
        }

        // Build the request path.
        $path = '/markdown';

        // Build the request data.
        $data = str_replace(
            '\\/',
            '/',
            json_encode(
                [
                    'text'    => $text,
                    'mode'    => $mode,
                    'context' => $context,
                ]
            )
        );

        // Send the request.
        $response = $this->client->post($this->fetchUrl($path), $data);

        // Validate the response code.
        if ($response->code != 200) {
            // Decode the error response and throw an exception.
            $error   = json_decode($response->body);
            $message = isset($error->message) ? $error->message : 'Invalid response received from GitHub.';

            throw new UnexpectedResponseException($response, $message, $response->code);
        }

        return $response->body;
    }
}
