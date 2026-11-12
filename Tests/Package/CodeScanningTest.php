<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\CodeScanning;
use Joomla\Github\Package\CodeScanning\AiScan;
use Joomla\Github\Package\CodeScanning\Alerts;
use Joomla\Github\Package\CodeScanning\Analyses;
use Joomla\Github\Package\CodeScanning\Autofix;
use Joomla\Github\Package\CodeScanning\CodeqlDatabases;
use Joomla\Github\Package\CodeScanning\DefaultSetup;
use Joomla\Github\Package\CodeScanning\Sarifs;
use Joomla\Github\Package\CodeScanning\VariantAnalyses;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for CodeScanning.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(CodeScanning::class)]
class CodeScanningTest extends GitHubTestCase
{
    /**
     * @var    CodeScanning  Object under test.
     * @since  __DEPLOY_VERSION__
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new CodeScanning($this->options, $this->client);
    }

    /**
     * Tests that the sub-packages are resolved through the magic getter.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetSubPackages()
    {
        $this->assertInstanceOf(Alerts::class, $this->object->alerts);
        $this->assertInstanceOf(Autofix::class, $this->object->autofix);
        $this->assertInstanceOf(Analyses::class, $this->object->analyses);
        $this->assertInstanceOf(Sarifs::class, $this->object->sarifs);
        $this->assertInstanceOf(DefaultSetup::class, $this->object->defaultSetup);
        $this->assertInstanceOf(CodeqlDatabases::class, $this->object->codeqlDatabases);
        $this->assertInstanceOf(VariantAnalyses::class, $this->object->variantAnalyses);
        $this->assertInstanceOf(AiScan::class, $this->object->aiScan);
    }

    /**
     * Tests that an unknown sub-package throws an exception.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetInvalidSubPackage()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->object->unknown;
    }
}
