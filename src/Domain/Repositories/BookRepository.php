<?php

require_once __DIR__ . '/BookRepositoryInterface.php';

/**
 * Class BookRepository
 *
 * Implements the BookRepositoryInterface for managing books in a SQLite database.
 *
 * @package Domain\Repositories
 */
class BookRepository implements BookRepositoryInterface
{
    private $pdo;

    /**
     * BookRepository constructor.
     *
     * Initializes a new PDO instance and creates the book table if it doesn't exist.
     */
    public function __construct()
    {
        try {
            $this->pdo = new PDO('sqlite:book.db');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->createTableIfNotExists();
        } catch (PDOException $e) {
            echo 'Error connecting to the database or creating table: ' . $e->getMessage();
            exit();
        }
    }

    /**
     * Creates the book table if it does not exist.
     */
    private function createTableIfNotExists()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS book (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                author TEXT NOT NULL,
                isbn TEXT UNIQUE NOT NULL
            )
        ";
        $this->pdo->exec($sql);
    }

    /**
     * Retrieves all books from the database.
     *
     * @return Book[] Array of Book objects.
     */
    public function findAll()
    {
        $stmt = $this->pdo->query('SELECT * FROM book ORDER BY id DESC');
        $books = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $books[] = new Book($row['id'], $row['title'], $row['author'], $row['isbn']);
        }
        return $books;
    }

    /**
     * Saves a book to the database.
     *
     * @param Book $book The book to save.
     * @return bool True on success, false on failure.
     */
    public function save(Book $book)
    {
        try {
            if ($book->getId()) {
                // Update existing book
                $stmt = $this->pdo->prepare('UPDATE book SET title = :title, author = :author, isbn = :isbn WHERE id = :id');
                $stmt->execute([
                    'id' => $book->getId(),
                    'title' => $book->getTitle(),
                    'author' => $book->getAuthor(),
                    'isbn' => $book->getIsbn()
                ]);
            } else {
                // Insert new book
                $stmt = $this->pdo->prepare('INSERT INTO book (title, author, isbn) VALUES (:title, :author, :isbn)');
                $stmt->execute([
                    'title' => $book->getTitle(),
                    'author' => $book->getAuthor(),
                    'isbn' => $book->getIsbn()
                ]);
                $book->setId($this->pdo->lastInsertId());
            }
            return true;
        } catch (PDOException $e) {
            echo 'Error saving book: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Deletes a book from the database by ID.
     *
     * @param int $id The ID of the book to delete.
     * @return bool True on success, false on failure.
     */
    public function delete($id)
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM book WHERE id = :id');
            $stmt->execute(['id' => $id]);
            return true;
        } catch (PDOException $e) {
            echo 'Error deleting book: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Finds a book by its ISBN.
     *
     * @param string $isbn The ISBN of the book to find.
     * @return Book|null The found Book object or null if not found.
     */
    public function findByIsbn($isbn): ?Book
    {
        $stmt = $this->pdo->prepare('SELECT * FROM book WHERE isbn = :isbn');
        $stmt->execute(['isbn' => $isbn]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Book(
                $row['id'],
                $row['title'],
                $row['author'],
                $row['isbn']
            );
        }

        return null;
    }
}
