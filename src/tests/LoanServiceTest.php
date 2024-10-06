<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/Domain/Entities/Loan.php';
require_once __DIR__ . '/../src/Domain/Repositories/LoanRepositoryInterface.php';
require_once __DIR__ . '/../src/Domain/Service/LoanService.php';

class LoanServiceTest extends TestCase
{
    public function testSaveLoanSuccessfully()
    {
        $book = new Book(1, 'Test Book', 'Test Author', '1234567890');
        $loan = new Loan(1, $book, 'Test Borrower', '2024-10-01');
        
        $repository = $this->createMock(LoanRepositoryInterface::class);
        
        $repository->expects($this->once())
                   ->method('save')
                   ->with($loan)
                   ->willReturn(true);
        
        $service = new LoanService($repository);
        $this->assertTrue($service->save($loan));
    }
}
