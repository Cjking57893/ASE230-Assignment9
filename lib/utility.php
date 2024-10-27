<?php
// <!-- create($entity):

// Adds a new entity (a contact or team member) to the JSON file.
// It reads the existing data, adds the new entity to the array, and writes the updated data back to the file.

// readAll():

// Reads all entities from the JSON file and returns them as an array.
// If the file doesn’t exist, it returns an empty array.

// update($updatedEntity, $id):

// Finds an entity by its ID in the JSON data, updates it with the new information, and saves the changes back to the file.

// delete($id):

// Removes an entity from the JSON file based on its ID.
// It filters the array to exclude the specified entity and then writes the filtered data back to the file. -->

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