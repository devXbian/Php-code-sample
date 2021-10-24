<?php

namespace App\Dictionaries;

abstract class BaseDictionary
{
    /**
     * Returns the list of constant values
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public static function getValues(): array
    {
        $refl = new \ReflectionClass(get_called_class());
        return array_values($refl->getConstants());
    }

    /**
     * Returns the list of constant keys
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public static function getKeys(): array
    {
        $refl = new \ReflectionClass(get_called_class());
        return array_keys($refl->getConstants());
    }

    /**
     * This method returns the value for the given key if it exist else return null
     *
     * @param $key
     * @return mixed|null
     *
     * @throws \ReflectionException
     */
    public static function getValueForKey($key)
    {
        $keyValuePair = self::getKeyValuePair();
        return $keyValuePair[strtoupper($key)] ?? null;
    }

    /**
     * This method returns the key for the given value if it exist else return null
     *
     * @param $value
     * @return mixed|null
     *
     * @throws \ReflectionException
     */
    public static function getKeyForValue($value)
    {
        $keyValuePair = self::getKeyValuePair();
        return array_search($value, $keyValuePair) ?? null;
    }

    /**
     * Return the key value pair list
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public static function getKeyValuePair(): array
    {
        $refl = new \ReflectionClass(get_called_class());
        return $refl->getConstants();
    }
}
