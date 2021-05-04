<?php

namespace App\Domain\EndpointManagement;

use App\Domain\ProjectManagement\Project;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity
 * @ORM\Table(name="`endpoints`", uniqueConstraints={
 *     @UniqueConstraint(
 *          name="path_unique", columns={"project_id", "path"}
 *     )
 * })
 */
class Endpoint
{
    public const STATE_ACTIVE = 'active';
    public const STATE_PAUSED = 'paused';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\ProjectManagement\Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected Project $project;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected string $path;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected int $responseCode;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $responseBody;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected string $state = self::STATE_ACTIVE;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    public function setResponseCode(int $responseCode): void
    {
        $this->responseCode = $responseCode;
    }

    public function getResponseBody(): ?string
    {
        return $this->responseBody;
    }

    public function setResponseBody(string $responseBody): void
    {
        $this->responseBody = $responseBody;
    }

    public function getProject(): Project
    {
        return $this->project;
    }

    public function setProject(Project $project): void
    {
        $this->project = $project;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }
}
