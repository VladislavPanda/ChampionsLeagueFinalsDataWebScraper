<?php

declare(strict_types=1);

require_once 'simple_html_dom.php';
require_once 'parseTable.php';
require_once 'sortAggregatedInfo.php';

$pageUrl = 'https://ru.wikipedia.org/wiki/%D0%A1%D0%BF%D0%B8%D1%81%D0%BE%D0%BA_%D1%84%D0%B8%D0%BD%D0%B0%D0%BB%D0%BE%D0%B2_%D0%9A%D1%83%D0%B1%D0%BA%D0%B0_%D0%B5%D0%B2%D1%80%D0%BE%D0%BF%D0%B5%D0%B9%D1%81%D0%BA%D0%B8%D1%85_%D1%87%D0%B5%D0%BC%D0%BF%D0%B8%D0%BE%D0%BD%D0%BE%D0%B2_%D0%B8_%D0%9B%D0%B8%D0%B3%D0%B8_%D1%87%D0%B5%D0%BC%D0%BF%D0%B8%D0%BE%D0%BD%D0%BE%D0%B2_%D0%A3%D0%95%D0%A4%D0%90';

/**
 * Array matching columns indexes in parsed table with keys in aggregated info dataset
 */
$tableColumnNumbersWithKeys = [
    1 => 'winnersByCountries',
    2 => 'winnersByTeams',
    4 => 'finalistsByTeams',
    'finalistsByCountries',
    'stadiums',
    'stadiumCity',
];

$html = file_get_html($pageUrl); // Html object creation from DOM by URL

if (!$html) {
    exit('Ошибка! Не удалось получить содержимое страницы');
}

$table = $html->find('table.sortable', 0); // Create table node object
$aggregatedInfo = parseTable($table, $tableColumnNumbersWithKeys); // Function of parsing table and retrieving data
unset($html); // Clean HTML object

$aggregatedInfo = sortAggregatedInfo($aggregatedInfo); // Sort result array

file_put_contents('aggregatedInfo.json', json_encode($aggregatedInfo, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));