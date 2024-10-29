<?php

namespace Modules\System\Service;

use app\DTO\SSHResult;
use app\Traits\SSHCommandTrait;
use Modules\System\Docker\Enum\StopType;

class DockerService
{
    use SSHCommandTrait;

    public function createNetwork(string $networkName): SSHResult
    {
        return $this->runCommand(sprintf('docker network create %s', $networkName));
    }

    public function createVolume(string $volumeName): SSHResult
    {
        return $this->runCommand(sprintf('docker volume create %s', $volumeName));
    }

    public function startContainer(string $containerName): SSHResult
    {
        return $this->runCommand(sprintf('docker start %s', $containerName));
    }

    public function stopContainer(string $containerName): SSHResult
    {
        return $this->runCommand(sprintf('docker stop %s', $containerName));
    }

    public function restartContainer(string $containerName): SSHResult
    {
        return $this->runCommand(sprintf('docker restart %s', $containerName));
    }

    public function startComposeProject(string $composeFilePath, string $profile): SSHResult
    {
        return $this->runCommand(sprintf('docker compose -f %s --profile %s up -d', $composeFilePath, $profile));
    }

    public function stopComposeProject(string $composeFilePath, string $profile, StopType $stopType): ?SSHResult
    {
        return match ($stopType) {
            StopType::STOP => $this->runCommand(
                sprintf('docker compose -f %s --profile %s stop', $composeFilePath, $profile),
            ),
            StopType::DOWN => $this->runCommand(
                sprintf('docker compose -f %s --profile %s down', $composeFilePath, $profile),
            ),
        };
    }

    public function restartComposeProject(string $composeFilePath, string $profile): SSHResult
    {
        return $this->runCommand(sprintf('docker compose -f %s --profile %s restart', $composeFilePath, $profile));
    }

}
