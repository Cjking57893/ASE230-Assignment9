<?php
class JSONHelper
{
    public static function createItem($filename, $newItem) {

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
  
    public static function readAll($filePath)
    {
        if (!file_exists($filePath)) {
            self::saveAll($filePath, []);
        }

        $jsonContent = file_get_contents($filePath);
        return json_decode($jsonContent, true) ?? [];
    }
  
    public static function updateItem($filename, $oldItem, $newItem) {

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

    private static function saveAll($filePath, $data)
    {
        $directory = dirname($filePath);

        if (!is_dir($directory)) {
            if (!mkdir($directory, 0777, true)) {
                echo "Error: Unable to create directory $directory.";
                return;
            }
        }

        $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
        if (file_put_contents($filePath, $jsonContent) === false) {
            echo "Error: Unable to write to file $filePath.";
        }
    }

    public static function delete($filePath, $index)
    {
        $data = self::readAll($filePath);

        if (isset($data[$index])) {
            unset($data[$index]);
            $data = array_values($data); 
            self::saveAll($filePath, $data);
        }
    }
}