<?php
interface BookRepositoryInterface
{
    public function findAll();
    public function save(Book $book);
    public function delete($id);
    public function findByIsbn($isbn): ?Book; 

}

