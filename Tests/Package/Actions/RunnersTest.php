<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Actions;

use Joomla\Github\Package\Actions\Runners;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for the GitHub API package.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Runners::class)]
class RunnersTest extends GitHubTestCase
{
    /**
     * @var    Runners  Object under test.
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

        $this->object = new Runners($this->options, $this->client);
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
            ->with('/orgs/joomla/actions/runners?page=2&per_page=30&name=name-value', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForOrg('joomla', ['name' => 'name-value'], 2, 30));
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
            ->with('/orgs/joomla/actions/runners', [], 0)
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

        $this->object->getListForOrg('joomla', ['name' => 'name-value'], 2, 30);
    }

    /**
     * Tests the getVersionDeprecationForOrg method.
     *
     * @return  void
     */
    public function testGetVersionDeprecationForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/runners/deprecations/2.1.0', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getVersionDeprecationForOrg('joomla', '2.1.0'));
    }

    /**
     * Tests the getVersionDeprecationForOrg method.
     *
     * @return  void
     */
    public function testGetVersionDeprecationForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getVersionDeprecationForOrg('joomla', '2.1.0');
    }

    /**
     * Tests the getListApplicationsForOrg method.
     *
     * @return  void
     */
    public function testGetListApplicationsForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/runners/downloads', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListApplicationsForOrg('joomla'));
    }

    /**
     * Tests the getListApplicationsForOrg method.
     *
     * @return  void
     */
    public function testGetListApplicationsForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListApplicationsForOrg('joomla');
    }

    /**
     * Tests the generateJitConfigForOrg method.
     *
     * @return  void
     */
    public function testGenerateJitConfigForOrg()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"work_folder":"work-folder","name":"name","runner_group_id":11,"labels":[1,2]}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/actions/runners/generate-jitconfig', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->generateJitConfigForOrg('joomla', 'name', 11, [1, 2], ['work_folder' => 'work-folder']));
    }

    /**
     * Tests the generateJitConfigForOrg method.
     *
     * @return  void
     */
    public function testGenerateJitConfigForOrgDefaults()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"name":"name","runner_group_id":11,"labels":[1,2]}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/actions/runners/generate-jitconfig', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->generateJitConfigForOrg('joomla', 'name', 11, [1, 2]));
    }

    /**
     * Tests the generateJitConfigForOrg method.
     *
     * @return  void
     */
    public function testGenerateJitConfigForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->generateJitConfigForOrg('joomla', 'name', 11, [1, 2], ['work_folder' => 'work-folder']);
    }

    /**
     * Tests the createRegistrationTokenForOrg method.
     *
     * @return  void
     */
    public function testCreateRegistrationTokenForOrg()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/actions/runners/registration-token', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createRegistrationTokenForOrg('joomla'));
    }

    /**
     * Tests the createRegistrationTokenForOrg method.
     *
     * @return  void
     */
    public function testCreateRegistrationTokenForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->createRegistrationTokenForOrg('joomla');
    }

    /**
     * Tests the createRemoveTokenForOrg method.
     *
     * @return  void
     */
    public function testCreateRemoveTokenForOrg()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/actions/runners/remove-token', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createRemoveTokenForOrg('joomla'));
    }

    /**
     * Tests the createRemoveTokenForOrg method.
     *
     * @return  void
     */
    public function testCreateRemoveTokenForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->createRemoveTokenForOrg('joomla');
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
            ->with('/orgs/joomla/actions/runners/1', [], 0)
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
     * Tests the deleteForOrg method.
     *
     * @return  void
     */
    public function testDeleteForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/actions/runners/1', [], 0)
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
     * Tests the getListLabelsForOrg method.
     *
     * @return  void
     */
    public function testGetListLabelsForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/runners/1/labels', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListLabelsForOrg('joomla', 1));
    }

    /**
     * Tests the getListLabelsForOrg method.
     *
     * @return  void
     */
    public function testGetListLabelsForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListLabelsForOrg('joomla', 1);
    }

    /**
     * Tests the addLabelsForOrg method.
     *
     * @return  void
     */
    public function testAddLabelsForOrg()
    {
        $body = '{"labels":[1,2]}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/actions/runners/1/labels', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->addLabelsForOrg('joomla', 1, [1, 2]));
    }

    /**
     * Tests the addLabelsForOrg method.
     *
     * @return  void
     */
    public function testAddLabelsForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->addLabelsForOrg('joomla', 1, [1, 2]);
    }

    /**
     * Tests the setLabelsForOrg method.
     *
     * @return  void
     */
    public function testSetLabelsForOrg()
    {
        $body = '{"labels":[1,2]}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/runners/1/labels', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->setLabelsForOrg('joomla', 1, [1, 2]));
    }

    /**
     * Tests the setLabelsForOrg method.
     *
     * @return  void
     */
    public function testSetLabelsForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setLabelsForOrg('joomla', 1, [1, 2]);
    }

    /**
     * Tests the removeAllLabelsForOrg method.
     *
     * @return  void
     */
    public function testRemoveAllLabelsForOrg()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/actions/runners/1/labels', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->removeAllLabelsForOrg('joomla', 1));
    }

    /**
     * Tests the removeAllLabelsForOrg method.
     *
     * @return  void
     */
    public function testRemoveAllLabelsForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->removeAllLabelsForOrg('joomla', 1);
    }

    /**
     * Tests the removeLabelForOrg method.
     *
     * @return  void
     */
    public function testRemoveLabelForOrg()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/actions/runners/1/labels/my%20name', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->removeLabelForOrg('joomla', 1, 'my name'));
    }

    /**
     * Tests the removeLabelForOrg method.
     *
     * @return  void
     */
    public function testRemoveLabelForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->removeLabelForOrg('joomla', 1, 'my name');
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
            ->with('/repos/joomla/joomla-platform/actions/runners?page=2&per_page=30&name=name-value', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForRepo('joomla', 'joomla-platform', ['name' => 'name-value'], 2, 30));
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
            ->with('/repos/joomla/joomla-platform/actions/runners', [], 0)
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

        $this->object->getListForRepo('joomla', 'joomla-platform', ['name' => 'name-value'], 2, 30);
    }

    /**
     * Tests the getVersionDeprecationForRepo method.
     *
     * @return  void
     */
    public function testGetVersionDeprecationForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runners/deprecations/2.1.0', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getVersionDeprecationForRepo('joomla', 'joomla-platform', '2.1.0'));
    }

    /**
     * Tests the getVersionDeprecationForRepo method.
     *
     * @return  void
     */
    public function testGetVersionDeprecationForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getVersionDeprecationForRepo('joomla', 'joomla-platform', '2.1.0');
    }

    /**
     * Tests the getListApplicationsForRepo method.
     *
     * @return  void
     */
    public function testGetListApplicationsForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runners/downloads', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListApplicationsForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getListApplicationsForRepo method.
     *
     * @return  void
     */
    public function testGetListApplicationsForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListApplicationsForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the generateJitConfigForRepo method.
     *
     * @return  void
     */
    public function testGenerateJitConfigForRepo()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"work_folder":"work-folder","name":"name","runner_group_id":11,"labels":[1,2]}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/runners/generate-jitconfig', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->generateJitConfigForRepo('joomla', 'joomla-platform', 'name', 11, [1, 2], ['work_folder' => 'work-folder']));
    }

    /**
     * Tests the generateJitConfigForRepo method.
     *
     * @return  void
     */
    public function testGenerateJitConfigForRepoDefaults()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"name":"name","runner_group_id":11,"labels":[1,2]}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/runners/generate-jitconfig', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->generateJitConfigForRepo('joomla', 'joomla-platform', 'name', 11, [1, 2]));
    }

    /**
     * Tests the generateJitConfigForRepo method.
     *
     * @return  void
     */
    public function testGenerateJitConfigForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->generateJitConfigForRepo('joomla', 'joomla-platform', 'name', 11, [1, 2], ['work_folder' => 'work-folder']);
    }

    /**
     * Tests the createRegistrationTokenForRepo method.
     *
     * @return  void
     */
    public function testCreateRegistrationTokenForRepo()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/runners/registration-token', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createRegistrationTokenForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the createRegistrationTokenForRepo method.
     *
     * @return  void
     */
    public function testCreateRegistrationTokenForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->createRegistrationTokenForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the createRemoveTokenForRepo method.
     *
     * @return  void
     */
    public function testCreateRemoveTokenForRepo()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/runners/remove-token', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createRemoveTokenForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the createRemoveTokenForRepo method.
     *
     * @return  void
     */
    public function testCreateRemoveTokenForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->createRemoveTokenForRepo('joomla', 'joomla-platform');
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
            ->with('/repos/joomla/joomla-platform/actions/runners/1', [], 0)
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
     * Tests the deleteForRepo method.
     *
     * @return  void
     */
    public function testDeleteForRepo()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/actions/runners/1', [], 0)
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

    /**
     * Tests the getListLabelsForRepo method.
     *
     * @return  void
     */
    public function testGetListLabelsForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runners/1/labels', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListLabelsForRepo('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the getListLabelsForRepo method.
     *
     * @return  void
     */
    public function testGetListLabelsForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListLabelsForRepo('joomla', 'joomla-platform', 1);
    }

    /**
     * Tests the addLabelsForRepo method.
     *
     * @return  void
     */
    public function testAddLabelsForRepo()
    {
        $body = '{"labels":[1,2]}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/runners/1/labels', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->addLabelsForRepo('joomla', 'joomla-platform', 1, [1, 2]));
    }

    /**
     * Tests the addLabelsForRepo method.
     *
     * @return  void
     */
    public function testAddLabelsForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->addLabelsForRepo('joomla', 'joomla-platform', 1, [1, 2]);
    }

    /**
     * Tests the setLabelsForRepo method.
     *
     * @return  void
     */
    public function testSetLabelsForRepo()
    {
        $body = '{"labels":[1,2]}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/runners/1/labels', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->setLabelsForRepo('joomla', 'joomla-platform', 1, [1, 2]));
    }

    /**
     * Tests the setLabelsForRepo method.
     *
     * @return  void
     */
    public function testSetLabelsForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setLabelsForRepo('joomla', 'joomla-platform', 1, [1, 2]);
    }

    /**
     * Tests the removeAllLabelsForRepo method.
     *
     * @return  void
     */
    public function testRemoveAllLabelsForRepo()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/actions/runners/1/labels', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->removeAllLabelsForRepo('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the removeAllLabelsForRepo method.
     *
     * @return  void
     */
    public function testRemoveAllLabelsForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->removeAllLabelsForRepo('joomla', 'joomla-platform', 1);
    }

    /**
     * Tests the removeLabelForRepo method.
     *
     * @return  void
     */
    public function testRemoveLabelForRepo()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/actions/runners/1/labels/my%20name', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->removeLabelForRepo('joomla', 'joomla-platform', 1, 'my name'));
    }

    /**
     * Tests the removeLabelForRepo method.
     *
     * @return  void
     */
    public function testRemoveLabelForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->removeLabelForRepo('joomla', 'joomla-platform', 1, 'my name');
    }
}
