<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Apps;

use Joomla\Github\Package\Apps\OauthApplications;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Apps\OauthApplications.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(OauthApplications::class)]
class OauthApplicationsTest extends GitHubTestCase
{
    /**
     * @var    OauthApplications  Object under test.
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

        $this->object = new OauthApplications($this->options, $this->client);
    }

    /**
     * Tests the deleteAuthorization method.
     *
     * @return  void
     */
    public function testDeleteAuthorization()
    {
        $this->response = $this->getResponseObject('', 204);
        $body = '{"access_token":"e72e16c7e42f292c6912e7710c838347ae178b4a"}';

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/applications/Iv1.8a61f9b3a7aba766/grant', [], 0, $body)
            ->willReturn($this->response);

        $this->assertNull($this->object->deleteAuthorization('Iv1.8a61f9b3a7aba766', 'e72e16c7e42f292c6912e7710c838347ae178b4a'));
    }

    /**
     * Tests the deleteAuthorization method - failure.
     *
     * @return  void
     */
    public function testDeleteAuthorizationFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->deleteAuthorization('Iv1.8a61f9b3a7aba766', 'e72e16c7e42f292c6912e7710c838347ae178b4a');
    }

    /**
     * Tests the checkToken method.
     *
     * @return  void
     */
    public function testCheckToken()
    {
        $body = '{"access_token":"e72e16c7e42f292c6912e7710c838347ae178b4a"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/applications/Iv1.8a61f9b3a7aba766/token', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->checkToken('Iv1.8a61f9b3a7aba766', 'e72e16c7e42f292c6912e7710c838347ae178b4a')
        );
    }

    /**
     * Tests the checkToken method - failure.
     *
     * @return  void
     */
    public function testCheckTokenFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->checkToken('Iv1.8a61f9b3a7aba766', 'e72e16c7e42f292c6912e7710c838347ae178b4a');
    }

    /**
     * Tests the resetToken method.
     *
     * @return  void
     */
    public function testResetToken()
    {
        $body = '{"access_token":"e72e16c7e42f292c6912e7710c838347ae178b4a"}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/applications/Iv1.8a61f9b3a7aba766/token', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->resetToken('Iv1.8a61f9b3a7aba766', 'e72e16c7e42f292c6912e7710c838347ae178b4a')
        );
    }

    /**
     * Tests the resetToken method - failure.
     *
     * @return  void
     */
    public function testResetTokenFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('patch')
            ->willReturn($this->response);

        $this->object->resetToken('Iv1.8a61f9b3a7aba766', 'e72e16c7e42f292c6912e7710c838347ae178b4a');
    }

    /**
     * Tests the deleteToken method.
     *
     * @return  void
     */
    public function testDeleteToken()
    {
        $this->response = $this->getResponseObject('', 204);
        $body = '{"access_token":"e72e16c7e42f292c6912e7710c838347ae178b4a"}';

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/applications/Iv1.8a61f9b3a7aba766/token', [], 0, $body)
            ->willReturn($this->response);

        $this->assertNull($this->object->deleteToken('Iv1.8a61f9b3a7aba766', 'e72e16c7e42f292c6912e7710c838347ae178b4a'));
    }

    /**
     * Tests the deleteToken method - failure.
     *
     * @return  void
     */
    public function testDeleteTokenFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->deleteToken('Iv1.8a61f9b3a7aba766', 'e72e16c7e42f292c6912e7710c838347ae178b4a');
    }
}
