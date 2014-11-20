<?php

class Helper
{
    static $collectorData = array();

    public static function collector($group, $data = null, $order = null)
    {
        if (is_null($data)) {
            ksort(static::$collectorData[$group]);
            return static::$collectorData[$group];
        }

        if (is_numeric($order)) {
            static::$collectorData[$group][$order] = $data;
            return static::$collectorData[$group];
        }

        static::$collectorData[$group][] = $data;
        return static::$collectorData[$group];
    }

    public static function getJsonFile($path, $key = null)
    {
        $data = json_decode(File::get($path), true);
        if (is_null($key)) {
            return $data;
        }
        return isset($data[$key]) ? $data[$key] : false;
    }

}