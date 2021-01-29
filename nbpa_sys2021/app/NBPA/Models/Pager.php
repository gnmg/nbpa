<?php

/**
 * Pager.
 *
 * @version SVN: $Id: Pager.php 113 2015-05-20 08:23:04Z morita $
 */
namespace NBPA\Models;

class Pager
{
    public $path;
    public $limit;
    public $count;
    public $page;

    /**
     * コンストラクタ
     */
    public function __construct($path, $limit, $count = 0, $page = 0)
    {
        $this->path  = $path;
        $this->limit = $limit;
        $this->count = $count;
        $this->page  = $page;
    }

    public function hasPrev()
    {
        return ($this->page > 0);
    }

    public function hasNext()
    {
        $maxPage = floor(($this->count - 1) / $this->limit);

        return ($this->page < $maxPage);
    }

    public function from()
    {
        return $this->limit * $this->page + 1;
    }

    public function to()
    {
        return min($this->count, $this->limit * ($this->page + 1));
    }

    public function prevPath()
    {
        $prevPage = $this->page - 1;
        if (strpos($this->path, '?') !== false) {
            return "{$this->path}&page={$prevPage}";
        } else {
            return "{$this->path}?page={$prevPage}";
        }
    }

    public function nextPath()
    {
        $nextPage = $this->page + 1;
        if (strpos($this->path, '?') !== false) {
            return "{$this->path}&page={$nextPage}";
        } else {
            return "{$this->path}?page={$nextPage}";
        }
    }

    public function getPath()
    {
        if (strpos($this->path, '?') !== false) {
            return "{$this->path}&page=";
        } else {
            return "{$this->path}?page=";
        }
    }
}
