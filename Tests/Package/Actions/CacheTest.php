<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Actions;

use Joomla\Github\Package\Actions\Cache;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for the GitHub API package.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Cache::class)]
class CacheTest extends GitHubTestCase
{
    /**
     * @var    Cache  Object under test.
     * @since  __DEPLOY_VERSION__
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return  void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Cache($this->options, $this->client);
    }

    /**
     * Tests the getRetentionLimitForOrg method.
     *
     * @return  void
     */
    public function testGetRetentionLimitForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/organizations/joomla/actions/cache/retention-limit', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getRetentionLimitForOrg('joomla'));
    }

    /**
     * Tests the getRetentionLimitForOrg method.
     *
     * @return  void
     */
    public function testGetRetentionLimitForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getRetentionLimitForOrg('joomla');
    }

    /**
     * Tests the setRetentionLimitForOrg method.
     *
     * @return  void
     */
    public function testSetRetentionLimitForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"max_cache_retention_days":7}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/organizations/joomla/actions/cache/retention-limit', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setRetentionLimitForOrg('joomla', ['max_cache_retention_days' => 7]));
    }

    /**
     * Tests the setRetentionLimitForOrg method.
     *
     * @return  void
     */
    public function testSetRetentionLimitForOrgDefaults()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/organizations/joomla/actions/cache/retention-limit', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setRetentionLimitForOrg('joomla'));
    }

    /**
     * Tests the setRetentionLimitForOrg method.
     *
     * @return  void
     */
    public function testSetRetentionLimitForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setRetentionLimitForOrg('joomla', ['max_cache_retention_days' => 7]);
    }

    /**
     * Tests the getStorageLimitForOrg method.
     *
     * @return  void
     */
    public function testGetStorageLimitForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/organizations/joomla/actions/cache/storage-limit', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getStorageLimitForOrg('joomla'));
    }

    /**
     * Tests the getStorageLimitForOrg method.
     *
     * @return  void
     */
    public function testGetStorageLimitForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getStorageLimitForOrg('joomla');
    }

    /**
     * Tests the setStorageLimitForOrg method.
     *
     * @return  void
     */
    public function testSetStorageLimitForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"max_cache_size_gb":7}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/organizations/joomla/actions/cache/storage-limit', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setStorageLimitForOrg('joomla', ['max_cache_size_gb' => 7]));
    }

    /**
     * Tests the setStorageLimitForOrg method.
     *
     * @return  void
     */
    public function testSetStorageLimitForOrgDefaults()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/organizations/joomla/actions/cache/storage-limit', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setStorageLimitForOrg('joomla'));
    }

    /**
     * Tests the setStorageLimitForOrg method.
     *
     * @return  void
     */
    public function testSetStorageLimitForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setStorageLimitForOrg('joomla', ['max_cache_size_gb' => 7]);
    }

    /**
     * Tests the getUsageForOrg method.
     *
     * @return  void
     */
    public function testGetUsageForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/cache/usage', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getUsageForOrg('joomla'));
    }

    /**
     * Tests the getUsageForOrg method.
     *
     * @return  void
     */
    public function testGetUsageForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getUsageForOrg('joomla');
    }

    /**
     * Tests the getListUsageByRepoForOrg method.
     *
     * @return  void
     */
    public function testGetListUsageByRepoForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/cache/usage-by-repository?page=2&per_page=30', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListUsageByRepoForOrg('joomla', 2, 30));
    }

    /**
     * Tests the getListUsageByRepoForOrg method.
     *
     * @return  void
     */
    public function testGetListUsageByRepoForOrgDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/cache/usage-by-repository', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListUsageByRepoForOrg('joomla'));
    }

    /**
     * Tests the getListUsageByRepoForOrg method.
     *
     * @return  void
     */
    public function testGetListUsageByRepoForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListUsageByRepoForOrg('joomla', 2, 30);
    }

    /**
     * Tests the getRetentionLimitForRepo method.
     *
     * @return  void
     */
    public function testGetRetentionLimitForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/cache/retention-limit', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getRetentionLimitForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getRetentionLimitForRepo method.
     *
     * @return  void
     */
    public function testGetRetentionLimitForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getRetentionLimitForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the setRetentionLimitForRepo method.
     *
     * @return  void
     */
    public function testSetRetentionLimitForRepo()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"max_cache_retention_days":7}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/cache/retention-limit', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setRetentionLimitForRepo('joomla', 'joomla-platform', ['max_cache_retention_days' => 7]));
    }

    /**
     * Tests the setRetentionLimitForRepo method.
     *
     * @return  void
     */
    public function testSetRetentionLimitForRepoDefaults()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/cache/retention-limit', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setRetentionLimitForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the setRetentionLimitForRepo method.
     *
     * @return  void
     */
    public function testSetRetentionLimitForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setRetentionLimitForRepo('joomla', 'joomla-platform', ['max_cache_retention_days' => 7]);
    }

    /**
     * Tests the getStorageLimitForRepo method.
     *
     * @return  void
     */
    public function testGetStorageLimitForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/cache/storage-limit', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getStorageLimitForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getStorageLimitForRepo method.
     *
     * @return  void
     */
    public function testGetStorageLimitForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getStorageLimitForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the setStorageLimitForRepo method.
     *
     * @return  void
     */
    public function testSetStorageLimitForRepo()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"max_cache_size_gb":7}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/cache/storage-limit', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setStorageLimitForRepo('joomla', 'joomla-platform', ['max_cache_size_gb' => 7]));
    }

    /**
     * Tests the setStorageLimitForRepo method.
     *
     * @return  void
     */
    public function testSetStorageLimitForRepoDefaults()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/cache/storage-limit', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setStorageLimitForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the setStorageLimitForRepo method.
     *
     * @return  void
     */
    public function testSetStorageLimitForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setStorageLimitForRepo('joomla', 'joomla-platform', ['max_cache_size_gb' => 7]);
    }

    /**
     * Tests the getUsageForRepo method.
     *
     * @return  void
     */
    public function testGetUsageForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/cache/usage', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getUsageForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getUsageForRepo method.
     *
     * @return  void
     */
    public function testGetUsageForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getUsageForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the getListForRepo method.
     *
     * @return  void
     */
    public function testGetListForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/caches?page=2&per_page=30&ref=ref-value', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForRepo('joomla', 'joomla-platform', ['ref' => 'ref-value'], 2, 30));
    }

    /**
     * Tests the getListForRepo method.
     *
     * @return  void
     */
    public function testGetListForRepoDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/caches', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getListForRepo method.
     *
     * @return  void
     */
    public function testGetListForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForRepo('joomla', 'joomla-platform', ['ref' => 'ref-value'], 2, 30);
    }

    /**
     * Tests the deleteByKeyForRepo method.
     *
     * @return  void
     */
    public function testDeleteByKeyForRepo()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/actions/caches?key=key-value&ref=ref-value', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->deleteByKeyForRepo('joomla', 'joomla-platform', 'key-value', ['ref' => 'ref-value']));
    }

    /**
     * Tests the deleteByKeyForRepo method.
     *
     * @return  void
     */
    public function testDeleteByKeyForRepoDefaults()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/actions/caches?key=key-value', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->deleteByKeyForRepo('joomla', 'joomla-platform', 'key-value'));
    }

    /**
     * Tests the deleteByKeyForRepo method.
     *
     * @return  void
     */
    public function testDeleteByKeyForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->deleteByKeyForRepo('joomla', 'joomla-platform', 'key-value', ['ref' => 'ref-value']);
    }

    /**
     * Tests the deleteForRepo method.
     *
     * @return  void
     */
    public function testDeleteForRepo()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/actions/caches/1', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->deleteForRepo('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the deleteForRepo method.
     *
     * @return  void
     */
    public function testDeleteForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->deleteForRepo('joomla', 'joomla-platform', 1);
    }
}
