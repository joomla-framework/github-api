<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Github\Tests\Stub\ObjectMock;

/**
 * Test class for Joomla\Github\Object.
 *
 * @since  1.0
 */
class GithubObjectTest extends GitHubTestCase
{
    /**
     * @var    ObjectMock  Object under test.
     * @since  1.0
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return  void
     *
     * @since   1.0
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new ObjectMock($this->options, $this->client);
    }

    /**
     * Data provider method for the fetchUrl method tests.
     *
     * @return  array
     *
     * @since   1.0
     */
    public function fetchUrlData()
    {
        return [
            'Standard github - no pagination data' => [
                'https://api.github.com',
                '/gists',
                0,
                0,
                'https://api.github.com/gists',
            ],
            'Enterprise github - no pagination data' => [
                'https://mygithub.com',
                '/gists',
                0,
                0,
                'https://mygithub.com/gists',
            ],
            'Standard github - page 3' => [
                'https://api.github.com',
                '/gists',
                3,
                0,
                'https://api.github.com/gists?page=3',
            ],
            'Enterprise github - page 3, 50 per page' => [
                'https://mygithub.com',
                '/gists',
                3,
                50,
                'https://mygithub.com/gists?page=3&per_page=50',
            ],
        ];
    }

    /**
     * Tests the fetchUrl method
     *
     * @param   string   $apiUrl    @todo
     * @param   string   $path      @todo
     * @param   integer  $page      @todo
     * @param   integer  $limit     @todo
     * @param   string   $expected  @todo
     *
     * @return  void
     *
     * @since        1.0
     * @dataProvider fetchUrlData
     */
    public function testFetchUrl($apiUrl, $path, $page, $limit, $expected)
    {
        $this->options->set('api.url', $apiUrl);

        $this->assertThat(
            $this->object->fetchUrl($path, $page, $limit),
            $this->equalTo($expected)
        );
    }

    /**
     * Tests the fetchUrl method with basic authentication data
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testFetchUrlBasicAuth()
    {
        $this->options->set('api.url', 'https://api.github.com');

        $this->options->set('api.username', 'MyTestUser');
        $this->options->set('api.password', 'MyTestPass');

        $this->assertThat(
            $this->object->fetchUrl('/gists', 0, 0),
            $this->equalTo('https://MyTestUser:MyTestPass@api.github.com/gists'),
            'URL is not as expected.'
        );
    }

    /**
     * Tests the fetchUrl method using an oAuth token.
     *
     * @return void
     */
    public function testFetchUrlToken()
    {
        $this->options->set('api.url', 'https://api.github.com');

        $this->options->set('gh.token', 'MyTestToken');

        $this->assertThat(
            (string) $this->object->fetchUrl('/gists', 0, 0),
            $this->equalTo('https://api.github.com/gists'),
            'URL is not as expected.'
        );

        $this->assertThat(
            $this->client->getOption('headers'),
            $this->equalTo(['Authorization' => 'token MyTestToken']),
            'Token should be propagated as a header.'
        );
    }
}
