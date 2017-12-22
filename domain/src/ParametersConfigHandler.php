<?php

namespace ApiCycle\Domain;

class ParametersConfigHandler
{
    /**
     * @param array  $parameters
     * @param string $configAsAString
     *
     * @return string
     */
    public static function replaceParametersInConfig(array $parameters, $configAsAString)
    {
        $configAsAString = str_replace(
            self::computePlaceHolders(array_keys($parameters)),
            array_values($parameters),
            $configAsAString
        );

        return $configAsAString;
    }

    /**
     * @param array $parameterKeys
     *
     * @return array
     */
    private static function computePlaceHolders(array $parameterKeys)
    {
        $placeholders = array_map(function ($key) {
            return '%'.$key.'%';
        }, $parameterKeys);

        return $placeholders;
    }
}
