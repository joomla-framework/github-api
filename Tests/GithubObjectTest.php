<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Github;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Github\Tests\Stub\ObjectMock;
use Joomla\Github\Tests\Stub\RecordingTransport;
use Joomla\Http\Http;
use Joomla\Registry\Registry;
use PHPUnit\Framework\Attributes\DataProvider;

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
    public static function fetchUrlData(): array
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
     */
    #[DataProvider('fetchUrlData')]
    public function testFetchUrl($apiUrl, $path, $page, $limit, $expected)
    {
        $this->options->set('api.url', $apiUrl);

        $this->assertThat(
            $this->object->fetchUrl($path, $page, $limit),
            $this->equalTo($expected)
        );
    }

    /**
     * Tests that fetchUrl() does not put Basic auth credentials into the URL
     *
     * @return  void
     */
    public function testFetchUrlBasicAuth()
    {
        $this->options->set('api.url', 'https://api.github.com');

        $this->options->set('api.username', 'MyTestUser');
        $this->options->set('api.password', 'MyTestPass');

        $this->assertThat(
            (string) $this->object->fetchUrl('/gists', 0, 0),
            $this->equalTo('https://api.github.com/gists'),
            'URL is not as expected.'
        );
    }

    /**
     * Tests that fetchUrl() uses api.github.com when the api.url option is not set
     *
     * @return  void
     */
    public function testFetchUrlDefaultApiUrl()
    {
        $object = new ObjectMock(new Registry(), $this->client);

        $this->assertSame('https://api.github.com/user', (string) $object->fetchUrl('/user'));
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
    }

    /**
     * Tests that the token is sent with each request and read again for every request
     *
     * @return  void
     */
    public function testTokenIsSentPerRequestAndCanBeRotated()
    {
        $transport = new RecordingTransport();
        $object    = new ObjectMock($this->options, new Http([], $transport));

        $this->options->set('gh.token', 'AAA');
        $object->request('/user');

        $this->options->set('gh.token', 'BBB');
        $object->request('/user');

        $this->assertSame('token AAA', $transport->requests[0]['headers']['Authorization']);
        $this->assertSame('token BBB', $transport->requests[1]['headers']['Authorization']);
    }

    /**
     * Tests that the GitHub headers are not left on a shared HTTP client
     *
     * @return  void
     */
    public function testHeadersAreNotStoredOnTheClient()
    {
        $transport = new RecordingTransport();
        $client    = new Http([], $transport);
        $object    = new ObjectMock($this->options, $client);

        $this->options->set('gh.token', 'MyTestToken');
        $object->request('/user');

        $this->assertNull($client->getOption('headers'));

        // Another request through the same client, e.g. to a different host, does not carry the token
        $client->get('https://example.com/');

        $this->assertSame('token MyTestToken', $transport->requests[0]['headers']['Authorization']);
        $this->assertArrayNotHasKey('Authorization', $transport->requests[1]['headers']);
    }

    /**
     * Tests that the GitHub headers are not written into an options registry the client was built from
     *
     * @return  void
     */
    public function testHeadersAreNotStoredInTheOptions()
    {
        $transport = new RecordingTransport();
        $object    = new ObjectMock($this->options, new Http($this->options, $transport));

        $this->options->set('gh.token', 'MyTestToken');
        $object->request('/user');

        $this->assertSame('token MyTestToken', $transport->requests[0]['headers']['Authorization']);
        $this->assertNull($this->options->get('headers'));
    }

    /**
     * Tests the default media type and API version headers and the api.version and gh.token_scheme options
     *
     * @return  void
     */
    public function testDefaultHeadersAndOptions()
    {
        $transport = new RecordingTransport();
        $object    = new ObjectMock($this->options, new Http([], $transport));

        $object->request('/zen');

        $this->options->set('api.version', '2026-03-10');
        $this->options->set('gh.token', 'MyTestToken');
        $this->options->set('gh.token_scheme', 'Bearer');
        $object->request('/zen');

        $this->assertSame(
            ['Accept' => 'application/vnd.github+json', 'X-GitHub-Api-Version' => '2022-11-28'],
            $transport->requests[0]['headers']
        );
        $this->assertSame(
            [
                'Accept'               => 'application/vnd.github+json',
                'X-GitHub-Api-Version' => '2026-03-10',
                'Authorization'        => 'Bearer MyTestToken',
            ],
            $transport->requests[1]['headers']
        );
    }

    /**
     * Tests that headers set on the client take precedence and are left as they were
     *
     * @return  void
     */
    public function testClientHeadersTakePrecedence()
    {
        $transport = new RecordingTransport();
        $client    = new Http(
            ['headers' => ['authorization' => 'token Custom', 'Accept' => 'application/vnd.github.raw+json']],
            $transport
        );
        $object    = new ObjectMock($this->options, $client);

        $this->options->set('gh.token', 'MyTestToken');
        $object->request('/user');

        $headers = $transport->requests[0]['headers'];

        $this->assertSame('token Custom', $headers['authorization']);
        $this->assertArrayNotHasKey('Authorization', $headers);
        $this->assertSame('application/vnd.github.raw+json', $headers['Accept']);
        $this->assertSame(
            ['authorization' => 'token Custom', 'Accept' => 'application/vnd.github.raw+json'],
            $client->getOption('headers')
        );
    }

    /**
     * Tests that Basic auth credentials are sent in the Authorization header, not in the URL
     *
     * @return  void
     */
    public function testBasicAuthIsSentAsHeader()
    {
        $transport = new RecordingTransport();
        $object    = new ObjectMock($this->options, new Http([], $transport));

        $this->options->set('api.url', 'https://api.github.com');
        $this->options->set('api.username', 'bob');
        $this->options->set('api.password', 'p@ss:w/rd');
        $object->request('/user');

        $this->assertSame('https://api.github.com/user', $transport->requests[0]['uri']);
        $this->assertSame('Basic ' . base64_encode('bob:p@ss:w/rd'), $transport->requests[0]['headers']['Authorization']);
    }

    /**
     * Tests that sub-packages send the headers once
     *
     * @return  void
     */
    public function testSubPackagesSendTheHeaders()
    {
        $transport = new RecordingTransport();
        $options   = new Registry();
        $options->set('gh.token', 'MyTestToken');

        $github = new Github($options, new Http([], $transport));
        $github->repositories->forks->getList('joomla', 'joomla-framework');

        $this->assertSame('https://api.github.com/repos/joomla/joomla-framework/forks', $transport->requests[0]['uri']);
        $this->assertSame('token MyTestToken', $transport->requests[0]['headers']['Authorization']);
    }

    /**
     * Tests that a JSON body is sent as application/json, and a form body keeps the transport's content type
     *
     * @return  void
     */
    public function testJsonBodyContentType()
    {
        $transport = new RecordingTransport();
        $client    = new Http([], $transport);
        $github    = new Github($this->options, $client);

        $github->markdown->render('Hello');
        $github->authorization->requestToken('{id}', '{secret}', '{code}', '', 'json');

        $this->assertSame('application/json', $transport->requests[0]['headers']['Content-Type']);
        $this->assertArrayNotHasKey('Content-Type', $transport->requests[1]['headers']);
        $this->assertNull($client->getOption('headers'));
    }
}
