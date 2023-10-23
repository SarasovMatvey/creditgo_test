<?php

$indexField = $argv[1];
$documents = json_decode(file_get_contents('input.json'), true);

$indexValues = [];
foreach ($documents as $i => $document) {
    if (array_key_exists($indexField, $document)) {
        $indexValues []= $document[$indexField];
    }
}

$dups = [];
foreach(array_count_values($indexValues) as $val => $c) {
  if($c > 1) $dups[] = $val;
}

foreach ($indexValues as $i => $indexValue) {
  $indexValues[$i] = [
    'value' => $indexValue,
    'initialIndex' => $i
  ];
}

$dupsHistory = [];

foreach ($indexValues as $i => $indexValue) {
  if (in_array($indexValue['value'], $dups)) {
    if (!array_key_exists($indexValue['value'], $dupsHistory)) {
      $dupsHistory[$indexValue['value']] = [];
    }

    $dupsHistory[$indexValue['value']] []= $indexValue['initialIndex'];

    unset($indexValues[$i]);
  }
}
foreach ($dupsHistory as $value => $initialIndexes) {
  $indexValues []= [
    'value' => $value,
    'initialIndex' => $initialIndexes,
  ];
}

usort($indexValues, function($a, $b) {
  return $a['value'] > $b['value'];
});

$bst = [
  'field' => $indexField,
  'bst' => createBst($indexValues)
];
file_put_contents('bst.json', json_encode($bst));

function createBstRecursive($arr, $start, $end) {
    if ($end < $start) {
      return null;
    }
    $mid = floor(($start + $end) / 2);
    $node = [
      'value' => $arr[$mid]['value'], 
      'initialIndex' => $arr[$mid]['initialIndex']
    ];
    
    $node['left'] = createBstRecursive($arr, $start, $mid - 1);
    $node['right'] = createBstRecursive($arr, $mid + 1, $end);
    
    return $node;
}

function createBst($arr) {
  return createBstRecursive($arr, 0, count($arr) - 1);
}