<?php
require_once __DIR__ . '/../src/Domain/Entities/Book.php';
require_once __DIR__ . '/../src/Domain/Repositories/BookRepository.php';
require_once __DIR__ . '/../src/Domain/Service/BookService.php';
require_once __DIR__ . '/../src/Domain/Repositories/BookRepositoryInterface.php';

$repository = new BookRepository();
$service = new BookService($repository);

$messages = [];
$books = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addBook'])) {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $isbn = $_POST['isbn'] ?? '';

    try {
        $newBook = new Book(null, $title, $author, $isbn);
        if ($service->save($newBook)) {
            $messages[] = "Book saved successfully: " . $newBook->getTitle();
        } else {
            $messages[] = "Error saving the book.";
        }
    } catch (Exception $e) {
        $messages[] = "Error: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteBook'])) {
    $id = $_POST['id'] ?? '';

    try {
        if ($service->delete($id)) {
            $messages[] = "Book with ID $id removed successfully.";
        } else {
            $messages[] = "Error removing the book with ID $id.";
        }
    } catch (Exception $e) {
        $messages[] = "Error: " . $e->getMessage();
    }
}

try {
    $books = $service->findAll();
} catch (Exception $e) {
    $messages[] = "Error fetching books: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library of Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }

        h1, h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-width: 400px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
            color: #333;
        }

        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .form-container {
            display: flex;
            justify-content: space-between;
        }

        .form-box {
            width: 48%;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .form-container {
                flex-direction: column;
            }

            .form-box {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

    <h1>Library of Books</h1>

    <?php if (!empty($messages)): ?>
        <?php foreach ($messages as $message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="form-container">

        <div class="form-box">
            <h2>Add Book</h2>
            <form method="POST" action="">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required><br>

                <label for="author">Author:</label>
                <input type="text" id="author" name="author" required><br>

                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn" required><br>

                <button type="submit" name="addBook">Add Book</button>
            </form>
        </div>

        <div class="form-box">
            <h2>Remove Book by ID</h2>
            <form method="POST" action="">
                <label for="id">Book ID:</label>
                <input type="number" id="id" name="id" required><br>

                <button type="submit" name="deleteBook">Remove Book</button>
            </form>
        </div>
    </div>

    <div class="form-box">
        <h2>Loan Book</h2>
        <form method="POST" action="">
            <label for="bookId">Book ID:</label>
            <input type="number" id="bookId" name="bookId" required><br>

            <label for="userName">User Name:</label>
            <input type="text" id="userName" name="userName" required><br>

            <label for="dueDate">Due Date:</label>
            <input type="date" id="dueDate" name="dueDate" required><br>

            <button type="submit" name="loanBook">Loan Book</button>
        </form>
    </div>

    <?php if (!empty($loans)): ?>
        <h2>Active Loans:</h2>
        <table>
            <thead>
                <tr>
                    <th>Loan ID</th>
                    <th>Book ID</th>
                    <th>User Name</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loans as $loan): ?>
                    <tr>
                        <td><?= htmlspecialchars($loan->getId()) ?></td>
                        <td><?= htmlspecialchars($loan->getBookId()) ?></td>
                        <td><?= htmlspecialchars($loan->getUserName()) ?></td>
                        <td><?= htmlspecialchars($loan->getDueDate()) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No active loans.</p>
    <?php endif; ?>

    <?php if (!empty($books)): ?>
        <h2>Registered Books:</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>ISBN</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?= htmlspecialchars($book->getId()) ?></td>
                        <td><?= htmlspecialchars($book->getTitle()) ?></td>
                        <td><?= htmlspecialchars($book->getAuthor()) ?></td>
                        <td><?= htmlspecialchars($book->getIsbn()) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No registered books.</p>
    <?php endif; ?>

</body>
</html>
