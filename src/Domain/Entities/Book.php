<?php

// namespace Domain\Entities;

class Book
{
    private $id;
    private $title;
    private $author;
    private $isbn;

    public function __construct($id, $title, $author, $isbn) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->isbn = $isbn;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setIsbn($isbn) {
        $this->isbn = $isbn;
    }

    public function getIsbn() {
        return $this->isbn;
    }
}
