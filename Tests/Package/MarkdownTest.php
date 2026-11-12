<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Markdown;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for Markdown.
 *
 * @since  1.0
 */
class MarkdownTest extends GitHubTestCase
{
    /**
     * @var Markdown
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Markdown($this->options, $this->client);
    }

    /**
     * Tests the render method
     *
     * @return  void
     */
    public function testRender()
    {
        $body = '<p>Hello world <a href="http://github.com/github/linguist/issues/1" '
            . 'class="issue-link" title="This is a simple issue">github/linguist#1</a> <strong>cool</strong>, '
            . 'and <a href="http://github.com/github/gollum/issues/1" class="issue-link" '
            . 'title="This is another issue">#1</a>!</p>';
        $this->response = $this->getResponseObject($body);

        $text    = 'Hello world github/linguist#1 **cool**, and #1!';
        $mode    = 'gfm';
        $context = 'github/gollum';

        $data = str_replace(
            '\\/',
            '/',
            json_encode(
                [
                    'text'    => $text,
                    'mode'    => $mode,
                    'context' => $context,
                ]
            )
        );

        $this->client->expects($this->once())
            ->method('post')
            ->with('/markdown', $data, [], 0)
            ->willReturn($this->response);

        $response = (string) $this->response->getBody();

        $this->assertEquals(
            $response,
            $this->object->render($text, $mode, $context)
        );
    }

    /**
     * Tests the renderInvalidMode method
     *
     * @return  void
     */
    public function testRenderInvalidMode()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->assertThat(
            $this->object->render('', 'xxx', 'github/gollum'),
            $this->equalTo('')
        );
    }

    /**
     * Tests the renderFailure method
     *
     * @return  void
     */
    public function testRenderFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response = $this->getResponseObject('', 404);

        $text    = 'Hello world github/linguist#1 **cool**, and #1!';
        $mode    = 'gfm';
        $context = 'github/gollum';

        $data = str_replace(
            '\\/',
            '/',
            json_encode(
                [
                    'text'    => $text,
                    'mode'    => $mode,
                    'context' => $context,
                ]
            )
        );

        $this->client->expects($this->once())
            ->method('post')
            ->with('/markdown', $data, [], 0)
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->render($text, $mode, $context),
            $this->equalTo('')
        );
    }
}
