<?php

namespace Codememory\Components\Finder;

use Codememory\FileSystem\File;
use Codememory\Support\Str;

/**
 * Class Find
 * @package Codememory\Components\src\Finder
 *
 * @author  Codememory
 */
class Find implements FinderInterface
{

    public const SIZE_SMALLER = 1;
    public const SIZE_LARGER = 2;
    /**
     * @var File
     */
    private File $file;

    /**
     * @var array
     */
    private array $fs = [];

    /**
     * Find constructor.
     */
    public function __construct()
    {

        $this->file = new File();

    }

    /**
     * @inheritDoc
     */
    public function setPathForFind(string $path): FinderInterface
    {

        $this->fs = $this->file->scanning($path, true);

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function modify(int $time): FinderInterface
    {

        return $this->handlerFs(function (string $fs, int $index) use ($time) {
            $lastModify = $this->file->info->lastModified($fs);

            if ($lastModify > $time) {
                $this->removeFs($index);
            }
        });

    }

    /**
     * @inheritDoc
     */
    public function size(int $size, int $operator = Find::SIZE_SMALLER): FinderInterface
    {

        return $this->handlerFs(function (string $fs, int $index) use ($size, $operator) {
            if (self::SIZE_SMALLER === $operator) {
                if ($this->file->info->getSize($fs, recursion: true) > $size) {
                    $this->removeFs($index);
                }
            } elseif (self::SIZE_LARGER === $operator) {
                if ($this->file->info->getSize($fs, recursion: true) < $size) {
                    $this->removeFs($index);
                }
            }
        });

    }

    /**
     * @inheritDoc
     */
    public function byRegex(string $regex): FinderInterface
    {

        return $this->handlerFs(function (string $fs, int $index) use ($regex) {
            if (!preg_match(sprintf('/%s/', $regex), $fs)) {
                $this->removeFs($index);
            }
        });

    }

    /**
     * @inheritDoc
     */
    public function expansion(array|string $expansion): FinderInterface
    {

        $expansion = is_string($expansion) ? [$expansion] : $expansion;

        return $this->handlerFs(function (string $fs, int $index) use ($expansion) {
            foreach ($expansion as $value) {
                if (!str_ends_with($fs, $value)) {
                    $this->removeFs($index);
                }
            }
        });

    }

    /**
     * @inheritDoc
     */
    public function file(): FinderInterface
    {

        return $this->handlerFs(function (string $fs, int $index) {
            if (!$this->file->is->file($fs)) {
                $this->removeFs($index);
            }
        });

    }

    /**
     * @inheritDoc
     */
    public function directory(): FinderInterface
    {

        return $this->handlerFs(function (string $fs, int $index) {
            if (!$this->file->is->directory($fs)) {
                $this->removeFs($index);
            }
        });

    }

    /**
     * @inheritDoc
     */
    public function link(): FinderInterface
    {

        return $this->handlerFs(function (string $fs, int $index) {
            if (!$this->file->is->link($fs)) {
                $this->removeFs($index);
            }
        });

    }

    /**
     * @inheritDoc
     */
    public function dirname(string $dir): FinderInterface
    {

        return $this->handlerFs(function (string $fs, int $index) use ($dir) {
            $dirname = $this->file->dirname($fs);

            if ($dir !== $dirname) {
                $this->removeFs($index);
            }
        });

    }

    /**
     * {@inheritdoc}
     */
    public function toPath(string $path): FinderInterface
    {

        return $this->handlerFs(function (string $fs, int $index) use ($path) {
            if(!Str::starts($fs, ltrim($path, '/'))) {
                $this->removeFs($index);
            }
        });

    }

    /**
     * @inheritDoc
     */
    public function filename(string $name): FinderInterface
    {

        return $this->handlerFs(function (string $fs, int $index) use ($name) {
            $basename = $this->file->basename($fs);

            if (!str_starts_with($basename, $name)) {
                $this->removeFs($index);
            }
        });

    }

    /**
     * @inheritDoc
     */
    public function mimetype(string $type): FinderInterface
    {

        return $this->handlerFs(function (string $fs, int $index) use ($type) {
            $mime = mime_content_type($this->file->getRealPath($fs));

            if ($type !== $mime) {
                $this->removeFs($index);
            }
        });

    }

    /**
     * @return array
     */
    public function get(): array
    {

        return array_map(fn ($fs) => ltrim($fs, '/'), $this->fs);

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * A handler with which a specific file is searched
     * for by conditions using callback
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param callable $handler
     *
     * @return FinderInterface
     */
    private function handlerFs(callable $handler): FinderInterface
    {

        $fs = $this->fs;

        foreach ($fs as $index => $value) {
            call_user_func($handler, $value, $index);
        }

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Deleting a file or directory from an array if they
     * & do not match the conditions
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param int $index
     *
     * @return void
     */
    private function removeFs(int $index): void
    {

        unset($this->fs[$index]);

    }

}
