<?php

namespace Kickbox\Test;

use Kickbox\Client;
use PHPUnit\Framework\TestCase;

class VerifyTest extends TestCase
{
    protected $kickbox = null;

    public function setup()
    {
        $api_key = getenv('API_KEY');

        if (!$api_key) {
            throw new \ErrorException('Invalid Api Key');
        }

        $client = new Client($api_key);
        $this->kickbox = $client->kickbox();
    }

    public function testVerifiyDeliverable()
    {
        $response = $this->kickbox->verify('deliverable@kickbox.io');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('deliverable', $body['result']);
        $this->assertEquals('accepted_email', $body['reason']);
        $this->assertFalse($body['role']);
        $this->assertFalse($body['free']);
        $this->assertFalse($body['disposable']);
        $this->assertFalse($body['accept_all']);
        $this->assertInternalType('int', $body['sendex']);
        $this->assertEquals('deliverable@kickbox.io', $body['email']);
        $this->assertEquals('deliverable', $body['user']);
        $this->assertEquals('kickbox.io', $body['domain']);
        $this->assertTrue($body['success']);
    }

    public function testVerifyUndeliverable()
    {
        $response = $this->kickbox->verify('rejected-email@kickbox.io');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('undeliverable', $body['result']);
        $this->assertEquals('rejected_email', $body['reason']);
        $this->assertFalse($body['role']);
        $this->assertFalse($body['free']);
        $this->assertFalse($body['disposable']);
        $this->assertFalse($body['accept_all']);
        $this->assertInternalType('int', $body['sendex']);
        $this->assertEquals('rejected-email@kickbox.io', $body['email']);
        $this->assertEquals('rejected-email', $body['user']);
        $this->assertEquals('kickbox.io', $body['domain']);
        $this->assertTrue($body['success']);
    }

    public function testVerifyUndeliverableInvalidDomain()
    {
        $response = $this->kickbox->verify('invalid-domain@kickbox.io');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('undeliverable', $body['result']);
        $this->assertEquals('invalid_domain', $body['reason']);
        $this->assertFalse($body['role']);
        $this->assertFalse($body['free']);
        $this->assertFalse($body['disposable']);
        $this->assertFalse($body['accept_all']);
        $this->assertInternalType('int', $body['sendex']);
        $this->assertEquals('invalid-domain@kickbox.io', $body['email']);
        $this->assertEquals('invalid-domain', $body['user']);
        $this->assertEquals('kickbox.io', $body['domain']);
        $this->assertTrue($body['success']);
    }

    public function testVerifyUndeliverableInvalidEmail()
    {
        $response = $this->kickbox->verify('invalid-email@kickbox.io');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('undeliverable', $body['result']);
        $this->assertEquals('invalid_email', $body['reason']);
        $this->assertFalse($body['role']);
        $this->assertFalse($body['free']);
        $this->assertFalse($body['disposable']);
        $this->assertFalse($body['accept_all']);
        $this->assertInternalType('int', $body['sendex']);
        $this->assertEquals('invalid-email@kickbox.io', $body['email']);
        $this->assertEquals('invalid-email', $body['user']);
        $this->assertEquals('kickbox.io', $body['domain']);
        $this->assertTrue($body['success']);
    }

    public function testVerifyUndeliverableInvalidSMTP()
    {
        $response = $this->kickbox->verify('invalid-smtp@kickbox.io');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('undeliverable', $body['result']);
        $this->assertEquals('invalid_smtp', $body['reason']);
        $this->assertFalse($body['role']);
        $this->assertFalse($body['free']);
        $this->assertFalse($body['disposable']);
        $this->assertFalse($body['accept_all']);
        $this->assertInternalType('int', $body['sendex']);
        $this->assertEquals('invalid-smtp@kickbox.io', $body['email']);
        $this->assertEquals('invalid-smtp', $body['user']);
        $this->assertEquals('kickbox.io', $body['domain']);
        $this->assertTrue($body['success']);
    }

    public function testVerifyRiskyLowQuality()
    {
        $response = $this->kickbox->verify('low-quality@kickbox.io');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('risky', $body['result']);
        $this->assertEquals('low_quality', $body['reason']);
        $this->assertFalse($body['role']);
        $this->assertTrue($body['free']);
        $this->assertFalse($body['disposable']);
        $this->assertFalse($body['accept_all']);
        $this->assertInternalType('float', $body['sendex']);
        $this->assertEquals('low-quality@kickbox.io', $body['email']);
        $this->assertEquals('low-quality', $body['user']);
        $this->assertEquals('kickbox.io', $body['domain']);
        $this->assertTrue($body['success']);
    }

    public function testVerifyRiskyAcceptAll()
    {
        $response = $this->kickbox->verify('accept-all@kickbox.io');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('risky', $body['result']);
        $this->assertEquals('low_deliverability', $body['reason']);
        $this->assertFalse($body['role']);
        $this->assertFalse($body['free']);
        $this->assertFalse($body['disposable']);
        $this->assertTrue($body['accept_all']);
        $this->assertInternalType('float', $body['sendex']);
        $this->assertEquals('accept-all@kickbox.io', $body['email']);
        $this->assertEquals('accept-all', $body['user']);
        $this->assertEquals('kickbox.io', $body['domain']);
        $this->assertTrue($body['success']);
    }

    public function testVerifyRiskyRole()
    {
        $response = $this->kickbox->verify('role@kickbox.io');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('risky', $body['result']);
        $this->assertEquals('low_quality', $body['reason']);
        $this->assertTrue($body['role']);
        $this->assertFalse($body['free']);
        $this->assertFalse($body['disposable']);
        $this->assertFalse($body['accept_all']);
        $this->assertInternalType('float', $body['sendex']);
        $this->assertEquals('role@kickbox.io', $body['email']);
        $this->assertEquals('role', $body['user']);
        $this->assertEquals('kickbox.io', $body['domain']);
        $this->assertTrue($body['success']);
    }

    public function testVerifyRiskyDisposable()
    {
        $response = $this->kickbox->verify('disposable@kickbox.io');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('risky', $body['result']);
        $this->assertEquals('low_quality', $body['reason']);
        $this->assertFalse($body['role']);
        $this->assertFalse($body['free']);
        $this->assertTrue($body['disposable']);
        $this->assertTrue($body['accept_all']);
        $this->assertInternalType('int', $body['sendex']);
        $this->assertEquals('disposable@kickbox.io', $body['email']);
        $this->assertEquals('disposable', $body['user']);
        $this->assertEquals('kickbox.io', $body['domain']);
        $this->assertTrue($body['success']);
    }

    public function testVerifyUnknwonTimeout()
    {
        $response = $this->kickbox->verify('timeout@kickbox.io');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('unknown', $body['result']);
        $this->assertEquals('timeout', $body['reason']);
        $this->assertFalse($body['role']);
        $this->assertFalse($body['free']);
        $this->assertFalse($body['disposable']);
        $this->assertFalse($body['accept_all']);
        $this->assertInternalType('int', $body['sendex']);
        $this->assertEquals('timeout@kickbox.io', $body['email']);
        $this->assertEquals('timeout', $body['user']);
        $this->assertEquals('kickbox.io', $body['domain']);
        $this->assertTrue($body['success']);
    }

    public function testVerifyInvalidEmail()
    {
        $response = $this->kickbox->verify('unexpected-error@kickbox.io');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('unknown', $body['result']);
        $this->assertEquals('unexpected_error', $body['reason']);
        $this->assertFalse($body['role']);
        $this->assertFalse($body['free']);
        $this->assertFalse($body['disposable']);
        $this->assertFalse($body['accept_all']);
        $this->assertInternalType('int', $body['sendex']);
        $this->assertEquals('unexpected-error@kickbox.io', $body['email']);
        $this->assertEquals('unexpected-error', $body['user']);
        $this->assertEquals('kickbox.io', $body['domain']);
        $this->assertTrue($body['success']);
    }

    public function testVerifyUnavailableNoConnect()
    {
        $response = $this->kickbox->verify('no-connect@kickbox.io');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('unknown', $body['result']);
        $this->assertEquals('no_connect', $body['reason']);
        $this->assertFalse($body['role']);
        $this->assertFalse($body['free']);
        $this->assertFalse($body['disposable']);
        $this->assertFalse($body['accept_all']);
        $this->assertInternalType('int', $body['sendex']);
        $this->assertEquals('no-connect@kickbox.io', $body['email']);
        $this->assertEquals('no-connect', $body['user']);
        $this->assertEquals('kickbox.io', $body['domain']);
        $this->assertTrue($body['success']);
    }

    public function testVerifyUnavailableSMTP()
    {
        $response = $this->kickbox->verify('unavailable-smtp@kickbox.io');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('unknown', $body['result']);
        $this->assertEquals('unavailable_smtp', $body['reason']);
        $this->assertFalse($body['role']);
        $this->assertFalse($body['free']);
        $this->assertFalse($body['disposable']);
        $this->assertFalse($body['accept_all']);
        $this->assertInternalType('int', $body['sendex']);
        $this->assertEquals('unavailable-smtp@kickbox.io', $body['email']);
        $this->assertEquals('unavailable-smtp', $body['user']);
        $this->assertEquals('kickbox.io', $body['domain']);
        $this->assertTrue($body['success']);
    }

    public function testVerifyInsufficientBalance()
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionCode(403);
        $this->expectExceptionMessage('Insufficient balance');
        $this->kickbox->verify('insufficient-balance@kickbox.io');
    }

    public function tearDown()
    {
        unset($this->kickbox);
    }
}
