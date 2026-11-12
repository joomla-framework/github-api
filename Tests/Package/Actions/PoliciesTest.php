<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Actions;

use Joomla\Github\Package\Actions\Policies;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for the GitHub API package.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Policies::class)]
class PoliciesTest extends GitHubTestCase
{
    /**
     * @var    Policies  Object under test.
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

        $this->object = new Policies($this->options, $this->client);
    }

    /**
     * Tests the getListForOrg method.
     *
     * @return  void
     */
    public function testGetListForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/policies?page=2&per_page=30&has_parents=true', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForOrg('joomla', ['has_parents' => true], 2, 30));
    }

    /**
     * Tests the getListForOrg method.
     *
     * @return  void
     */
    public function testGetListForOrgDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/policies', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForOrg('joomla'));
    }

    /**
     * Tests the getListForOrg method.
     *
     * @return  void
     */
    public function testGetListForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForOrg('joomla', ['has_parents' => true], 2, 30);
    }

    /**
     * Tests the createForOrg method.
     *
     * @return  void
     */
    public function testCreateForOrg()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"conditions":{"id":"ubuntu-latest","source":"github"},"name":"name","enforcement":"enforcement"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/actions/policies', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createForOrg('joomla', 'name', 'enforcement', ['conditions' => ['id' => 'ubuntu-latest', 'source' => 'github']]));
    }

    /**
     * Tests the createForOrg method.
     *
     * @return  void
     */
    public function testCreateForOrgDefaults()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"name":"name","enforcement":"enforcement"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/actions/policies', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createForOrg('joomla', 'name', 'enforcement'));
    }

    /**
     * Tests the createForOrg method.
     *
     * @return  void
     */
    public function testCreateForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->createForOrg('joomla', 'name', 'enforcement', ['conditions' => ['id' => 'ubuntu-latest', 'source' => 'github']]);
    }

    /**
     * Tests the getForOrg method.
     *
     * @return  void
     */
    public function testGetForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/policies/1', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getForOrg('joomla', 1));
    }

    /**
     * Tests the getForOrg method.
     *
     * @return  void
     */
    public function testGetForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getForOrg('joomla', 1);
    }

    /**
     * Tests the editForOrg method.
     *
     * @return  void
     */
    public function testEditForOrg()
    {
        $body = '{"name":"name"}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/policies/1', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->editForOrg('joomla', 1, ['name' => 'name']));
    }

    /**
     * Tests the editForOrg method.
     *
     * @return  void
     */
    public function testEditForOrgDefaults()
    {
        $body = '{}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/policies/1', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->editForOrg('joomla', 1));
    }

    /**
     * Tests the editForOrg method.
     *
     * @return  void
     */
    public function testEditForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->editForOrg('joomla', 1, ['name' => 'name']);
    }

    /**
     * Tests the deleteForOrg method.
     *
     * @return  void
     */
    public function testDeleteForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/actions/policies/1', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->deleteForOrg('joomla', 1));
    }

    /**
     * Tests the deleteForOrg method.
     *
     * @return  void
     */
    public function testDeleteForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->deleteForOrg('joomla', 1);
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
            ->with('/repos/joomla/joomla-platform/actions/policies?page=2&per_page=30&has_parents=true', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForRepo('joomla', 'joomla-platform', ['has_parents' => true], 2, 30));
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
            ->with('/repos/joomla/joomla-platform/actions/policies', [], 0)
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

        $this->object->getListForRepo('joomla', 'joomla-platform', ['has_parents' => true], 2, 30);
    }

    /**
     * Tests the createForRepo method.
     *
     * @return  void
     */
    public function testCreateForRepo()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"conditions":{"id":"ubuntu-latest","source":"github"},"name":"name","enforcement":"enforcement"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/policies', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createForRepo('joomla', 'joomla-platform', 'name', 'enforcement', ['conditions' => ['id' => 'ubuntu-latest', 'source' => 'github']]));
    }

    /**
     * Tests the createForRepo method.
     *
     * @return  void
     */
    public function testCreateForRepoDefaults()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"name":"name","enforcement":"enforcement"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/policies', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createForRepo('joomla', 'joomla-platform', 'name', 'enforcement'));
    }

    /**
     * Tests the createForRepo method.
     *
     * @return  void
     */
    public function testCreateForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->createForRepo('joomla', 'joomla-platform', 'name', 'enforcement', ['conditions' => ['id' => 'ubuntu-latest', 'source' => 'github']]);
    }

    /**
     * Tests the getForRepo method.
     *
     * @return  void
     */
    public function testGetForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/policies/1', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getForRepo('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the getForRepo method.
     *
     * @return  void
     */
    public function testGetForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getForRepo('joomla', 'joomla-platform', 1);
    }

    /**
     * Tests the editForRepo method.
     *
     * @return  void
     */
    public function testEditForRepo()
    {
        $body = '{"name":"name"}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/policies/1', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->editForRepo('joomla', 'joomla-platform', 1, ['name' => 'name']));
    }

    /**
     * Tests the editForRepo method.
     *
     * @return  void
     */
    public function testEditForRepoDefaults()
    {
        $body = '{}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/policies/1', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->editForRepo('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the editForRepo method.
     *
     * @return  void
     */
    public function testEditForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->editForRepo('joomla', 'joomla-platform', 1, ['name' => 'name']);
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
            ->with('/repos/joomla/joomla-platform/actions/policies/1', [], 0)
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
