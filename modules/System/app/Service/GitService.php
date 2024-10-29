<?php

namespace Modules\System\Service;

use Config;
use Gitlab\Client;
use Modules\System\DTO\SSHResult;
use Modules\System\Traits\SSHCommandTrait;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

class GitService
{

    use SSHCommandTrait;

    private Filesystem $filesystem;
    private Client $client;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
        $client = new Client();
        $client->setUrl(config('git.gitlab.url'));
        $client->authenticate(config('git.gitlab.token'), Client::AUTH_HTTP_TOKEN);
        $this->client = $client;
    }

    public function cloneRepository(string $origin, string $target): SSHResult
    {
        if ($this->filesystem->exists($target) || $this->isGitRepository($origin)) {
            return new SSHResult(false, 'Repository already exist.', 'Repository already exist.');
        }
        return $this->runCommand(sprintf('git clone %s %s', $origin, $target));
    }

    /**
     * Dumb Solution, but there is no canonical way without downsides, so we use the stupid solution :D
     */
    private function isGitRepository(string $path): bool
    {
        return $this->filesystem->exists(sprintf('%s/.git', $path));
    }

    public function updateRepository(string $repository): SSHResult
    {
        if (!$this->filesystem->exists($repository) || !$this->isGitRepository($repository)) {
            return new SSHResult(false, 'Repository does not exist.', 'Repository does not exist.');
        }

        return $this->runCommand([
            sprintf('cd %s', $repository),
            'git fetch -a',
            'git reset --hard HEAD',
        ]);
    }

    public function removeRepository(string $repository): SSHResult
    {
        if (!$this->filesystem->exists($repository) || !$this->isGitRepository($repository)) {
            return new SSHResult(false, 'Repository does not exist.', 'Repository does not exist.');
        }
        if (
            $this->filesystem->isAbsolutePath($repository) &&
            Path::isBasePath(Config::get('git.base_dir'), $repository)
        ) {
            return $this->runCommand(sprintf('rm -rf %s', $repository));
        }
        return new SSHResult(true, 'Invalid Path', 'Repository path is invalid.');
    }

    public function checkoutBranch(string $repository, string $branch): SSHResult
    {
        if (!$this->filesystem->exists($repository) || !$this->isGitRepository($repository)) {
            return new SSHResult(false, 'Repository does not exist.', 'Repository does not exist.');
        }
        return $this->runCommand([
            sprintf('cd %s', $repository),
            sprintf('git checkout %s', $branch),
        ]);
    }

    public function setRepositoryToCommit(string $repository, string $commit): SSHResult
    {
        if (!$this->filesystem->exists($repository) || !$this->isGitRepository($repository)) {
            return new SSHResult(false, 'Repository does not exist.', 'Repository does not exist.');
        }
        return $this->runCommand([
            sprintf('cd %s', $repository),
            sprintf('git reset --hard %s', $commit),
        ]);
    }

    /**
     * @return string[]
     */
    public function getBranches(): array
    {
        $branches = $this->client->repositories()->branches(Config::get('git.gitlab.project'));
        $retArray = [];
        foreach ($branches as $branch) {
            $retArray[$branch['name']] = $branch['name'];
        }
        return $retArray;
    }
}
