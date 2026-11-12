<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\SecretScanning;
use Joomla\Github\Package\SecretScanning\CustomPatterns;
use Joomla\Github\Package\SecretScanning\PushProtection;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for SecretScanning.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(SecretScanning::class)]
class SecretScanningTest extends GitHubTestCase
{
    /**
     * @var    SecretScanning  Object under test.
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

        $this->object = new SecretScanning($this->options, $this->client);
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
        $this->assertInstanceOf(CustomPatterns::class, $this->object->customPatterns);
        $this->assertInstanceOf(PushProtection::class, $this->object->pushProtection);
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

    /**
     * Tests the getListForOrg method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetListForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/secret-scanning/alerts?page=2&per_page=30&state=open&hide_secret=true', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForOrg('joomla', ['state' => 'open', 'hide_secret' => true], 2, 30)
        );
    }

    /**
     * Tests the getListForOrg method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetListForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/secret-scanning/alerts', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getListForOrg('joomla');
    }

    /**
     * Tests the getListForRepo method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetListForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/secret-scanning/alerts?page=2&per_page=30&is_publicly_leaked=false', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForRepo('joomla', 'joomla-platform', ['is_publicly_leaked' => false], 2, 30)
        );
    }

    /**
     * Tests the getListForRepo method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetListForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/secret-scanning/alerts', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getListForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the get method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/secret-scanning/alerts/42?hide_secret=true', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->get('joomla', 'joomla-platform', 42, ['hide_secret' => true])
        );
    }

    /**
     * Tests the get method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/secret-scanning/alerts/42', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->get('joomla', 'joomla-platform', 42);
    }

    /**
     * Tests the edit method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testEdit()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/secret-scanning/alerts/42', json_encode(['state' => 'resolved', 'resolution' => 'revoked']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->edit('joomla', 'joomla-platform', 42, ['state' => 'resolved', 'resolution' => 'revoked'])
        );
    }

    /**
     * Tests the edit method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testEditFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/secret-scanning/alerts/42', '{}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->edit('joomla', 'joomla-platform', 42);
    }

    /**
     * Tests the getLocations method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetLocations()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/secret-scanning/alerts/42/locations?page=2&per_page=30', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getLocations('joomla', 'joomla-platform', 42, 2, 30)
        );
    }

    /**
     * Tests the getLocations method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetLocationsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/secret-scanning/alerts/42/locations', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getLocations('joomla', 'joomla-platform', 42);
    }

    /**
     * Tests the createPushProtectionBypass method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCreatePushProtectionBypass()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/secret-scanning/push-protection-bypasses', json_encode(['reason' => 'used_in_tests', 'placeholder_id' => 'bypass_placeholder_id']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createPushProtectionBypass('joomla', 'joomla-platform', 'used_in_tests', 'bypass_placeholder_id')
        );
    }

    /**
     * Tests the createPushProtectionBypass method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCreatePushProtectionBypassFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/secret-scanning/push-protection-bypasses', json_encode(['reason' => 'used_in_tests', 'placeholder_id' => 'bypass_placeholder_id']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->createPushProtectionBypass('joomla', 'joomla-platform', 'used_in_tests', 'bypass_placeholder_id');
    }

    /**
     * Tests the getScanHistory method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetScanHistory()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/secret-scanning/scan-history', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getScanHistory('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the getScanHistory method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetScanHistoryFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/secret-scanning/scan-history', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getScanHistory('joomla', 'joomla-platform');
    }
}
