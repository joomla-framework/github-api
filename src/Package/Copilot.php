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
 * GitHub API Copilot class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/copilot
 *
 * @since  __DEPLOY_VERSION__
 *
 * @property-read  Copilot\CloudAgentManagement        $cloudAgentManagement        GitHub API object for cloud agent management.
 * @property-read  Copilot\CodeReview                  $codeReview                  GitHub API object for code review.
 * @property-read  Copilot\CodingAgentManagement       $codingAgentManagement       GitHub API object for coding agent management.
 * @property-read  Copilot\ContentExclusionManagement  $contentExclusionManagement  GitHub API object for content exclusion management.
 * @property-read  Copilot\TeamCustomizations          $teamCustomizations          GitHub API object for team customizations.
 * @property-read  Copilot\UsageMetrics                $usageMetrics                GitHub API object for usage metrics.
 * @property-read  Copilot\UserManagement              $userManagement              GitHub API object for user management.
 */
class Copilot extends AbstractPackage
{
}
