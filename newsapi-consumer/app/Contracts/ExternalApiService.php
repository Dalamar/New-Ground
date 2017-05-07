<?php

namespace App\Contracts;

interface ExternalApiService
{
    /**
     * Retrieves the data from external resources
     *
     * @param array $params
     * @return mixed
     */
    public function fetchData(...$params);

    /**
     * Injects desired values into target element of original data
     *
     * @param array $original
     * @param string $targetElement
     * @param array $injection
     * @return array
     */
    public function injectData($original, $targetElement, $injection = []);
}