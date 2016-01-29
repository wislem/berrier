<?php

function renderTreeToOptions($tree) {
    $array = [];
    foreach($tree as $option) {
        $name = '';
        for($i = 1; $i < $option->depth; $i++) {
            $name .= '&nbsp;&nbsp;&nbsp;&nbsp;';
        }
        $name .= '-';
        $array[$option->id] = $name . ' ' . $option->name;
    }

    return $array;
}

function renderMmenuTreeList($tree, $selected = 0) {
    $html = '';
    foreach($tree as $branch) {
        if($selected == $branch->id) {
            $html .= '<li data-id="' . $branch->id . '" class="mm-selected"><a href="#">';
        }else {
            $html .= '<li data-id="' . $branch->id . '"><a href="#">';
        }
        $html .= $branch->name;
        $html .= '</a>';
        if(count($branch->children)) {
            $html .= '<ul>';
            $html .= renderMmenuTreeList($branch->children, $selected);
            $html .= '</ul>';
        }
        $html .= '</li>';
    }

    return $html;
}

function renderTreeList($tree, $selected = []) {
    $html = '';
    foreach($tree as $branch) {
        if(in_array($branch->id, $selected)) {
            $html .= '<li id="'.$branch->id.'" data-id="'.$branch->id.'" class="jstree-checked">';
        }else {
            $html .= '<li id="'.$branch->id.'" data-id="'.$branch->id.'">';
        }
        $html .= $branch->name;
        if(count($branch->children)) {
            $html .= '<ul>';
            $html .= renderTreeList($branch->children, $selected);
            $html .= '</ul>';
        }
        $html .= '</li>';
    }

    return $html;
}

function search($array, $key, $value)
{
    $results = array();

    if (is_array($array))
    {
        if (isset($array[$key]) && $array[$key] == $value)
            $results[] = $array;

        foreach ($array as $subarray)
            $results = array_merge($results, search($subarray, $key, $value));
    }

    return $results;
}

/**
 * Renders a category with its children into a nestable drag n drop menu
 */
function showNestedCategories($tree)
{
    $output = '';

    foreach($tree as $branch) {
        $output .= '<li class="dd-item" data-id="Category:'.$branch->id.'">'.PHP_EOL;
        $output .= '<div class="dd-handle"><i class="fa fa-folder fa-fw"></i> '.$branch->name.'</div>'.PHP_EOL;
        if(count($branch->children)) {
            $output .= '<ol class="dd-list">'.PHP_EOL;
            $output .= showNestedCategories($branch->children);
            $output .= '</ol>';
        }
        $output .= '</li>';
    }

    return $output;
}


/**
 * Shows a nestable drag n drop menu based on menuitems json from db
 */
function showNestableMenu($menuitems, $depth = 0)
{
    $output = '';

    if(!$menuitems) {
        if($depth == 0)
            return '<div class="dd-empty"></div>';
        else
            return '';
    }

    $output .= '<ol class="dd-list">';

    foreach($menuitems as $item) {
        if(is_object($item)) {
            $output .= '<li class="dd-item" data-id="'.$item->id.'">'.PHP_EOL;
            if(strstr($item->id, 'Page:')) {
                $output .= '<div class="dd-handle"><i class="fa fa-file-text fa-fw"></i> '.$item->title.'</div>'.PHP_EOL;
            }elseif(strstr($item->id, 'Category:')) {
                $output .= '<div class="dd-handle"><i class="fa fa-folder fa-fw"></i> '.$item->title.'</div>'.PHP_EOL;
            }elseif(strstr($item->id, 'Url:')) {
                $output .= '<div class="dd-handle"><i class="fa fa-external-link-square fa-fw"></i> '.$item->title.'</div>'.PHP_EOL;
            }

            if(isset($item->children)) {
                $output .= showNestableMenu($item->children, ($depth+1));
            }

            $output .= '</li>';
        }
    }

    $output .= '</ol>';

    return $output;
}

function beautifyMenuitems($menuitems) {
    if(!$menuitems) {
        return array();
    }

    foreach($menuitems as $item) {
        $split = explode(':', $item->id);
        $item->title = '';

        switch($split[0]) {
            case 'Page':
                $item->title = \Wislem\Berrier\Models\Page::where('id', '=', $split[1])->first()->title;
                break;
            case 'Category':
                $item->title = \Wislem\Berrier\Models\Category::where('id', '=', $split[1])->first()->name;
                break;
            case 'Url':
                $url_attributes = explode('|', $split[1].$split[2]);
                $item->title = $url_attributes[1];
                break;
            default:
                break;
        }

        if(isset($item->children)) {
            $item->children = beautifyMenuitems($item->children);
        }
    }

    return $menuitems;
}