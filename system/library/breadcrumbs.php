<?php class Breadcrumbs
{
    public static function render($breadcrumbs){
        $html = '<div class="breadCrumbs">';
        $html .= '<ul class="breadCrumbs__block">';
        $qty = count($breadcrumbs);
        $rel = '';
        foreach ($breadcrumbs as $key => $breadcrumb) {
            if ($key + 1 === $qty) $rel = 'rel="nofollow"';
            $html .= ' <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" class="breadCrumbs__list">';
            $html .= '<a ' . $rel . ' itemprop="url" href="' . $breadcrumb["href"]  . '" class="breadCrumbs__item">';
            $html .= '<span itemprop="title">';
            $html .= $breadcrumb['text'];
            $html .= '</span> ';
            $html .= '</a>';
            $html .='<meta itemprop="position" content="'.($key+1).'"/>';
            $html .= '</li>';
        }
        $html .= '</ul>';
        $html .= '</div>';
        return $html;
    }
}