<?php

declare(strict_types=1);

/**
 * Function for parsing table data and forming aggregated info array
 *
 * @param simple_html_dom_node $table
 * @param array $tableColumnNumbersWithKeys
 * @return array
 */
function parseTable(simple_html_dom_node $table, array $tableColumnNumbersWithKeys): array
{
    $aggregatedInfo = [];

    foreach ($table->find('tr') as $row) {
        foreach ($row->find('td') as $columnNumber => $cell) {
            if (trim($cell->plaintext) == '') {
                break;
            }

            if ($columnNumber == 0 || $columnNumber > 8) {
                continue;
            }

            // Parses num of viewers (with deleting nested tags)
            if ($columnNumber == 8) {
                $cell->removeChild($cell->find('sup', 0));
                $viewersNum = preg_replace('/&#?[a-z0-9]+;/i', '', trim($cell->plaintext));
                $aggregatedInfo['totalViewers'] += (int) $viewersNum;
                continue;
            }

            $cellString = trim($cell->plaintext); // If no need to delete nested tags, write to new var

            if ($columnNumber == 3) {
                $aggregatedInfo['totalGoals'] += array_sum(explode(':', $cellString));
                continue;
            }

            $aggregatedInfo[$tableColumnNumbersWithKeys[$columnNumber]][$cellString]++;
        }
    }

    return $aggregatedInfo;
}