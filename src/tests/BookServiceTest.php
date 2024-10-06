<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../Domain/Entities/Book.php';
require_once __DIR__ . '/../src/Domain/Repositories/BookRepositoryInterface.php';
require_once __DIR__ . '/../src/Domain/Service/BookService.php';


class BookServiceTest extends TestCase
{
    public function testSaveBookSuccessfully()
    {
        $book = new Book(null, 'Test Book', 'Test Author', '1234567890');
        
        $repository = $this->createMock(BookRepositoryInterface::class);
        
        $repository->expects($this->once())
                   ->method('save')
                   ->with($book)
                   ->willReturn(true);
        
        $service = new BookService($repository);
        $this->assertTrue($service->save($book));
    }

    public function testDeleteBookSuccessfully()
    {
        $repository = $this->createMock(BookRepositoryInterface::class);
        
        $book = new Book(1, 'Test Book', 'Test Author', '1234567890');
        
        $repository->method('findAll')->willReturn([$book]);

        $repository->expects($this->once())->method('delete')->with(1)->willReturn(true);

        $service = new BookService($repository);
        $this->assertTrue($service->delete(1));
    }
}
