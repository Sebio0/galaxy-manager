<?php

namespace Modules\System\Traits;

use Modules\System\DTO\SSHResult;
use Spatie\Ssh\Ssh;

trait SSHCommandTrait
{
    protected function runCommand(string|array $command): SSHResult
    {
        $process = Ssh::create(
            \Config::get('git.host'),
            \Config::get('git.user'),
            \Config::get('git.port'),
        )->usePrivateKey(\Config::get('git.private_key'))->execute($command);
        return new SSHResult($process->isSuccessful(), $process->getOutput(), $process->getErrorOutput());
    }
}
