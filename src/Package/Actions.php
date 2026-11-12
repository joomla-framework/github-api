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
 * GitHub API Actions class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/actions
 *
 * @since  __DEPLOY_VERSION__
 *
 * @property-read  Actions\Artifacts          $artifacts          GitHub API object for workflow artifacts.
 * @property-read  Actions\Cache              $cache              GitHub API object for GitHub Actions caches.
 * @property-read  Actions\ConcurrencyGroups  $concurrencyGroups  GitHub API object for concurrency groups.
 * @property-read  Actions\HostedRunners      $hostedRunners      GitHub API object for GitHub-hosted runners.
 * @property-read  Actions\Oidc               $oidc               GitHub API object for OpenID Connect subject claim customisation.
 * @property-read  Actions\Permissions        $permissions        GitHub API object for GitHub Actions permissions.
 * @property-read  Actions\Policies           $policies           GitHub API object for GitHub Actions policies.
 * @property-read  Actions\Secrets            $secrets            GitHub API object for GitHub Actions secrets.
 * @property-read  Actions\Variables          $variables          GitHub API object for GitHub Actions variables.
 * @property-read  Actions\RunnerGroups       $runnerGroups       GitHub API object for self-hosted runner groups.
 * @property-read  Actions\Runners            $runners            GitHub API object for self-hosted runners.
 * @property-read  Actions\Jobs               $jobs               GitHub API object for workflow jobs.
 * @property-read  Actions\Runs               $runs               GitHub API object for workflow runs.
 * @property-read  Actions\Workflows          $workflows          GitHub API object for workflows.
 */
class Actions extends AbstractPackage
{
}
