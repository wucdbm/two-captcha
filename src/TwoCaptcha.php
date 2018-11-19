<?php

namespace Wucdbm\Component\TwoCaptcha;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class TwoCaptcha {

    /** @var string */
    protected $apiKey;

    /** @var Client */
    protected $client;

    public function __construct(string $apiKey) {
        $this->apiKey = $apiKey;
        $this->client = new Client();
    }

    public function sendMultipart(string $image, TwoCaptchaOptions $options) {
        $options = $options->get([
            'key' => $this->apiKey,
            'json' => 1
        ]);

        $multipart = [];

        $options['method'] = 'post';

        foreach ($options as $option => $value) {
            $multipart[] = [
                'name' => $option,
                'contents' => $value
            ];
        }

        $multipart[] = [
            'name' => 'file',
            'contents' => $image,
            'filename' => 'file.jpg'
        ];

        $response = $this->client->post('http://2captcha.com/in.php', [
            RequestOptions::MULTIPART => $multipart
        ]);

        return $this->processSendResponse($response);
    }

    public function send(string $image, TwoCaptchaOptions $options) {
        $options = $options->get([
            'key' => $this->apiKey,
            'json' => 1
        ]);

        $options['method'] = 'base64';
        $options['body'] = base64_encode($image);

        $response = $this->client->post('http://2captcha.com/in.php', [
            RequestOptions::FORM_PARAMS => $options
        ]);

        return $this->processSendResponse($response);
    }

    protected function processSendResponse(ResponseInterface $response): int {
        $json = $response->getBody()->getContents();

        $job = json_decode($json, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException(sprintf(
                'JSON Decode error: %s',
                json_last_error_msg()
            ));
        }

        if (1 !== $job['status']) {
            throw new \RuntimeException(sprintf('Status was expected to be 1, but was "%s"', $job['status']));
        }

        $jobId = $job['request'];

        return $jobId;
    }

    public function check(int $jobId) {
        $response = $this->client->get('http://2captcha.com/res.php', [
            RequestOptions::QUERY => [
                'key' => $this->apiKey,
                'action' => 'get',
                'id' => $jobId,
                'json' => 1,
            ]
        ]);

        // {"status":0,"request":"CAPCHA_NOT_READY"}
        // {"status":1,"request":"asdf532432Captcha!"}
        $json = $response->getBody()->getContents();

        $captcha = json_decode($json, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException(sprintf(
                'JSON Decode error: %s',
                json_last_error_msg()
            ));
        }

        return new CaptchaResponse($captcha['status'], $captcha['request']);
    }

}