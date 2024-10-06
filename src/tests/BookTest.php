<?php
// use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/Domain/Entities/Book.php';

class BookTest extends TestCase
{
    public function testBookProperties()
    {
        $book = new Book(1, 'Test Book', 'Test Author', '1234567890');
        
        $this->assertEquals(1, $book->getId());
        $this->assertEquals('Test Book', $book->getTitle());
        $this->assertEquals('Test Author', $book->getAuthor());
        $this->assertEquals('1234567890', $book->getIsbn());
    }
    
    public function testSetBookProperties()
    {
        $book = new Book(1, 'Old Title', 'Old Author', '0987654321');
        
        $book->setTitle('New Title');
        $book->setAuthor('New Author');
        $book->setIsbn('1111111111');
        
        $this->assertEquals('New Title', $book->getTitle());
        $this->assertEquals('New Author', $book->getAuthor());
        $this->assertEquals('1111111111', $book->getIsbn());
    }
}
