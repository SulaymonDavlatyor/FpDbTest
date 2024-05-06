<?php

namespace Strategy;

use FpDbTest\Database;

class BuildQueryIntStrategy extends AbstractBuildQueryStrategy
{
    /**
     * @param $value
     * @return int|string
     */
    public function replace($value): int|string
    {
        if ($value == Database::SKIP) {
            return $value;
        }
        return is_null($value) ? "NULL" : intval($value);
    }
}
