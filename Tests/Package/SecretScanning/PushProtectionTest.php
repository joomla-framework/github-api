<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\SecretScanning;

use Joomla\Github\Package\SecretScanning\PushProtection;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for SecretScanning\PushProtection.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(PushProtection::class)]
class PushProtectionTest extends GitHubTestCase
{
    /**
     * @var    PushProtection  Object under test.
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

        $this->object = new PushProtection($this->options, $this->client);
    }

    /**
     * Tests the getPatternConfigurations method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetPatternConfigurations()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/secret-scanning/pattern-configurations', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getPatternConfigurations('joomla')
        );
    }

    /**
     * Tests the getPatternConfigurations method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetPatternConfigurationsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/secret-scanning/pattern-configurations', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getPatternConfigurations('joomla');
    }

    /**
     * Tests the editPatternConfigurations method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testEditPatternConfigurations()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/secret-scanning/pattern-configurations', json_encode(['pattern_config_version' => '0ujsswThIGTUYm2K8FjOOfXtY1K']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->editPatternConfigurations('joomla', ['pattern_config_version' => '0ujsswThIGTUYm2K8FjOOfXtY1K'])
        );
    }

    /**
     * Tests the editPatternConfigurations method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testEditPatternConfigurationsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/secret-scanning/pattern-configurations', '{}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->editPatternConfigurations('joomla');
    }
}
