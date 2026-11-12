<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\Apps;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Apps.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Apps::class)]
class AppsTest extends GitHubTestCase
{
    /**
     * @var    Apps  Object under test.
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

        $this->object = new Apps($this->options, $this->client);
    }

    /**
     * Tests the getAuthenticated method.
     *
     * @return  void
     */
    public function testGetAuthenticated()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/app', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getAuthenticated()
        );
    }

    /**
     * Tests the getAuthenticated method - failure.
     *
     * @return  void
     */
    public function testGetAuthenticatedFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getAuthenticated();
    }

    /**
     * Tests the createFromManifest method.
     *
     * @return  void
     */
    public function testCreateFromManifest()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);
        $this->client->expects($this->once())
            ->method('post')
            ->with('/app-manifests/abc123/conversions', '', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createFromManifest('abc123')
        );
    }

    /**
     * Tests the createFromManifest method - failure.
     *
     * @return  void
     */
    public function testCreateFromManifestFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->createFromManifest('abc123');
    }

    /**
     * Tests the getListInstallationRequests method.
     *
     * @return  void
     */
    public function testGetListInstallationRequests()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/app/installation-requests?page=2&per_page=10', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListInstallationRequests(2, 10)
        );
    }

    /**
     * Tests the getListInstallationRequests method - failure.
     *
     * @return  void
     */
    public function testGetListInstallationRequestsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListInstallationRequests(2, 10);
    }

    /**
     * Tests the getListInstallations method.
     *
     * @return  void
     */
    public function testGetListInstallations()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/app/installations?page=2&per_page=10&since=2026-01-01T00:00:00Z', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListInstallations(['since' => '2026-01-01T00:00:00Z'], 2, 10)
        );
    }

    /**
     * Tests the getListInstallations method - failure.
     *
     * @return  void
     */
    public function testGetListInstallationsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListInstallations(['since' => '2026-01-01T00:00:00Z'], 2, 10);
    }

    /**
     * Tests the getInstallation method.
     *
     * @return  void
     */
    public function testGetInstallation()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/app/installations/7', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getInstallation(7)
        );
    }

    /**
     * Tests the getInstallation method - failure.
     *
     * @return  void
     */
    public function testGetInstallationFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getInstallation(7);
    }

    /**
     * Tests the deleteInstallation method.
     *
     * @return  void
     */
    public function testDeleteInstallation()
    {
        $this->response = $this->getResponseObject('', 204);
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/app/installations/7', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->deleteInstallation(7));
    }

    /**
     * Tests the deleteInstallation method - failure.
     *
     * @return  void
     */
    public function testDeleteInstallationFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->deleteInstallation(7);
    }

    /**
     * Tests the createInstallationAccessToken method.
     *
     * @return  void
     */
    public function testCreateInstallationAccessToken()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);
        $body = '{"repository_ids":[1296269]}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/app/installations/7/access_tokens', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createInstallationAccessToken(7, ['repository_ids' => [1296269]])
        );
    }

    /**
     * Tests the createInstallationAccessToken method - failure.
     *
     * @return  void
     */
    public function testCreateInstallationAccessTokenFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->createInstallationAccessToken(7, ['repository_ids' => [1296269]]);
    }

    /**
     * Tests the suspendInstallation method.
     *
     * @return  void
     */
    public function testSuspendInstallation()
    {
        $this->response = $this->getResponseObject('', 204);
        $this->client->expects($this->once())
            ->method('put')
            ->with('/app/installations/7/suspended', '', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->suspendInstallation(7));
    }

    /**
     * Tests the suspendInstallation method - failure.
     *
     * @return  void
     */
    public function testSuspendInstallationFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->suspendInstallation(7);
    }

    /**
     * Tests the unsuspendInstallation method.
     *
     * @return  void
     */
    public function testUnsuspendInstallation()
    {
        $this->response = $this->getResponseObject('', 204);
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/app/installations/7/suspended', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->unsuspendInstallation(7));
    }

    /**
     * Tests the unsuspendInstallation method - failure.
     *
     * @return  void
     */
    public function testUnsuspendInstallationFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->unsuspendInstallation(7);
    }

    /**
     * Tests the scopeToken method.
     *
     * @return  void
     */
    public function testScopeToken()
    {
        $body = '{"target":"octocat","access_token":"e72e16c7e42f292c6912e7710c838347ae178b4a"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/applications/Iv1.8a61f9b3a7aba766/token/scoped', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->scopeToken('Iv1.8a61f9b3a7aba766', 'e72e16c7e42f292c6912e7710c838347ae178b4a', ['target' => 'octocat'])
        );
    }

    /**
     * Tests the scopeToken method - failure.
     *
     * @return  void
     */
    public function testScopeTokenFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->scopeToken('Iv1.8a61f9b3a7aba766', 'e72e16c7e42f292c6912e7710c838347ae178b4a', ['target' => 'octocat']);
    }

    /**
     * Tests the getBySlug method.
     *
     * @return  void
     */
    public function testGetBySlug()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/apps/octoapp', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getBySlug('octoapp')
        );
    }

    /**
     * Tests the getBySlug method - failure.
     *
     * @return  void
     */
    public function testGetBySlugFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getBySlug('octoapp');
    }

    /**
     * Tests the getInstallationForOrg method.
     *
     * @return  void
     */
    public function testGetInstallationForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/installation', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getInstallationForOrg('joomla')
        );
    }

    /**
     * Tests the getInstallationForOrg method - failure.
     *
     * @return  void
     */
    public function testGetInstallationForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getInstallationForOrg('joomla');
    }

    /**
     * Tests the getInstallationForRepo method.
     *
     * @return  void
     */
    public function testGetInstallationForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/installation', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getInstallationForRepo('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the getInstallationForRepo method - failure.
     *
     * @return  void
     */
    public function testGetInstallationForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getInstallationForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the getInstallationForUser method.
     *
     * @return  void
     */
    public function testGetInstallationForUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/installation', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getInstallationForUser('octocat')
        );
    }

    /**
     * Tests the getInstallationForUser method - failure.
     *
     * @return  void
     */
    public function testGetInstallationForUserFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getInstallationForUser('octocat');
    }
}
