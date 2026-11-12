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
 * GitHub API Code Scanning class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/code-scanning
 *
 * @since  __DEPLOY_VERSION__
 *
 * @property-read  CodeScanning\Alerts           $alerts           GitHub API object for code scanning alerts.
 * @property-read  CodeScanning\Autofix          $autofix          GitHub API object for code scanning autofixes.
 * @property-read  CodeScanning\Analyses         $analyses         GitHub API object for code scanning analyses.
 * @property-read  CodeScanning\Sarifs           $sarifs           GitHub API object for SARIF uploads.
 * @property-read  CodeScanning\DefaultSetup     $defaultSetup     GitHub API object for the code scanning default setup.
 * @property-read  CodeScanning\CodeqlDatabases  $codeqlDatabases  GitHub API object for CodeQL databases.
 * @property-read  CodeScanning\VariantAnalyses  $variantAnalyses  GitHub API object for CodeQL variant analyses.
 * @property-read  CodeScanning\AiScan           $aiScan           GitHub API object for the AI scan settings.
 */
class CodeScanning extends AbstractPackage
{
}
