<?php
require_once __DIR__ . '/../../lib/utility.php';

$teamFilePath = __DIR__ . '/../../data/teamCRUD.json';
$contactFilePath = __DIR__ . '/../../data/contactCRUD.json';

$selectedFile = isset($_POST['file']) ? $_POST['file'] : (isset($_GET['file']) ? $_GET['file'] : 'team');
$filePath = ($selectedFile === 'contact') ? $contactFilePath : $teamFilePath;

if (isset($_GET['delete'])) {
    $indexToDelete = (int)$_GET['delete'];
    JSONHelper::delete($filePath, $indexToDelete);

    header("Location: index.php?file=$selectedFile");
    exit;
}

$records = JSONHelper::readAll($filePath);

$tableHeaders = ($selectedFile === 'contact') 
    ? ['Name', 'Number', 'Email'] 
    : ['Name', 'Description'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View and Delete Records</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">View and Delete Records</h1>

    <form method="POST" class="mb-3">
        <div class="form-group">
            <label for="file">Select File:</label>
            <select name="file" id="file" class="form-control" onchange="this.form.submit()">
                <option value="team" <?= ($selectedFile === 'team') ? 'selected' : '' ?>>Team CRUD</option>
            </select>
        </div>
    </form>

    <div class="row justify-content-center">
        <a href="create.php" class="btn btn-primary mb-3">Create</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <?php foreach ($tableHeaders as $header): ?>
                    <th><?= htmlspecialchars($header); ?></th>
                <?php endforeach; ?>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($records)): ?>
                <tr>
                    <td colspan="<?= count($tableHeaders) + 2; ?>" class="text-center">No records available.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($records as $index => $record): ?>
                <tr>
                    <td><?= $index + 1; ?></td>
                    <?php if ($selectedFile === 'contact'): ?>
                        <td><?= htmlspecialchars($record['name']); ?></td>
                        <td><?= htmlspecialchars($record['number']); ?></td>
                        <td><?= htmlspecialchars($record['email']); ?></td>
                    <?php else: ?>
                        <td><?= htmlspecialchars($record['name']); ?></td>
                        <td><?= htmlspecialchars($record['about']); ?></td>
                    <?php endif; ?>
                    <td>
                        <a href="edit.php" class="btn btn-secondary btn-sm">Edit</a>
                        <a href="index.php?file=<?= $selectedFile ?>&delete=<?= $index; ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>