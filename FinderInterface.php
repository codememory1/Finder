<?php

namespace Codememory\Components\Finder;

/**
 * Interface FinderInterface
 * @package Codememory\Components\src\Finder
 *
 * @author  Codememory
 */
interface FinderInterface
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Search for files or folders by last modified date in seconds
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param int $time
     *
     * @return FinderInterface
     */
    public function modify(int $time): FinderInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Search for files or folders by file size in bytes and
     * using 2 argument math operator in number greater than less
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param int $size
     * @param int $operator
     *
     * @return FinderInterface
     */
    public function size(int $size, int $operator = Find::SIZE_SMALLER): FinderInterface;

    /**
     * @param string $regex
     *
     * @return FinderInterface
     */
    public function byRegex(string $regex): FinderInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Search files or folders by regular expression
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param array|string $expansion
     *
     * @return FinderInterface
     */
    public function expansion(array|string $expansion): FinderInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * The path must be a file
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return FinderInterface
     */
    public function file(): FinderInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * The path must be a directory
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return FinderInterface
     */
    public function directory(): FinderInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>
     * The path must be a link
     * <=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return FinderInterface
     */
    public function link(): FinderInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Search by parent's name
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $dir
     *
     * @return FinderInterface
     */
    public function dirname(string $dir): FinderInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Search for files in a specific directory
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $path
     *
     * @return FinderInterface
     */
    public function toPath(string $path): FinderInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Search by filename or basename
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $name
     *
     * @return FinderInterface
     */
    public function filename(string $name): FinderInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>
     * Find files by mimetype
     * <=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $type
     *
     * @return FinderInterface
     */
    public function mimetype(string $type): FinderInterface;

}
