<?php

class LoanService {
    private $repository;

    public function __construct(LoanRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function save(Loan $loan) {
        return $this->repository->save($loan);
    }

    public function findAll() {
        return $this->repository->findAll();
    }

    public function delete($id) {
        return $this->repository->delete($id);
    }
}
