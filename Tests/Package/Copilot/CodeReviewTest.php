<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Copilot;

use Joomla\Github\Package\Copilot\CodeReview;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Copilot\CodeReview.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(CodeReview::class)]
class CodeReviewTest extends GitHubTestCase
{
    /**
     * @var    CodeReview  Object under test.
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

        $this->object = new CodeReview($this->options, $this->client);
    }

    /**
     * Tests the getRunnerForOrg method.
     *
     * @return  void
     */
    public function testGetRunnerForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/code-review/runner', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getRunnerForOrg('joomla')
        );
    }

    /**
     * Tests the getRunnerForOrg method.
     *
     * @return  void
     */
    public function testGetRunnerForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/code-review/runner', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getRunnerForOrg('joomla');
    }

    /**
     * Tests the setRunnerForOrg method.
     *
     * @return  void
     */
    public function testSetRunnerForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/copilot/code-review/runner', json_encode(['runner_labels' => 'value', 'runner_type' => 'github_hosted']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->setRunnerForOrg('joomla', 'github_hosted', ['runner_labels' => 'value'])
        );
    }

    /**
     * Tests the setRunnerForOrg method.
     *
     * @return  void
     */
    public function testSetRunnerForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/copilot/code-review/runner', json_encode(['runner_labels' => 'value', 'runner_type' => 'github_hosted']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->setRunnerForOrg('joomla', 'github_hosted', ['runner_labels' => 'value']);
    }

    /**
     * Tests the getSettingsForOrg method.
     *
     * @return  void
     */
    public function testGetSettingsForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/code-review/settings', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getSettingsForOrg('joomla')
        );
    }

    /**
     * Tests the getSettingsForOrg method.
     *
     * @return  void
     */
    public function testGetSettingsForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/code-review/settings', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getSettingsForOrg('joomla');
    }

    /**
     * Tests the editSettingsForOrg method.
     *
     * @return  void
     */
    public function testEditSettingsForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/copilot/code-review/settings', json_encode(['default_review_effort' => 'value']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->editSettingsForOrg('joomla', ['default_review_effort' => 'value'])
        );
    }

    /**
     * Tests the editSettingsForOrg method.
     *
     * @return  void
     */
    public function testEditSettingsForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/copilot/code-review/settings', json_encode(['default_review_effort' => 'value']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->editSettingsForOrg('joomla', ['default_review_effort' => 'value']);
    }

    /**
     * Tests the getPolicyForOrg method.
     *
     * @return  void
     */
    public function testGetPolicyForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/policies/code-review', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getPolicyForOrg('joomla')
        );
    }

    /**
     * Tests the getPolicyForOrg method.
     *
     * @return  void
     */
    public function testGetPolicyForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/copilot/policies/code-review', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getPolicyForOrg('joomla');
    }

    /**
     * Tests the setPolicyForOrg method.
     *
     * @return  void
     */
    public function testSetPolicyForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/copilot/policies/code-review', json_encode(['state' => 'enabled']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 204));

        $this->assertNull($this->object->setPolicyForOrg('joomla', 'enabled'));
    }

    /**
     * Tests the setPolicyForOrg method.
     *
     * @return  void
     */
    public function testSetPolicyForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/copilot/policies/code-review', json_encode(['state' => 'enabled']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->setPolicyForOrg('joomla', 'enabled');
    }

    /**
     * Tests the getSettingsForRepo method.
     *
     * @return  void
     */
    public function testGetSettingsForRepo(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/copilot/code-review/settings', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getSettingsForRepo('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the getSettingsForRepo method.
     *
     * @return  void
     */
    public function testGetSettingsForRepoFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/copilot/code-review/settings', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getSettingsForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the editSettingsForRepo method.
     *
     * @return  void
     */
    public function testEditSettingsForRepo(): void
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/copilot/code-review/settings', json_encode(['review_effort' => 'value']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->editSettingsForRepo('joomla', 'joomla-platform', ['review_effort' => 'value'])
        );
    }

    /**
     * Tests the editSettingsForRepo method.
     *
     * @return  void
     */
    public function testEditSettingsForRepoFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/copilot/code-review/settings', json_encode(['review_effort' => 'value']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->editSettingsForRepo('joomla', 'joomla-platform', ['review_effort' => 'value']);
    }
}
