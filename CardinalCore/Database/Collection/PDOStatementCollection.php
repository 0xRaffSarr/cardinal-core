<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Database\Collection;


use CardinalCore\Collection\Collection;
use CardinalCore\Exception\InvalidArgumentException;
use PDOStatement;

class PDOStatementCollection extends Collection
{
    /**
     * @inheritDoc
     *
     * @return PDOStatement | null
     */
    public function current() : ?PDOStatement {
        return parent::current();
    }
    /**
     * @inheritDoc
     *
     * @return PDOStatement | null
     */
    public function offsetGet($offset) : ?PDOStatement {
        return parent::offsetGet($offset);
    }

    /**
     * @inheritDoc
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value) {
        if (!$value instanceof PDOStatement) {
            throw new InvalidArgumentException("value must be instance of Post.");
        }

        parent::offsetSet($offset, $value);
    }
}
