<?php

namespace App\Domain\EndpointManagement;

use App\Domain\ProjectManagement\Project;

interface EndpointManagerInterface
{
    public function create(Project $project,
                           string $path,
                           int $responseCode,
                           ?string $responseBody): Endpoint;

    public function pause(Endpoint $endpoint): void;

    public function remove(Endpoint $endpoint): void;
}
