<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Copilot;

use Joomla\Github\Package\Copilot\ContentExclusionManagement;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Copilot\ContentExclusionManagement.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(ContentExclusionManagement::class)]
class ContentExclusionManagementTest extends GitHubTestCase
{
    /**
     * @var    ContentExclusionManagement  Object under test.
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

        $this->object = new ContentExclusionManagement($this->options, $this->client);
    }

    /**
     * Tests the get method.
     *
     * @return  void
     */
    public function testGet(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/content_exclusion', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->get('joomla')
        );
    }

    /**
     * Tests the get method.
     *
     * @return  void
     */
    public function testGetFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/content_exclusion', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->get('joomla');
    }

    /**
     * Tests the set method.
     *
     * @return  void
     */
    public function testSet(): void
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/copilot/content_exclusion', json_encode(['octo-repo' => ['/src/some-dir/kernel.rs']]), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->set('joomla', ['octo-repo' => ['/src/some-dir/kernel.rs']])
        );
    }

    /**
     * Tests the set method.
     *
     * @return  void
     */
    public function testSetFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/copilot/content_exclusion', json_encode(['octo-repo' => ['/src/some-dir/kernel.rs']]), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->set('joomla', ['octo-repo' => ['/src/some-dir/kernel.rs']]);
    }
}
