<?php
function nodeTree($arr, $id = 0, $level = 0) {
    static $array = array();
    foreach ($arr as $v) {
        if ($v['parentid'] == $id) {
            $v['level'] = $level;
            $array[] = $v;
            nodeTree($arr, $v['id'], $level + 1);
        }
    }
    return $array;
}