<?php

namespace Kwk\Geckoboard\Dataset;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Message\ResponseInterface;

class Client
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @param HttpClient $httpClient
     * @param string     $apiKey
     */
    public function __construct(HttpClient $httpClient, $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey     = $apiKey;
    }

    /**
     * Tworzenie dataSet
     *
     * @param DataSetInterface $dataSet
     *
     * @return ResponseInterface
     * @throws RequestException
     */
    public function create(DataSetInterface $dataSet)
    {
        return (new RequestFactory($this->httpClient, $this->apiKey))->createRequest($dataSet);
    }

    /**
     * Dodaje wiersz do dataset'u
     *
     * @param DataSetInterface      $dataSet
     * @param DataSetRowInterface[] $dataRows
     *
     * @return ResponseInterface
     */
    public function append(DataSetInterface $dataSet, array $dataRows)
    {
        return (new RequestFactory($this->httpClient, $this->apiKey))->appendRequest($dataSet->getName(), $dataRows);
    }

    /**
     * Podmienia cały dataset
     *
     * @param DataSetInterface      $dataSet
     * @param DataSetRowInterface[] $dataRows
     *
     * @return ResponseInterface
     */
    public function replace(DataSetInterface $dataSet, array $dataRows)
    {
        return (new RequestFactory($this->httpClient, $this->apiKey))->replaceRequest($dataSet->getName(), $dataRows);
    }

    /**
     * Usunięcie dataset'u
     *
     * @param DataSetInterface $dataSet
     *
     * @return ResponseInterface
     */
    public function delete(DataSetInterface $dataSet)
    {
        return (new RequestFactory($this->httpClient, $this->apiKey))->deleteRequest($dataSet->getName());
    }
}
