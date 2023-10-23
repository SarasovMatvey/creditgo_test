<?php

$searchField = $argv[1];
$searchValue = "Adhi Kot";

$documents = json_decode(file_get_contents('input.json'), true);
$bst = json_decode(file_get_contents('bst.json'), true);

if ($searchField === $bst['field']) {
    var_dump(search($searchValue, $bst['bst']));
}

function search($searchValue, $root) {
    if ($searchValue === $root['value']) {
        return $root['initialIndex'];
    } elseif ($searchValue > $root['value']) {
        if (is_null($root['right'])) {
            return null;
        }

        return search($searchValue, $root['right']);
    } elseif ($searchValue < $root['value']) {
        if (is_null($root['left'])) {
            return null;
        }

        return search($searchValue, $root['left']);
    }
}