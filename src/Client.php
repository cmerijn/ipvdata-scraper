<?php

use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\BrowserKit\Response;

class Client extends AbstractBrowser
{
    private $httpClient;

    public function __construct()
    {
        parent::__construct();
        $this->httpClient = new Client();
    }

    protected function doRequest($request): Response
    {
        $method = $request->getMethod();
        $url = $request->getUri();
        $headers = $request->getHeaders();
        $content = $request->getContent();

        $response = $this->httpClient->request($method, $url, [
            'headers' => $headers,
            'body' => $content,
        ]);

        // Get status en headers van de response
        $content = $response->getContent();
        $status = $response->getStatusCode();
        $headers = $response->getHeaders();

        return new Response($content, $status, $headers);
    }
}
