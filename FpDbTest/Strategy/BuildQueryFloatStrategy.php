<?php

namespace Strategy;

use FpDbTest\Database;

class BuildQueryFloatStrategy extends AbstractBuildQueryStrategy
{
    /**
     * @param $value
     * @return float|string
     */
    public function replace($value): float|string
    {
        if ($value == Database::SKIP) {
            return $value;
        }
        return is_null($value) ? "NULL" : floatval($value);
    }
}
