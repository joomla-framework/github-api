<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\DependencyGraph;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for DependencyGraph.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(DependencyGraph::class)]
class DependencyGraphTest extends GitHubTestCase
{
    /**
     * @var    DependencyGraph  Object under test.
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

        $this->object = new DependencyGraph($this->options, $this->client);
    }

    /**
     * Tests the compare method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCompare()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/dependency-graph/compare/main...feature%2Fx?name=composer.json', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->compare('joomla', 'joomla-platform', 'main', 'feature/x', ['name' => 'composer.json'])
        );
    }

    /**
     * Tests the compare method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCompareFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/dependency-graph/compare/main...feature%2Fx', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->compare('joomla', 'joomla-platform', 'main', 'feature/x');
    }

    /**
     * Tests the createSnapshot method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCreateSnapshot()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/dependency-graph/snapshots', json_encode(['manifests' => ['composer.lock' => ['name' => 'composer.lock']], 'version' => 0, 'job' => ['correlator' => 'build', 'id' => '42'], 'sha' => 'ddc951f4b1293222421f2c8df679786153acf689', 'ref' => 'refs/heads/main', 'detector' => ['name' => 'composer-detector', 'version' => '1.0.0', 'url' => 'https://example.com'], 'scanned' => '2026-11-12T10:00:00Z']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createSnapshot('joomla', 'joomla-platform', 0, ['correlator' => 'build', 'id' => '42'], 'ddc951f4b1293222421f2c8df679786153acf689', 'refs/heads/main', ['name' => 'composer-detector', 'version' => '1.0.0', 'url' => 'https://example.com'], '2026-11-12T10:00:00Z', ['manifests' => ['composer.lock' => ['name' => 'composer.lock']]])
        );
    }

    /**
     * Tests the createSnapshot method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCreateSnapshotFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/dependency-graph/snapshots', json_encode(['version' => 0, 'job' => ['correlator' => 'build', 'id' => '42'], 'sha' => 'ddc951f4b1293222421f2c8df679786153acf689', 'ref' => 'refs/heads/main', 'detector' => ['name' => 'composer-detector', 'version' => '1.0.0', 'url' => 'https://example.com'], 'scanned' => '2026-11-12T10:00:00Z']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->createSnapshot('joomla', 'joomla-platform', 0, ['correlator' => 'build', 'id' => '42'], 'ddc951f4b1293222421f2c8df679786153acf689', 'refs/heads/main', ['name' => 'composer-detector', 'version' => '1.0.0', 'url' => 'https://example.com'], '2026-11-12T10:00:00Z');
    }

    /**
     * Tests the generateSbomReport method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGenerateSbomReport()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/dependency-graph/sbom/generate-report', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->generateSbomReport('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the generateSbomReport method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGenerateSbomReportFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/dependency-graph/sbom/generate-report', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->generateSbomReport('joomla', 'joomla-platform');
    }

    /**
     * Tests the fetchSbomReport method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testFetchSbomReport()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/dependency-graph/sbom/fetch-report/a1b2c3d4', [], 0)
            ->willReturn($this->getResponseObject('', 302, ['Location' => 'https://example.com/download']));

        $this->assertSame('https://example.com/download', $this->object->fetchSbomReport('joomla', 'joomla-platform', 'a1b2c3d4'));
    }

    /**
     * Tests the fetchSbomReport method while the report is still being generated.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testFetchSbomReportPending()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/dependency-graph/sbom/fetch-report/a1b2c3d4', [], 0)
            ->willReturn($this->getResponseObject('', 202));

        $this->assertSame('', $this->object->fetchSbomReport('joomla', 'joomla-platform', 'a1b2c3d4'));
    }

    /**
     * Tests the fetchSbomReport method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testFetchSbomReportFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/dependency-graph/sbom/fetch-report/a1b2c3d4', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->fetchSbomReport('joomla', 'joomla-platform', 'a1b2c3d4');
    }
}
