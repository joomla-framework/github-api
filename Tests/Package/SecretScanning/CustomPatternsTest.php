<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\SecretScanning;

use Joomla\Github\Package\SecretScanning\CustomPatterns;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for SecretScanning\CustomPatterns.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(CustomPatterns::class)]
class CustomPatternsTest extends GitHubTestCase
{
    /**
     * @var    CustomPatterns  Object under test.
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

        $this->object = new CustomPatterns($this->options, $this->client);
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
            ->with('/orgs/joomla/secret-scanning/custom-patterns?state=published', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForOrg('joomla', ['state' => 'published'])
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
            ->with('/orgs/joomla/secret-scanning/custom-patterns', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getListForOrg('joomla');
    }

    /**
     * Tests the createForOrg method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCreateForOrg()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/secret-scanning/custom-patterns', json_encode(['patterns' => [['name' => 'Token', 'pattern' => '[a-z]{32}']]]), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createForOrg('joomla', [['name' => 'Token', 'pattern' => '[a-z]{32}']])
        );
    }

    /**
     * Tests the createForOrg method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCreateForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/secret-scanning/custom-patterns', json_encode(['patterns' => [['name' => 'Token', 'pattern' => '[a-z]{32}']]]), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->createForOrg('joomla', [['name' => 'Token', 'pattern' => '[a-z]{32}']]);
    }

    /**
     * Tests the deleteForOrg method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testDeleteForOrg()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/secret-scanning/custom-patterns', [], 0, json_encode(['post_delete_action' => 'close_alerts', 'patterns' => [['id' => 3, 'custom_pattern_version' => 'abc']]]))
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteForOrg('joomla', [['id' => 3, 'custom_pattern_version' => 'abc']], ['post_delete_action' => 'close_alerts']));
    }

    /**
     * Tests the deleteForOrg method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testDeleteForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/secret-scanning/custom-patterns', [], 0, json_encode(['patterns' => [['id' => 3, 'custom_pattern_version' => 'abc']]]))
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->deleteForOrg('joomla', [['id' => 3, 'custom_pattern_version' => 'abc']]);
    }

    /**
     * Tests the editForOrg method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testEditForOrg()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/secret-scanning/custom-patterns/3', json_encode(['pattern' => '[a-z]{40}', 'custom_pattern_version' => 'abc']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->editForOrg('joomla', 3, 'abc', ['pattern' => '[a-z]{40}'])
        );
    }

    /**
     * Tests the editForOrg method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testEditForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/secret-scanning/custom-patterns/3', json_encode(['custom_pattern_version' => 'abc']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->editForOrg('joomla', 3, 'abc');
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
            ->with('/repos/joomla/joomla-platform/secret-scanning/custom-patterns?sort=name', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForRepo('joomla', 'joomla-platform', ['sort' => 'name'])
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
            ->with('/repos/joomla/joomla-platform/secret-scanning/custom-patterns', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getListForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the createForRepo method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCreateForRepo()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/secret-scanning/custom-patterns', json_encode(['patterns' => [['name' => 'Token', 'pattern' => '[a-z]{32}']]]), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createForRepo('joomla', 'joomla-platform', [['name' => 'Token', 'pattern' => '[a-z]{32}']])
        );
    }

    /**
     * Tests the createForRepo method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCreateForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/secret-scanning/custom-patterns', json_encode(['patterns' => [['name' => 'Token', 'pattern' => '[a-z]{32}']]]), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->createForRepo('joomla', 'joomla-platform', [['name' => 'Token', 'pattern' => '[a-z]{32}']]);
    }

    /**
     * Tests the deleteForRepo method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testDeleteForRepo()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/secret-scanning/custom-patterns', [], 0, json_encode(['post_delete_action' => 'close_alerts', 'patterns' => [['id' => 3, 'custom_pattern_version' => 'abc']]]))
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteForRepo('joomla', 'joomla-platform', [['id' => 3, 'custom_pattern_version' => 'abc']], ['post_delete_action' => 'close_alerts']));
    }

    /**
     * Tests the deleteForRepo method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testDeleteForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/secret-scanning/custom-patterns', [], 0, json_encode(['patterns' => [['id' => 3, 'custom_pattern_version' => 'abc']]]))
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->deleteForRepo('joomla', 'joomla-platform', [['id' => 3, 'custom_pattern_version' => 'abc']]);
    }

    /**
     * Tests the editForRepo method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testEditForRepo()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/secret-scanning/custom-patterns/3', json_encode(['pattern' => '[a-z]{40}', 'custom_pattern_version' => 'abc']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->editForRepo('joomla', 'joomla-platform', 3, 'abc', ['pattern' => '[a-z]{40}'])
        );
    }

    /**
     * Tests the editForRepo method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testEditForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/secret-scanning/custom-patterns/3', json_encode(['custom_pattern_version' => 'abc']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->editForRepo('joomla', 'joomla-platform', 3, 'abc');
    }
}
