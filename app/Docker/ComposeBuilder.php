<?php

namespace App\Docker;

class ComposeBuilder
{
    private array $currentComposeData = [];

    public function build(string $projectName): static
    {
        $this->currentComposeData = [
            'name' => $projectName,
            'services' => [],
            'networks' => [
                sprintf('%s-internal', $projectName) => [
                    'name' => sprintf('%s-internal', $projectName),
                    'external' => true,
                ],
            ],
        ];;
        return $this;
    }

    public function addServices(array $services): self
    {
        foreach ($services as $name => $service) {
            $this->currentComposeData['services'][$name] = $service;
        }

        return $this;
    }

    public function addService(string $serviceName, array $serviceData): static
    {
        $this->currentComposeData['services'][$serviceName] = $serviceData;

        return $this;
    }

    public function addNetwork(string $networkName, bool $isExternal): static
    {
        $this->currentComposeData['networks'][$networkName] = ['external' => $isExternal, 'name' => $networkName];

        return $this;
    }

    public function addVolume(string $volumeName, bool $isExternal): static
    {
        if (!array_key_exists('volumes', $this->currentComposeData)) {
            $this->currentComposeData['volumes'] = [];
        }
        $this->currentComposeData['volumes'][$volumeName] = ['external' => $isExternal, 'name' => $volumeName];

        return $this;
    }

    public function get(): array
    {
        return $this->currentComposeData;
    }
}
