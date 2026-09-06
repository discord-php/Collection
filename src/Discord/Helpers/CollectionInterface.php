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

use ArrayAccess;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Traversable;

/**
 * Contract for a keyed collection of items. The reference implementation is
 * {@see CollectionTrait}; see {@see ExCollectionInterface} for the extended
 * (array-helper) surface.
 */
interface CollectionInterface extends ArrayAccess, JsonSerializable, IteratorAggregate, Countable
{
    /**
     * Gets an item from the collection whose `$discrim` property equals `$key`.
     *
     * @param string $discrim The property to match on.
     * @param mixed  $key      The value to match.
     *
     * @return mixed The matching item, or null.
     */
    public function get(string $discrim, $key);

    /**
     * Sets a value in the collection at `$offset`.
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function set($offset, $value);

    /**
     * Removes an item at `$key` and returns it, or `$default` when it is absent.
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function pull($key, $default = null);

    /**
     * Fills the collection with an array (or another collection) of items.
     *
     * @param CollectionInterface|array $items
     */
    public function fill($items): self;

    /**
     * Pushes one or more items onto the collection.
     *
     * @param mixed ...$items
     */
    public function push(...$items): self;

    /**
     * Pushes a single item onto the collection, keyed by its discriminator.
     *
     * @param mixed $item
     */
    public function pushItem($item): self;

    /**
     * @inheritDoc
     */
    public function count(): int;

    /** @return mixed The first item in the collection, or null when empty. */
    public function first();

    /** @return mixed The last item in the collection, or null when empty. */
    public function last();

    /**
     * Whether an item exists at `$offset`.
     *
     * @param mixed $offset
     */
    public function isset($offset): bool;

    /**
     * Whether an item exists at every one of `$keys`.
     *
     * @param mixed ...$keys
     */
    public function has(...$keys): bool;

    /**
     * Runs a filter callback over the collection and returns a new collection
     * of the items for which it returned true.
     *
     * @param callable $callback
     */
    public function filter(callable $callback);

    /**
     * Returns the first item for which `$callback` returns true, or null.
     *
     * @param callable $callback
     *
     * @return mixed
     */
    public function find(callable $callback);

    /**
     * Removes every item from the collection.
     */
    public function clear(): void;

    /**
     * Returns a new collection with `$callback` applied to each item.
     *
     * @param callable $callback
     */
    public function map(callable $callback);

    /**
     * Merges another collection (or array) into this one.
     *
     * @param CollectionInterface|array $collection
     */
    public function merge($collection): self;

    /**
     * @deprecated 10.42.0 Use `jsonSerialize`
     *
     * @param bool $assoc Whether to keep string keys.
     */
    public function toArray(bool $assoc = true): array;

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool;

    /**
     * @inheritDoc
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset);

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void;

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset): void;

    /**
     * Serialises the collection to a JSON string.
     *
     * @param int      $flags `json_encode` flags.
     * @param int|null $depth `json_encode` depth.
     */
    public function serialize(int $flags = 0, ?int $depth = 512): string;

    /**
     * The items, for PHP's native `serialize()`.
     */
    public function __serialize(): array;

    /**
     * Restores the collection from a JSON string produced by {@see serialize()}.
     */
    public function unserialize(string $serialized): void;

    /**
     * Restores the collection from the payload of PHP's native `unserialize()`.
     *
     * @param array $data
     */
    public function __unserialize($data): void;

    /**
     * @inheritDoc
     *
     * @param bool $assoc Whether to keep string keys.
     */
    public function jsonSerialize(bool $assoc = true): array;

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable;

    /**
     * Debug representation for `var_dump()`.
     */
    public function __debugInfo(): array;
}
