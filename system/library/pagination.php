<?php
class Pagination {
    public $total = 0;
    public $page = 1;
    public $limit = 20;
    public $num_links = 8;
    public $url = '';
    public $text_first = '|&lt;';
    public $text_last = '&gt;|';
    public $text_next = '&gt;';
    public $text_prev = '&lt;';
    
    public function render() {
        $total = $this->total;
        
        if ($this->page < 1) {
            $page = 1;
        } else {
            $page = $this->page;
        }
        
        if (!(int)$this->limit) {
            $limit = 10;
        } else {
            $limit = $this->limit;
        }
        
        $num_links = $this->num_links;
        $num_pages = ceil($total / $limit);
        
        $this->url = str_replace('%7Bpage%7D', '{page}', $this->url);
        
        $output = '<ul class="pagination">';
        
        if ($page > 1) {
            $output .= '<li><a href="' . str_replace(array('&amp;page={page}', '?page={page}', '&page={page}'), '', $this->url) . '">' . $this->text_first . '</a></li>';
            
            if ($page - 1 === 1) {
                $output .= '<li><a href="' . str_replace(array('&amp;page={page}', '?page={page}', '&page={page}'), '', $this->url) . '">' . $this->text_prev . '</a></li>';
            } else {
                $output .= '<li><a href="' . str_replace('{page}', $page - 1, $this->url) . '">' . $this->text_prev . '</a></li>';
            }
        }
        
        if ($num_pages > 1) {
            if ($num_pages <= $num_links) {
                $start = 1;
                $end = $num_pages;
            } else {
                $start = $page - floor($num_links / 2);
                $end = $page + floor($num_links / 2);
                
                if ($start < 1) {
                    $end += abs($start) + 1;
                    $start = 1;
                }
                
                if ($end > $num_pages) {
                    $start -= ($end - $num_pages);
                    $end = $num_pages;
                }
            }
            
            for ($i = $start; $i <= $end; $i++) {
                if ($page == $i) {
                    $output .= '<li class="active"><span>' . $i . '</span></li>';
                } else {
                    if ($i === 1) {
                        $output .= '<li><a href="' . str_replace(array('&amp;page={page}', '?page={page}', '&page={page}'), '', $this->url) . '">' . $i . '</a></li>';
                    } else {
                        $output .= '<li><a href="' . str_replace('{page}', $i, $this->url) . '">' . $i . '</a></li>';
                    }
                }
            }
        }
        
        if ($page < $num_pages) {
            $output .= '<li><a href="' . str_replace('{page}', $page + 1, $this->url) . '">' . $this->text_next . '</a></li>';
            $output .= '<li><a href="' . str_replace('{page}', $num_pages, $this->url) . '">' . $this->text_last . '</a></li>';
        }
        
        $output .= '</ul>';
        
        if ($num_pages > 1) {
            return $output;
        } else {
            return '';
        }
    }
    
    public function renderFront() {
        $total = $this->total;
        
        if ($this->page < 1) {
            $page = 1;
        } else {
            $page = $this->page;
        }
        
        if (!(int)$this->limit) {
            $limit = 10;
        } else {
            $limit = $this->limit;
        }
        
        $num_links = $this->num_links;
        $num_pages = ceil($total / $limit);
        
        $this->url = str_replace('%7Bpage%7D', '{page}', $this->url);
        
        $pageCutLow = $page - 1;
        $pageCutHigh = $page + 1;
        
        $output = '<ul>';
        
        if ($page > 1) {
            $output .= '<li class="page-item previous no"><a href="' . str_replace('{page}', $page - 1, $this->url) . '"><i class="fas fa-chevron-left"></i></a></li>';
        }
        
        if ($num_pages < 6) {
            for ($p = 1; $p <= $num_pages; $p++) {
                $active = $page == $p ? 'active' : 'no';
                $output .= '<li class="'. $active . '"><a href="' . str_replace('{page}', $p, $this->url) . '">' . $p . '</a></li>';
            }
        } else {
            if ($page > 2) {
                $output .= '<li class="no page-item"><a href="' . str_replace('{page}', 1, $this->url) . '">1</a></li>';
                if ($page > 3) {
                    $output .= '<li class="out-of-range" style="cursor: default">...</li>';
                }
            }
            if ($page == 1) {
                $pageCutHigh += 2;
            } elseif ($page == 2) {
                $pageCutHigh += 1;
            }
            
            if ($page == $num_pages) {
                $pageCutLow -= 2;
            } elseif ($page == $num_pages - 1) {
                $pageCutLow -= 1;
            }
            
            for ($p = $pageCutLow; $p <= $pageCutHigh; $p++) {
                if ($p == 0) {
                    $p += 1;
                }
                if ($p > $num_pages) {
                    continue;
                }
                $active = $page == $p ? 'active' : 'no';
                $output .= '<li class="'. $active . '"><a href="' . str_replace('{page}', $p, $this->url) . '">' . $p . '</a></li>';
            }
            
            if ($page < $num_pages - 1) {
                if ($page < $num_pages - 2) {
                    $output .= '<li class="out-of-range" style="cursor: default">...</li>';
                }
                $output .= '<li class="page-item no"><a href="' . str_replace('{page}', $num_pages, $this->url) . '">' . $num_pages . '</a></li>';
            }
        }
        
        if ($page < $num_pages) {
            $output .= '<li class="page-item next no"><a href="' . str_replace('{page}', $page + 1, $this->url) . '"><i class="fas fa-chevron-right"></i></a></li>';
        }
        
        $output .= '</ul>';
        
        if ($num_pages > 1) {
            return $output;
        } else {
            return '';
        }
    }
    
    public function renderSmall ($text) {
        $total = $this->total;
        
        if ($this->page < 1) {
            $page = 1;
        } else {
            $page = $this->page;
        }
        
        if (!(int)$this->limit) {
            $limit = 10;
        } else {
            $limit = $this->limit;
        }
        
        $num_pages = ceil($total / $limit);
        
        $this->url = str_replace('%7Bpage%7D', '{page}', $this->url);
        
        $output = '';
        
        if ($page > 1) {
            $output .= '<a href="' . str_replace('{page}', $page - 1, $this->url) . '" class="paginate left"><i class="fas fa-chevron-left"></i></a>';
        } else {
            $output .= '<a disabled="disabled" class="paginate left"><i class="fas fa-chevron-left"></i></a>';
        }
        $output .= '<div class="counter">' . $text . '</div>';
        if ($page < $num_pages) {
            $output .= '<a href="' . str_replace('{page}', $page + 1, $this->url) . '" class="paginate right"><i class="fas fa-chevron-right"></i></a>';
        } else {
            $output .= '<a disabled="disabled" class="paginate right"><i class="fas fa-chevron-right"></i></a>';
        }
        
        if ($num_pages > 1) {
            return $output;
        } else {
            return '';
        }
    }
}