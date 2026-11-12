<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\Data\Refs;
use Joomla\Github\Package\Issues\Labels;
use Joomla\Github\Package\Pulls;
use Joomla\Github\Package\Repositories\Branches;
use Joomla\Github\Package\Repositories\Commits;
use Joomla\Github\Package\Repositories\Contents;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Tests that values with reserved characters are percent-encoded in the request path and query.
 */
class EncodingTest extends GitHubTestCase
{
    public function testContentsPathAndRef()
    {
        $this->expectGet('/repos/joomla/joomla-cms/contents/docs/a%20b%26c%3Dd%23e.md?ref=feature%2Fx%26raw%3D1');

        (new Contents($this->options, $this->client))->get('joomla', 'joomla-cms', 'docs/a b&c=d#e.md', 'feature/x&raw=1');
    }

    public function testCommitListQueryValues()
    {
        $this->expectGet('/repos/joomla/joomla-cms/commits?sha=feature%2Fx%23y&path=src%2Fa%20b.php&author=a%26b');

        (new Commits($this->options, $this->client))->getList('joomla', 'joomla-cms', 'feature/x#y', 'src/a b.php', 'a&b');
    }

    public function testDateIsEncoded()
    {
        $this->expectGet('/repos/joomla/joomla-cms/commits?since=2026-11-12T10%3A00%3A00%2B01%3A00');

        (new Commits($this->options, $this->client))->getList('joomla', 'joomla-cms', since: new \DateTime('2026-11-12T10:00:00+01:00'));
    }

    public function testBranchName()
    {
        $this->expectGet('/repos/joomla/joomla-cms/branches/feature/fix%231');

        (new Branches($this->options, $this->client))->get('joomla', 'joomla-cms', 'feature/fix#1');
    }

    public function testRef()
    {
        $this->expectGet('/repos/joomla/joomla-cms/git/refs/heads/a%3Fb');

        (new Refs($this->options, $this->client))->get('joomla', 'joomla-cms', 'heads/a?b');
    }

    public function testLabelUpdate()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-cms/labels/needs%2Ftests')
            ->willReturn($this->response);

        (new Labels($this->options, $this->client))->update('joomla', 'joomla-cms', 'needs/tests', 'needs tests', 'ff0000');
    }

    public function testPullsStateWithPaging()
    {
        $this->expectGet('/repos/joomla/joomla-cms/pulls?page=2&state=closed%26x%3D1');

        (new Pulls($this->options, $this->client))->getList('joomla', 'joomla-cms', 'closed&x=1', 2);
    }

    private function expectGet(string $url): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with($url)
            ->willReturn($this->response);
    }
}
