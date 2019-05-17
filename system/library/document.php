<?php
class Document {
    private $title;
    private $description;
    private $keywords;
    private $links = array();
    private $styles = array();
    private $scripts = array();
    private $og_image;
    private $og_type;
    
    private $isOnProductPage = false;
    
    private $breadcrumbs;
    
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function setKeywords($keywords) {
        $this->keywords = $keywords;
    }
    
    public function getKeywords() {
        return $this->keywords;
    }
    
    public function addLink($href, $rel) {
        $this->links[$href] = array(
            'href' => $href,
            'rel'  => $rel
        );
    }
    
    public function getLinks() {
        return $this->links;
    }
    
    public function addStyle($href, $rel = 'stylesheet', $media = 'screen') {
        $this->styles[$href] = array(
            'href'  => $href,
            'rel'   => $rel,
            'media' => $media
        );
    }
    
    public function getStyles() {
        return $this->styles;
    }
    
    public function addScript($href, $postion = 'header') {
        $this->scripts[$postion][$href] = $href;
    }
    
    public function getScripts($postion = 'header') {
        if (isset($this->scripts[$postion])) {
            return $this->scripts[$postion];
        } else {
            return array();
        }
    }
    
    public function setOgImage($image) {
        $this->og_image = $image;
    }
    
    public function getOgImage() {
        return $this->og_image;
    }
    
    public function setOgType($og_type) {
        $this->og_type = $og_type;
    }
    
    public function getOgType() {
        return $this->og_type;
    }
    
    public function renderBreadcrumbs($breadcrumbs) {
        $breadcrumbs_renderer = new Breadcrumbs();
        return $breadcrumbs_renderer->render($breadcrumbs);
    }
    
    public function setBreadcrumbs($breadcrumbs) {
        $this->breadcrumbs = $this->renderBreadcrumbs($this->filterBreadcrumbs($breadcrumbs));
    }
    
    public function getBreadcrumbs() {
        return $this->breadcrumbs;
    }
    
    private function filterBreadcrumbs($breadcrumbs) {
        foreach ($breadcrumbs as $key => $breadcrumb) {
            $safe_title = $this->getSafeTitle($breadcrumb['text']);
            $breadcrumbs[$key]['text'] = $safe_title;
        }
        return $breadcrumbs;
    }
    
    private function getSafeTitle($title) {
        $words = explode(' ', $title);
        if (is_array($words)) {
            foreach ($words as $key => $word) {
                $tmp = $word;
                $words[$key] = mb_strtolower($word);
                $first = mb_substr($tmp, 0, 1, 'utf-8');
                if (isset($tmp[1])) {
                    $second = mb_substr($tmp, 1, 1, 'utf-8');
                }
                
                if ((mb_strtoupper($first) == $first) && isset($second) && (mb_strtolower($second) == $second)) {
                    $words[$key] = $this->mb_ucfirst($words[$key]);
                }
            }
            $words[0] = $this->mb_ucfirst($words[0]);
            return implode(' ', $words);
        } else {
            return $this->mb_ucfirst(mb_strtolower($title));
        }
    }
    
    private function mb_ucfirst($text) {
        return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
    }
    
    public function setIsOnProductPage($isOnProductPage)
    {
        $this->isOnProductPage = $isOnProductPage;
    }
    public function getIsOnProductPage()
    {
        return $this->isOnProductPage;
    }
    
}
