<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Actions;

use Joomla\Github\Package\Actions\Oidc;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for the GitHub API package.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Oidc::class)]
class OidcTest extends GitHubTestCase
{
    /**
     * @var    Oidc  Object under test.
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

        $this->object = new Oidc($this->options, $this->client);
    }

    /**
     * Tests the getListCustomPropertyInclusionsForOrg method.
     *
     * @return  void
     */
    public function testGetListCustomPropertyInclusionsForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/oidc/customization/properties/repo', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListCustomPropertyInclusionsForOrg('joomla'));
    }

    /**
     * Tests the getListCustomPropertyInclusionsForOrg method.
     *
     * @return  void
     */
    public function testGetListCustomPropertyInclusionsForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListCustomPropertyInclusionsForOrg('joomla');
    }

    /**
     * Tests the createCustomPropertyInclusionForOrg method.
     *
     * @return  void
     */
    public function testCreateCustomPropertyInclusionForOrg()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"custom_property_name":"custom-property-name"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/actions/oidc/customization/properties/repo', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createCustomPropertyInclusionForOrg('joomla', 'custom-property-name'));
    }

    /**
     * Tests the createCustomPropertyInclusionForOrg method.
     *
     * @return  void
     */
    public function testCreateCustomPropertyInclusionForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->createCustomPropertyInclusionForOrg('joomla', 'custom-property-name');
    }

    /**
     * Tests the deleteCustomPropertyInclusionForOrg method.
     *
     * @return  void
     */
    public function testDeleteCustomPropertyInclusionForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/actions/oidc/customization/properties/repo/team%20name', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->deleteCustomPropertyInclusionForOrg('joomla', 'team name'));
    }

    /**
     * Tests the deleteCustomPropertyInclusionForOrg method.
     *
     * @return  void
     */
    public function testDeleteCustomPropertyInclusionForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->deleteCustomPropertyInclusionForOrg('joomla', 'team name');
    }

    /**
     * Tests the getCustomSubClaimForOrg method.
     *
     * @return  void
     */
    public function testGetCustomSubClaimForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/oidc/customization/sub', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getCustomSubClaimForOrg('joomla'));
    }

    /**
     * Tests the getCustomSubClaimForOrg method.
     *
     * @return  void
     */
    public function testGetCustomSubClaimForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getCustomSubClaimForOrg('joomla');
    }

    /**
     * Tests the editCustomSubClaimForOrg method.
     *
     * @return  void
     */
    public function testEditCustomSubClaimForOrg()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"include_claim_keys":[1,2]}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/oidc/customization/sub', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->editCustomSubClaimForOrg('joomla', ['include_claim_keys' => [1, 2]]));
    }

    /**
     * Tests the editCustomSubClaimForOrg method.
     *
     * @return  void
     */
    public function testEditCustomSubClaimForOrgDefaults()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/oidc/customization/sub', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->editCustomSubClaimForOrg('joomla'));
    }

    /**
     * Tests the editCustomSubClaimForOrg method.
     *
     * @return  void
     */
    public function testEditCustomSubClaimForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->editCustomSubClaimForOrg('joomla', ['include_claim_keys' => [1, 2]]);
    }

    /**
     * Tests the getCustomSubClaimForRepo method.
     *
     * @return  void
     */
    public function testGetCustomSubClaimForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/oidc/customization/sub', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getCustomSubClaimForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getCustomSubClaimForRepo method.
     *
     * @return  void
     */
    public function testGetCustomSubClaimForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getCustomSubClaimForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the setCustomSubClaimForRepo method.
     *
     * @return  void
     */
    public function testSetCustomSubClaimForRepo()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"include_claim_keys":[1,2],"use_default":true}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/oidc/customization/sub', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->setCustomSubClaimForRepo('joomla', 'joomla-platform', true, ['include_claim_keys' => [1, 2]]));
    }

    /**
     * Tests the setCustomSubClaimForRepo method.
     *
     * @return  void
     */
    public function testSetCustomSubClaimForRepoDefaults()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"use_default":true}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/oidc/customization/sub', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->setCustomSubClaimForRepo('joomla', 'joomla-platform', true));
    }

    /**
     * Tests the setCustomSubClaimForRepo method.
     *
     * @return  void
     */
    public function testSetCustomSubClaimForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setCustomSubClaimForRepo('joomla', 'joomla-platform', true, ['include_claim_keys' => [1, 2]]);
    }
}
