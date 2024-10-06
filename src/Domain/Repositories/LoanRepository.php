<?php

class LoanRepository implements LoanRepositoryInterface {
    private $loans = [];

    public function save(Loan $loan) {
        $this->loans[] = $loan;
        return true;
    }

    public function findAll() {
        return $this->loans;
    }

    public function delete($id) {
        foreach ($this->loans as $key => $loan) {
            if ($loan->getId() == $id) {
                unset($this->loans[$key]);
                return true;
            }
        }
        return false;
    }
}
