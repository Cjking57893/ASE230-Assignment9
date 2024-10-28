<?php
class JSONHelper
{
    public static function readAll($filePath)
    {
        if (!file_exists($filePath)) {
            self::saveAll($filePath, []);
        }

        $jsonContent = file_get_contents($filePath);
        return json_decode($jsonContent, true) ?? [];
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

