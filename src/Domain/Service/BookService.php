<?php

/**
 * Class BookService
 *
 * This class provides business logic for managing books, including
 * finding, saving, and deleting books from the repository.
 *
 * @package Domain\Service
 */
class BookService
{
    private $repository;

    /**
     * BookService constructor.
     *
     * @param BookRepositoryInterface $repository The book repository interface.
     */
    public function __construct(BookRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Finds a book by its ID.
     *
     * @param int $id The ID of the book to find.
     * @return Book|null The book object if found, null otherwise.
     */
    public function findById(int $id): ?Book
    {
        $books = $this->repository->findAll();
        foreach ($books as $book) {
            if ($book->getId() == $id) {
                return $book;
            }
        }
        return null;
    }

    /**
     * Retrieves all books from the repository.
     *
     * @return Book[] An array of Book objects.
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * Saves a book to the repository.
     *
     * @param Book $book The book to save.
     * @return bool True on success.
     * @throws Exception if the ISBN already exists for another book.
     */
    public function save(Book $book): bool
    {
        $existingBook = $this->repository->findByIsbn($book->getIsbn());
        if ($existingBook && $existingBook->getId() !== $book->getId()) {
            throw new Exception("ISBN already exists for another book.");
        }

        return $this->repository->save($book);
    }

    /**
     * Deletes a book by its ID.
     *
     * @param int $id The ID of the book to delete.
     * @return bool True on success.
     * @throws Exception if the book is not found.
     */
    public function delete(int $id): bool
    {
        $book = $this->findById($id);
        if (!$book) {
            throw new Exception("Book not found.");
        }

        return $this->repository->delete($id);
    }
}
