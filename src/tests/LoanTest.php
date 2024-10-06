<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/Domain/Entities/Loan.php';
require_once __DIR__ . '/../src/Domain/Entities/Book.php';

class LoanTest extends TestCase
{
    public function testLoanProperties()
    {
        $book = new Book(1, 'Test Book', 'Test Author', '1234567890');
        $loan = new Loan(1, $book, 'Test Borrower', '2024-10-01');

        $this->assertEquals(1, $loan->getId());
        $this->assertEquals($book, $loan->getBook());
        $this->assertEquals('Test Borrower', $loan->getBorrower());
        $this->assertEquals('2024-10-01', $loan->getStartDate());
    }
}
