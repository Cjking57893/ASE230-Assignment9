<?php

function addItem($filename, $newItem) {

    // Checking if file exists and reading it if it does.
    if (file_exists($filename)) {
        $jsonContent = file_get_contents($filename);
        $data = json_decode($jsonContent, true);
    }
    else {
        die('Error: Could not read the JSON file');
    }

    // Adding new item to array.
    $data[] = $newItem;

    // Encoding the array back into JSON format.
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);

    // Writing the updated JSON back in the file.
    file_put_contents($filename, $jsonData);
}

function updateItem($filename, $oldItem, $newItem) {

    // Checking if file exists and reading it if it does.
    if (file_exists($filename)) {
        $jsonContent = file_get_contents($filename);
        $data = json_decode($jsonContent, true);
    }
    else {
        die('Error: Could not read the JSON file');
    }

    $itemFound = false;
    foreach($data as $key => $item) {
        if ($item === $oldItem) {
            $data[$key] = $newItem;
            $itemFound = true;
            break;
        }
    }

    if ($itemFound) {
        die('Error: Item not found');
    }

    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filename, $jsonData);
}