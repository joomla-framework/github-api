<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Actions;

use Joomla\Github\Package\Actions\HostedRunners;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for the GitHub API package.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(HostedRunners::class)]
class HostedRunnersTest extends GitHubTestCase
{
    /**
     * @var    HostedRunners  Object under test.
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

        $this->object = new HostedRunners($this->options, $this->client);
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/hosted-runners?page=2&per_page=30', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getList('joomla', 2, 30));
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     */
    public function testGetListDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/hosted-runners', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getList('joomla'));
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     */
    public function testGetListFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getList('joomla', 2, 30);
    }

    /**
     * Tests the create method.
     *
     * @return  void
     */
    public function testCreate()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"maximum_runners":7,"name":"name","image":{"id":"ubuntu-latest","source":"github"},"size":"size","runner_group_id":13}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/actions/hosted-runners', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->create('joomla', 'name', ['id' => 'ubuntu-latest', 'source' => 'github'], 'size', 13, ['maximum_runners' => 7]));
    }

    /**
     * Tests the create method.
     *
     * @return  void
     */
    public function testCreateDefaults()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"name":"name","image":{"id":"ubuntu-latest","source":"github"},"size":"size","runner_group_id":13}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/actions/hosted-runners', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->create('joomla', 'name', ['id' => 'ubuntu-latest', 'source' => 'github'], 'size', 13));
    }

    /**
     * Tests the create method.
     *
     * @return  void
     */
    public function testCreateFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->create('joomla', 'name', ['id' => 'ubuntu-latest', 'source' => 'github'], 'size', 13, ['maximum_runners' => 7]);
    }

    /**
     * Tests the get method.
     *
     * @return  void
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/hosted-runners/1', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->get('joomla', 1));
    }

    /**
     * Tests the get method.
     *
     * @return  void
     */
    public function testGetFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->get('joomla', 1);
    }

    /**
     * Tests the edit method.
     *
     * @return  void
     */
    public function testEdit()
    {
        $body = '{"name":"name"}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/actions/hosted-runners/1', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->edit('joomla', 1, ['name' => 'name']));
    }

    /**
     * Tests the edit method.
     *
     * @return  void
     */
    public function testEditDefaults()
    {
        $body = '{}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/actions/hosted-runners/1', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->edit('joomla', 1));
    }

    /**
     * Tests the edit method.
     *
     * @return  void
     */
    public function testEditFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('patch')
            ->willReturn($this->response);

        $this->object->edit('joomla', 1, ['name' => 'name']);
    }

    /**
     * Tests the delete method.
     *
     * @return  void
     */
    public function testDelete()
    {
        $this->response = $this->getResponseObject($this->sampleString, 202);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/actions/hosted-runners/1', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->delete('joomla', 1));
    }

    /**
     * Tests the delete method.
     *
     * @return  void
     */
    public function testDeleteFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->delete('joomla', 1);
    }

    /**
     * Tests the getListCustomImages method.
     *
     * @return  void
     */
    public function testGetListCustomImages()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/hosted-runners/images/custom', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListCustomImages('joomla'));
    }

    /**
     * Tests the getListCustomImages method.
     *
     * @return  void
     */
    public function testGetListCustomImagesFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListCustomImages('joomla');
    }

    /**
     * Tests the getCustomImage method.
     *
     * @return  void
     */
    public function testGetCustomImage()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/hosted-runners/images/custom/1', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getCustomImage('joomla', 1));
    }

    /**
     * Tests the getCustomImage method.
     *
     * @return  void
     */
    public function testGetCustomImageFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getCustomImage('joomla', 1);
    }

    /**
     * Tests the deleteCustomImage method.
     *
     * @return  void
     */
    public function testDeleteCustomImage()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/actions/hosted-runners/images/custom/1', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->deleteCustomImage('joomla', 1));
    }

    /**
     * Tests the deleteCustomImage method.
     *
     * @return  void
     */
    public function testDeleteCustomImageFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->deleteCustomImage('joomla', 1);
    }

    /**
     * Tests the getListCustomImageVersions method.
     *
     * @return  void
     */
    public function testGetListCustomImageVersions()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/hosted-runners/images/custom/1/versions', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListCustomImageVersions('joomla', 1));
    }

    /**
     * Tests the getListCustomImageVersions method.
     *
     * @return  void
     */
    public function testGetListCustomImageVersionsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListCustomImageVersions('joomla', 1);
    }

    /**
     * Tests the getCustomImageVersion method.
     *
     * @return  void
     */
    public function testGetCustomImageVersion()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/hosted-runners/images/custom/1/versions/2.1.0', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getCustomImageVersion('joomla', 1, '2.1.0'));
    }

    /**
     * Tests the getCustomImageVersion method.
     *
     * @return  void
     */
    public function testGetCustomImageVersionFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getCustomImageVersion('joomla', 1, '2.1.0');
    }

    /**
     * Tests the deleteCustomImageVersion method.
     *
     * @return  void
     */
    public function testDeleteCustomImageVersion()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/actions/hosted-runners/images/custom/1/versions/2.1.0', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->deleteCustomImageVersion('joomla', 1, '2.1.0'));
    }

    /**
     * Tests the deleteCustomImageVersion method.
     *
     * @return  void
     */
    public function testDeleteCustomImageVersionFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->deleteCustomImageVersion('joomla', 1, '2.1.0');
    }

    /**
     * Tests the getGithubOwnedImages method.
     *
     * @return  void
     */
    public function testGetGithubOwnedImages()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/hosted-runners/images/github-owned', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getGithubOwnedImages('joomla'));
    }

    /**
     * Tests the getGithubOwnedImages method.
     *
     * @return  void
     */
    public function testGetGithubOwnedImagesFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getGithubOwnedImages('joomla');
    }

    /**
     * Tests the getPartnerImages method.
     *
     * @return  void
     */
    public function testGetPartnerImages()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/hosted-runners/images/partner', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getPartnerImages('joomla'));
    }

    /**
     * Tests the getPartnerImages method.
     *
     * @return  void
     */
    public function testGetPartnerImagesFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getPartnerImages('joomla');
    }

    /**
     * Tests the getLimits method.
     *
     * @return  void
     */
    public function testGetLimits()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/hosted-runners/limits', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getLimits('joomla'));
    }

    /**
     * Tests the getLimits method.
     *
     * @return  void
     */
    public function testGetLimitsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getLimits('joomla');
    }

    /**
     * Tests the getMachineSizes method.
     *
     * @return  void
     */
    public function testGetMachineSizes()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/hosted-runners/machine-sizes', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getMachineSizes('joomla'));
    }

    /**
     * Tests the getMachineSizes method.
     *
     * @return  void
     */
    public function testGetMachineSizesFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getMachineSizes('joomla');
    }

    /**
     * Tests the getPlatforms method.
     *
     * @return  void
     */
    public function testGetPlatforms()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/hosted-runners/platforms', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getPlatforms('joomla'));
    }

    /**
     * Tests the getPlatforms method.
     *
     * @return  void
     */
    public function testGetPlatformsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getPlatforms('joomla');
    }
}
