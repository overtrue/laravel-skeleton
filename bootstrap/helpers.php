<?php

if (!function_exists('array_merge_recursive_distinct')) {
    /**
     * Array merge recursive distinct.
     *
     * @param array &$array1
     * @param array &$array2
     *
     * @return array
     */
    function array_merge_recursive_distinct(array $array1, array $array2)
    {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = array_merge_recursive_distinct($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }
        return $merged;
    }
}

if (!function_exists('format_relation_ids')) {
    function format_relation_ids(array $items, string $key = 'id')
    {
        if (is_array($first = \reset($items)) && \array_key_exists($key, $first)) {
            return \array_column($items, $key);
        }

        return $items;
    }
}
