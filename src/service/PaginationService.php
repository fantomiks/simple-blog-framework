<?php

namespace App\Service;

class PaginationService
{
    private int $currentPage;
    private int $recordsPerPage = 3;
    private int $showLinks = 10;
    private int $totalPages;

    public function __construct(int $page, int $totalRecords)
    {
        $this->currentPage = $page;
        $this->totalPages = (int) ($totalRecords / $this->recordsPerPage);
    }

    public function startPage(): int
    {
        $desiredPage = $this->currentPage - $this->showLinks;

        return max($desiredPage, 1);
    }

    public function endPage(): int
    {
        $desiredPage = $this->currentPage + $this->showLinks;

        return min($desiredPage, $this->totalPages);
    }

    public function needShowPrevButton(): bool
    {
        return $this->startPage() > 1;
    }

    public function needShowNextButton(): bool
    {
        return $this->endPage() < $this->totalPages;
    }

    public function getPrevPage(): int
    {
        return $this->startPage() - 1;
    }

    public function getNextPage(): int
    {
        return $this->endPage() + 1;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }
}
