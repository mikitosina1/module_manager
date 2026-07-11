<?php

namespace Modules\ModuleManager\App\Services;

use Illuminate\Filesystem\Filesystem;
use RuntimeException;

class ModuleFilesystemService
{
    public function __construct(
        private readonly Filesystem $filesystem = new Filesystem,
    ) {}

    public function deleteModuleDirectory(string $path): void
    {
        $realPath = realpath($path);
        $modulesPath = realpath(base_path('Modules'));

        if ($realPath === false || $modulesPath === false) {
            throw new RuntimeException('Module path not found.');
        }

        if (! str_starts_with($realPath, $modulesPath.DIRECTORY_SEPARATOR)) {
            throw new RuntimeException('Refusing to delete path outside Modules directory.');
        }

        $this->filesystem->deleteDirectory($realPath);
    }
}
