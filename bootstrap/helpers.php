<?php

if (!function_exists('format_relation_ids')) {
    function format_relation_ids(array $items, string $key = 'id')
    {
        if (is_array($first = \reset($items)) && \array_key_exists($key, $first)) {
            return \array_column($items, $key);
        }

        return $items;
    }
}
