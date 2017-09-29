<?php

namespace Kwk\Geckoboard\Dataset;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\RequestInterface;

class RequestFactory
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @param ClientInterface $client
     * @param string          $apiKey
     */
    public function __construct(ClientInterface $client, $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    /**
     * @param DataSetInterface $dataSet
     *
     * @return RequestInterface
     */
    public function createRequest(DataSetInterface $dataSet)
    {
        return $this->client->request(
            'PUT',
            sprintf('/datasets/%s', $dataSet->getName()),
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'auth'    => [$this->apiKey, ''],
                'json'    => $dataSet->getDefinition(),
            ]
        );
    }

    /**
     * @param string                $datasetName
     * @param DataSetRowInterface[] $rows
     *
     * @return RequestInterface
     */
    public function appendRequest($datasetName, array $rows)
    {
        $data = [];
        foreach ($rows as $row) {
            $data[] = $row->getData();
        }

        return $this->client->request(
            'POST',
            sprintf('/datasets/%s/data', $datasetName),
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'auth'    => [$this->apiKey, ''],
                'json'    => ['data' => $data],
            ]
        );
    }

    /**
     * @param string                $datasetName
     * @param DataSetRowInterface[] $rows
     *
     * @return RequestInterface
     */
    public function replaceRequest($datasetName, array $rows)
    {
        $data = [];
        foreach ($rows as $row) {
            $data[] = $row->getData();
        }

        return $this->client->request(
            'PUT',
            sprintf('/datasets/%s/data', $datasetName),
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'auth'    => [$this->apiKey, ''],
                'json'    => ['data' => $data],
            ]
        );
    }

    /**
     * @param string $datasetName
     *
     * @return RequestInterface
     */
    public function deleteRequest($datasetName)
    {
        return $this->client->request(
            'DELETE',
            sprintf('/datasets/%s', $datasetName),
            [
                'auth' => [$this->apiKey, ''],
            ]
        );
    }
}
