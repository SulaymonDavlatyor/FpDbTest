<?php

namespace Strategy;

use Exception;
use Exception\DatabaseException;
use FpDbTest\Database;

abstract class AbstractBuildQueryStrategy
{
    /**
     * @param $value
     * @return mixed
     */
    abstract public function replace($value);

    /**
     * @param $value
     * @return float|int|string
     */
    protected function formatValue($value): float|int|string
    {
        if (is_null($value)) {
            return "NULL";
        } elseif (is_bool($value)) {
            return $value ? '1' : '0';
        } elseif (is_numeric($value)) {
            return $value;
        } elseif (is_string($value)) {
            return "'" . addslashes($value) . "'";
        } else {
            throw DatabaseException::invalidTypeForDefaultFormat();
        }
    }

    /**
     * @param $identifier
     * @return string
     */
    protected function escapeIdentifier($identifier): string
    {
        return "`" . str_replace("`", "``", $identifier) . "`";
    }
}
