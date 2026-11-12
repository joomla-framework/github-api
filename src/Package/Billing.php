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
 * GitHub API Billing class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/billing
 *
 * @since  __DEPLOY_VERSION__
 *
 * @property-read  Billing\Budgets  $budgets  GitHub API object for budgets.
 * @property-read  Billing\Usage    $usage    GitHub API object for usage.
 */
class Billing extends AbstractPackage
{
}
