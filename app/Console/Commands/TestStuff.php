<?php

namespace App\Console\Commands;

use app\Docker\ComposeBuilder;
use app\Docker\ServiceBuilder;
use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;

class TestStuff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-stuff';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(ComposeBuilder $composeBuilder, ServiceBuilder $serviceBuilder): void
    {
        $composeBuilder->build('galaxy-testing')->addServices([
            'web' => $serviceBuilder->buildService('galaxy-testing', 'web')
                ->setImage('redis:latest')
                ->addPort(80, 80)
                ->addPort(443, 443)
                ->addLabel('foo', 'bar')
                ->addLabel('bar', 'baz')
                ->addLabel('baz', 'qux')
                ->addEnvironmentVariable('bla', 'asfgafs')
                ->addVolume('/var/www', '/app')
                ->addVolume('/var/www', '/www')
                ->get()
        ]);
        echo Yaml::dump($composeBuilder->get());
    }
}
