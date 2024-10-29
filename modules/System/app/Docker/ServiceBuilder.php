<?php

namespace Modules\System\Docker;

use Modules\System\Docker\Enum\RestartPolicy;
use Modules\System\Models\DockerImage;

class ServiceBuilder
{
    private array $currentService;

    public function buildService(string $projectName, string $serviceName): static
    {
        $this->currentService = [
            'container_name' => sprintf('%s-%s', $projectName, $serviceName),
            'restart' => RestartPolicy::NONE->value,
            'networks' => [
                sprintf('%s-internal', $projectName),
            ],
        ];
        return $this;
    }

    public function setImage(DockerImage|string $image): static
    {
        if ($image instanceof DockerImage) {
            $this->currentService['image'] = $image->name;

            return $this;
        }

        $this->currentService['image'] = $image;

        return $this;
    }

    public function setRestartPolicy(RestartPolicy $restartPolicy): static
    {
        $this->currentService['restart'] = $restartPolicy->value;

        return $this;
    }

    public function addVolume(string $volumeSource, string $volumeTarget): static
    {
        if (!array_key_exists('volumes', $this->currentService)) {
            $this->currentService['volumes'] = [];
        }
        $this->currentService['volumes'][] = sprintf('%s:%s', $volumeSource, $volumeTarget);
        return $this;
    }

    public function addPort(int $portSource, int $portTarget): static
    {
        if (
            ($portSource <= 1024 || $portSource > 65535)
            ||
            ($portTarget <= 1024 || $portTarget > 65535)
        ) {
            throw new \InvalidArgumentException('Port source and Port target must be between 1024 and 65535');
        }
        if (!array_key_exists('ports', $this->currentService)) {
            $this->currentService['ports'] = [];
        }
        $this->currentService['ports'][] = sprintf('%s:%s', $portSource, $portTarget);

        return $this;
    }

    public function addLabel(string $labelName, string $labelValue): static
    {
        if (!array_key_exists('labels', $this->currentService)) {
            $this->currentService['labels'] = [];
        }
        $this->currentService['labels'][$labelName] = $labelValue;

        return $this;
    }

    public function addEnvironmentVariable(string $variableName, string $variableValue): static
    {
        if (!array_key_exists('environment', $this->currentService)) {
            $this->currentService['environment'] = [];
        }
        $this->currentService['environment'][$variableName] = $variableValue;

        return $this;
    }

    public function addDependency(string $dependentService): static
    {
        if (!array_key_exists('depends_on', $this->currentService)) {
            $this->currentService['depends_on'] = [];
        }
        $this->currentService['depends_on'][] = $dependentService;

        return $this;
    }

    public function get(): array
    {
        return $this->currentService;
    }
}
