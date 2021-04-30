<?php

namespace App\Domain\EndpointManagement;

use App\Domain\ProjectManagement\Project;

interface EndpointManagerInterface
{
    public function create(Project $project, string $path, int $responseCode, array $responseBody = []): Endpoint;

    public function remove(Endpoint $endpoint): void;
}
