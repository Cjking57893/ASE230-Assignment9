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
$filePath = __DIR__ . '/../../data/teamCRUD.json'
$filePath = __DIR__ . '/../../data/contactCRUD.json'


readAll()

<?php if (empty($productsAndServices)): ?>
                    <tr>
                        <td colspan="4" class="text-center">No products available.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($productsAndServices as $index => $product): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($product['name']); ?></td>
                        <td><?= htmlspecialchars($product['description']); ?></td>
                        <td>
                            <a href="detail.php?name=<?= urlencode($product['name']); ?>" class="btn btn-info btn-sm">View</a>
                            <a href="edit.php?name=<?= urlencode($product['name']); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?name=<?= urlencode($product['name']); ?>" class="btn btn-danger btn-sm" 
                               onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>


                ?>