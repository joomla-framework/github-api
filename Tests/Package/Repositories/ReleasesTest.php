<?php
/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Repositories\Releases;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Response;

/**
 * Test class for the GitHub API package.
 *
 * @since  1.0
 */
class ReleasesTest extends GitHubTestCase
{
    /**
     * @var    Releases  Object under test.
     * @since  1.0
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @since   1.0
     *
     * @return  void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Releases($this->options, $this->client);
    }

    /**
     * Tests the get method
     *
     * @return  void
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/releases/12345', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->get('joomla', 'joomla-platform', '12345')
        );
    }

    /**
     * Tests the create method
     *
     * @return  void
     */
    public function testCreate()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $data = '{"tag_name":"0.1","target_commitish":"targetCommitish","name":"master","body":"New release","draft":false,"prerelease":false}';
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/releases', $data, [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->create('joomla', 'joomla-platform', '0.1', 'targetCommitish', 'master', 'New release', false, false)
        );
    }

    /**
     * Tests the create method with failure.
     *
     * @return  void
     */
    public function testCreateFailure()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $data = '{"tag_name":"0.1","target_commitish":"targetCommitish","name":"master","body":"New release","draft":false,"prerelease":false}';
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/releases', $data, [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->create('joomla', 'joomla-platform', '0.1', 'targetCommitish', 'master', 'New release', false, false)
        );
    }

    /**
     * Tests the edit method.
     *
     * @return  void
     */
    public function testEdit()
    {
        $releaseId = 123;

        $data = '{"tag_name":"tagName","target_commitish":"targetCommitish","name":"name","body":"body","draft":"draft","prerelease":"preRelease"}';
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/releases/' . $releaseId, $data, [], 0)

            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->edit('joomla', 'joomla-platform', $releaseId, 'tagName', 'targetCommitish', 'name', 'body', 'draft', 'preRelease')
        );
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     */
    public function testGetList()
    {
        $this->response = $this->getResponseObject('[{"tag_name":"1"},{"tag_name":"2"}]', 200);

        $releases = [];

        foreach (json_decode($this->response->getBody()->getContents()) as $i => $release) {
            $releases[$i + 1] = $release;
        }

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/releases', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $releases,
            $this->object->getList('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the delete method
     *
     * @return  void
     */
    public function testDelete()
    {
        $this->response = $this->getResponseObject($this->sampleString, 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/releases/123')
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->delete('joomla', 'joomla-platform', '123')
        );
    }

    /**
     * Tests the getLatest method.
     *
     * @return  void
     */
    public function testGetLatest()
    {
        $this->response = $this->getResponseObject('[]');

        $releases = [];

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/releases/latest', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getLatest('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the getByTag method
     *
     * @return  void
     */
    public function testGetByTag()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/releases/tags/{tag}', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getByTag('joomla', 'joomla-platform', '{tag}')
        );
    }

    /**
     * Tests the getListAssets method
     *
     * @return  void
     */
    public function testGetListAssets()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/releases/123/assets', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getListAssets('joomla', 'joomla-platform', 123)
        );
    }

    /**
     * Tests the getAsset method
     *
     * @return  void
     */
    public function testGetAsset()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/releases/assets/123', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getAsset('joomla', 'joomla-platform', 123)
        );
    }

    /**
     * Tests the editAsset method
     *
     * @return  void
     */
    public function testEditAsset()
    {
        $data = '{"name":"{name}","label":"{label}"}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/releases/assets/123', $data, [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->editAsset('joomla', 'joomla-platform', 123, '{name}', '{label}')
        );
    }

    /**
     * Tests the deleteAsset method
     *
     * @return  void
     */
    public function testDeleteAsset()
    {
        $this->response = new Response('data://text/plain,true', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/releases/assets/123', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            'true',
            $this->object->deleteAsset('joomla', 'joomla-platform', 123)
        );
    }
}
