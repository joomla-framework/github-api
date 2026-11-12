<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Gists;

use Joomla\Github\Package\Gists\Comments;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use PHPUnit\Framework\Attributes\IgnoreDeprecations;

/**
 * Tests the routes of the gist comment methods.
 */
class CommentsTest extends GitHubTestCase
{
    /**
     * @var  Comments
     */
    protected $object;

    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Comments($this->options, $this->client);
    }

    public function testGetWithGistId()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/gists/aa5a315d61ae9438b18d/comments/523')
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->get(523, 'aa5a315d61ae9438b18d'));
    }

    public function testEditWithGistId()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/gists/aa5a315d61ae9438b18d/comments/523', '{"body":"Updated"}')
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->edit(523, 'Updated', 'aa5a315d61ae9438b18d'));
    }

    public function testDeleteWithGistId()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/gists/aa5a315d61ae9438b18d/comments/523')
            ->willReturn($this->getResponseObject('', 204));

        $this->object->delete(523, 'aa5a315d61ae9438b18d');
    }

    #[IgnoreDeprecations]
    public function testWithoutGistIdIsDeprecated()
    {
        $this->expectUserDeprecationMessageMatches('/Calling .*Comments::get\(\) without the gist ID is deprecated/');

        $this->client->expects($this->once())
            ->method('get')
            ->with('/gists/comments/523')
            ->willReturn($this->response);

        $this->object->get(523);
    }
}
