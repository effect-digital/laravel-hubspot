<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Sleep;
use STS\HubSpot\Api\Client;
use STS\HubSpot\Exceptions\RateLimitException;

beforeEach(function () {
    Sleep::fake();
    Log::spy();

    $this->client = new Client(baseUrl: 'https://api.hubapi.com', accessToken: 'token');
    $this->secondlyLimit = [
        'status' => 'error',
        'message' => 'You have reached your secondly limit.',
        'errorType' => 'RATE_LIMIT',
        'policyName' => 'SECONDLY',
    ];
});

test('retries a secondly rate limit and returns the successful response', function () {
    Http::fakeSequence()
        ->push($this->secondlyLimit, 429)
        ->push($this->secondlyLimit, 429)
        ->push(['results' => []], 200);

    $response = $this->client->post('/crm/v3/objects/deals/search');

    expect($response->json('results'))->toBe([]);
    Http::assertSentCount(3);
    Sleep::assertSequence([Sleep::usleep(1000 * 1000), Sleep::usleep(2000 * 1000)]);
    Log::shouldNotHaveReceived('error');
});

test('honours Retry-After when it is longer than the backoff', function () {
    Http::fakeSequence()
        ->push($this->secondlyLimit, 429, ['Retry-After' => '10'])
        ->push(['results' => []], 200);

    $this->client->post('/crm/v3/objects/deals/search');

    Sleep::assertSequence([Sleep::usleep(10000 * 1000)]);
});

test('throws a RateLimitException without logging once retries are exhausted', function () {
    config()->set('hubspot.http.retry.times', 2);

    Http::fake(fn () => Http::response($this->secondlyLimit, 429));

    expect(fn () => $this->client->post('/crm/v3/objects/deals/search'))
        ->toThrow(RateLimitException::class, 'You have reached your secondly limit.');

    Http::assertSentCount(2);
    Log::shouldNotHaveReceived('error');
});

test('does not retry other errors and logs them once', function () {
    Http::fake(fn () => Http::response(['message' => 'Internal error'], 500));

    expect(fn () => $this->client->post('/crm/v3/objects/deals'))
        ->toThrow(Exception::class);

    Http::assertSentCount(1);
    Sleep::assertNeverSlept();
    Log::shouldHaveReceived('error')->once();
});
