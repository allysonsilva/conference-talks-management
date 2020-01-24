<?php

namespace Support\Common\Traits;

use ReflectionClass;
use Core\ConsoleKernel;
use Illuminate\Support\Arr;
use Symfony\Component\Finder\Finder;

trait LoadCommands
{
    /**
     * @SuppressWarnings("UndefinedVariable")
     */
    protected function loadCommands(): void
    {
        $path = $this->componentPath('Console' . DIRECTORY_SEPARATOR . 'Commands');

        // preg_match('/Domain\/[^\/]+/', $path, $matches);

        // $domainFolderName = explode('/', Arr::first($matches))[1];

        preg_match('/[^\\\]*/', static::class, $matches);

        $domainRootNamespace = $matches[0];

        $commandsPath = [];

        foreach ((Finder::create()->files()->name('*.php')->in($path)->exclude('Off')) as $splFileInfo) {
            $className = (string) $domainRootNamespace . '\\Console\\Commands\\' . $splFileInfo->getFilenameWithoutExtension();

            if (class_exists($className)) {
                $commandReflection = new ReflectionClass($className);
                $commandsPath[] = $commandReflection->getName();
            }
        }

        // if ($this->app->runningInConsole()) {
            $this->commands($commandsPath);
        // }
    }
}
