<?php

declare(strict_types=1);

/*
 * This file is a part of the DiscordPHP project.
 *
 * Copyright (c) 2015-present David Cole <david.cole1340@gmail.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE.md file.
 */

namespace Discord\Helpers;

/**
 * The extended collection contract: {@see CollectionInterface} plus the
 * array-style helpers (`shift`, `search`, `splice`, `slice`, `sort`, `diff`,
 * `intersect`, `walk`, `reduce`, `unique`, …). Implemented by
 * {@see CollectionTrait}.
 */
interface ExCollectionInterface extends CollectionInterface
{
    /** @return array|null The `[key => value]` pair removed from the front, or null when the collection is empty. */
    public function shift();

    /**
     * Searches for `$needle` and returns its key, or false when not found.
     *
     * @param mixed $needle
     * @param bool  $strict Whether to compare with `===`.
     */
    public function search(mixed $needle, bool $strict = false): string|int|false;

    /** @return string|int|null The key of the first item matching `$callback`, or null. */
    public function find_key(callable $callback);

    /** Whether at least one item matches `$callback`. */
    public function any(callable $callback): bool;

    /** Whether every item matches `$callback`. */
    public function all(callable $callback): bool;

    /**
     * Removes `$length` items starting at `$offset`, inserting `$replacement` in
     * their place. Mutates the collection and returns it.
     *
     * @return ExCollectionInterface
     */
    public function splice(int $offset, ?int $length, mixed $replacement = []): self;

    /**
     * @inheritDoc
     */
    public function clear(): void;

    /**
     * Returns a new collection with the slice `$offset`..`$offset + $length`.
     *
     * @return ExCollectionInterface
     */
    public function slice(int $offset, ?int $length = null, bool $preserve_keys = false);
    /** @return ExCollectionInterface */
    public function sort(callable|int|null $callback = null);
    /** @return ExCollectionInterface */
    public function diff($items, ?callable $callback = null);
    /** @return ExCollectionInterface */
    public function intersect($items, ?callable $callback = null);
    /** @return ExCollectionInterface */
    public function walk(callable $callback, mixed $arg = null);
    /** @return mixed The final value of `$carry`. */
    public function reduce(callable $callback, $initial = null);
    /** @return ExCollectionInterface */
    public function unique(int $flags = SORT_STRING);

    /** @return array The collection's keys. */
    public function keys(): array;

    /** @return array The collection's values, re-indexed. */
    public function values(): array;
}
