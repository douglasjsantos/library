<?php

interface LoanRepositoryInterface {
    public function save(Loan $loan);
    public function findAll();
    public function delete($id);
}
