<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\Copilot;
use Joomla\Github\Package\Copilot\CloudAgentManagement;
use Joomla\Github\Package\Copilot\CodeReview;
use Joomla\Github\Package\Copilot\CodingAgentManagement;
use Joomla\Github\Package\Copilot\ContentExclusionManagement;
use Joomla\Github\Package\Copilot\TeamCustomizations;
use Joomla\Github\Package\Copilot\UsageMetrics;
use Joomla\Github\Package\Copilot\UserManagement;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Copilot.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Copilot::class)]
class CopilotTest extends GitHubTestCase
{
    /**
     * @var    Copilot  Object under test.
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

        $this->object = new Copilot($this->options, $this->client);
    }

    /**
     * Tests that the cloudAgentManagement sub-package is resolved.
     *
     * @return  void
     */
    public function testGetCloudAgentManagement(): void
    {
        $this->assertInstanceOf(CloudAgentManagement::class, $this->object->cloudAgentManagement);
    }

    /**
     * Tests that the codeReview sub-package is resolved.
     *
     * @return  void
     */
    public function testGetCodeReview(): void
    {
        $this->assertInstanceOf(CodeReview::class, $this->object->codeReview);
    }

    /**
     * Tests that the codingAgentManagement sub-package is resolved.
     *
     * @return  void
     */
    public function testGetCodingAgentManagement(): void
    {
        $this->assertInstanceOf(CodingAgentManagement::class, $this->object->codingAgentManagement);
    }

    /**
     * Tests that the contentExclusionManagement sub-package is resolved.
     *
     * @return  void
     */
    public function testGetContentExclusionManagement(): void
    {
        $this->assertInstanceOf(ContentExclusionManagement::class, $this->object->contentExclusionManagement);
    }

    /**
     * Tests that the teamCustomizations sub-package is resolved.
     *
     * @return  void
     */
    public function testGetTeamCustomizations(): void
    {
        $this->assertInstanceOf(TeamCustomizations::class, $this->object->teamCustomizations);
    }

    /**
     * Tests that the usageMetrics sub-package is resolved.
     *
     * @return  void
     */
    public function testGetUsageMetrics(): void
    {
        $this->assertInstanceOf(UsageMetrics::class, $this->object->usageMetrics);
    }

    /**
     * Tests that the userManagement sub-package is resolved.
     *
     * @return  void
     */
    public function testGetUserManagement(): void
    {
        $this->assertInstanceOf(UserManagement::class, $this->object->userManagement);
    }
}
