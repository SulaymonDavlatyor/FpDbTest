<?php

namespace Strategy;

class BuildQueryIdentificatorStrategy extends AbstractBuildQueryStrategy
{
    /**
     * @param $value
     * @return string
     */
    public function replace($value): string
    {
        if (is_array($value)) {
            return implode(', ', array_map([$this, 'escapeIdentifier'], $value));
        }
        return $this->escapeIdentifier($value);
    }
}
