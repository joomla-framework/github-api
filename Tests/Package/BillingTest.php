<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\Billing;
use Joomla\Github\Package\Billing\Budgets;
use Joomla\Github\Package\Billing\Usage;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Billing.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Billing::class)]
class BillingTest extends GitHubTestCase
{
    /**
     * @var    Billing  Object under test.
     * @since  __DEPLOY_VERSION__
     */
    protected $object;

    /**
     * Sets up the fixture.
     *
     * @return  void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Billing($this->options, $this->client);
    }

    /**
     * Tests that the budgets sub-package is resolved.
     *
     * @return  void
     */
    public function testGetBudgets(): void
    {
        $this->assertInstanceOf(Budgets::class, $this->object->budgets);
    }

    /**
     * Tests that the usage sub-package is resolved.
     *
     * @return  void
     */
    public function testGetUsage(): void
    {
        $this->assertInstanceOf(Usage::class, $this->object->usage);
    }
}
