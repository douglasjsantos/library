<?php

class Loan {
    private $id;
    private $book;
    private $borrower;
    private $startDate;
    private $endDate;

    public function __construct($id = null, Book $book, $borrower, $startDate, $endDate = null) {
        $this->id = $id;
        $this->book = $book;
        $this->borrower = $borrower;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getId() {
        return $this->id;
    }

    public function getBook() {
        return $this->book;
    }

    public function getBorrower() {
        return $this->borrower;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
    }
}
