<?php
namespace Wislem\Berrier\Http\Controllers\Modules\Widgets\Facades;



class Widget
{
    public static function render($page, $position = '')
    {
        $page = (!$page) ? 'null' : $page;

        if(Cache::tags('widgets')->has($page . '-' . $position)) {
            $merged = Cache::tags('widgets')->get($page . '-' . $position);
        }else {
            if ($page == 'null') {
                $merged = Widget::select('id', 'title', 'content', 'path')->active()->global()->wherePosition($position)->orderBy('ordr', 'ASC')->get();
            } else {
                $global = Widget::select('id', 'title', 'content', 'path')->active()->global()->wherePosition($position)->orderBy('ordr', 'ASC')->get();
                $specific = $page->widgets()->select('id', 'title', 'content', 'path')->local()->wherePosition($position)->orderBy('ordr', 'ASC')->get();

                $merged = $global->merge($specific);
            }

            $merged->sortBy('ordr');

            Cache::tags('widgets')->forever($page . '-' . $position, $merged);
        }

        foreach($merged as $widget) {
            if($widget->path) {
                if(\View::exists($widget->path)) {
                    echo view($widget->path);
                }
            }else {
                echo str_replace('{{url}}', Request::url(), $widget->content);
            }
        }
    }

    public static function extract_unit($string, $start, $end)
    {
        $regexp = '/'.$start.'(.*)'.$end.'/Ui';
        preg_match_all($regexp, $string, $out, PREG_PATTERN_ORDER);

        $unit = $out[1];

        foreach($unit as $widget) {
            $split = explode(':', $widget);
            $db_widget = \Wislem\Berrier\Models\Widget::find($split[1]);
            if($db_widget) {
                if ($db_widget->path) {
                    if (\View::exists($db_widget->path)) {
                        $result[$widget] = view($db_widget->path);
                    }
                } else {
                    $result[$widget] = str_replace('{{url}}', \Request::url(), $db_widget->content);
                }
            }else {
                $result[$widget] = '';
            }
        }

        return $result;
    }
}