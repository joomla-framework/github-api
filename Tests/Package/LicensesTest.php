<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\Licenses;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Licenses.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Licenses::class)]
class LicensesTest extends GitHubTestCase
{
    /**
     * @var    Licenses  Object under test.
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

        $this->object = new Licenses($this->options, $this->client);
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     */
    public function testGetList(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/licenses?page=2&per_page=10&featured=true', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getList(['featured' => true], 2, 10)
        );
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     */
    public function testGetListFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/licenses?page=2&per_page=10&featured=true', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getList(['featured' => true], 2, 10);
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
            ->with('/licenses/mit', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->get('mit')
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
            ->with('/licenses/mit', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->get('mit');
    }

    /**
     * Tests the getForRepo method.
     *
     * @return  void
     */
    public function testGetForRepo(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/license?ref=main', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getForRepo('joomla', 'joomla-platform', ['ref' => 'main'])
        );
    }

    /**
     * Tests the getForRepo method.
     *
     * @return  void
     */
    public function testGetForRepoFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/license?ref=main', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getForRepo('joomla', 'joomla-platform', ['ref' => 'main']);
    }
}
