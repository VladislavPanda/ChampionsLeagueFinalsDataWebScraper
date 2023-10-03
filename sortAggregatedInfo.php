<?php

declare(strict_types=1);

/**
 * Function for sorting array of parsed data (sub arrays dy desc)
 *
 * @param array $aggregatedInfo
 * @return array
 */
function sortAggregatedInfo(array $aggregatedInfo): array
{
    foreach ($aggregatedInfo as $key => $value) {
        if (is_array($value)) {
            uasort($aggregatedInfo[$key], function ($a, $b) {
                if ($a == $b) {
                    return 0;
                }

                return ($a < $b) ? 1 : -1;
            });
        }
    }

    return $aggregatedInfo;
}