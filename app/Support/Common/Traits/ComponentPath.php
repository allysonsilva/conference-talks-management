<?php

namespace Support\Common\Traits;

use ReflectionClass;

trait ComponentPath
{
    /**
     * Detects the domain/component base path so resources can be proper loaded on child classes.
     *
     * @param string|null $append
     * @param string $pathOrSymbolic
     *
     * @return string
     */
    protected function componentPath(?string $append, string $pathOrSymbolic = '/../'): string
    {
        $reflection = new ReflectionClass($this);
        $realPath = realpath(dirname($reflection->getFileName()) . $pathOrSymbolic);

        // @codeCoverageIgnoreStart
        if (empty($append)) {
            return $realPath;
        }
        // @codeCoverageIgnoreEnd

        return $realPath . DIRECTORY_SEPARATOR . $append;
    }
}
