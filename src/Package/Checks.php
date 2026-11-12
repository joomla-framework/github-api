<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Checks class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/checks
 *
 * @since  __DEPLOY_VERSION__
 *
 * @property-read  Checks\Runs    $runs    GitHub API object for check runs.
 * @property-read  Checks\Suites  $suites  GitHub API object for check suites.
 */
class Checks extends AbstractPackage
{
}
