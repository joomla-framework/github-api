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
 * GitHub API Dependabot class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/dependabot
 *
 * @since  __DEPLOY_VERSION__
 *
 * @property-read  Dependabot\Alerts            $alerts            GitHub API object for Dependabot alerts.
 * @property-read  Dependabot\Secrets           $secrets           GitHub API object for Dependabot secrets.
 * @property-read  Dependabot\RepositoryAccess  $repositoryAccess  GitHub API object for Dependabot repository access.
 * @property-read  Dependabot\RunnerSettings    $runnerSettings    GitHub API object for Dependabot runner settings.
 */
class Dependabot extends AbstractPackage
{
}
