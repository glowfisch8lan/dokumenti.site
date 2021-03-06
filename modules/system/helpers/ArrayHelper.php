<?php


namespace app\modules\system\helpers;


class ArrayHelper extends \yii\helpers\ArrayHelper
{

    /**
     *  Перестройка индексного массива к  массиву вида
     * [
     *      [ $key, $value ],
     *      [ $key, $value ],
     * ];
     *
     * @param $array
     * @param $key
     * @return array
     */
    public static function indexMap($array,$key){

        $dataArray = [];
        foreach($array as $value) {
            $dataArray[] = [(int) $key, (int) $value];
        }

        return $dataArray;
    }

    /**
     * Перестройка массива к  массиву вида
     * [
     *      [ $key => $value1 . $value2 . $valueN ]
     * ];
     *
     * @param $array
     * @param $mainKey
     * @param $mergeKeys
     * @param null $separator
     * @return array
     */
    public static function mapMerge($array, $mainKey, $mergeKeys, $separator = null){

        $rows = [];
        foreach($array as $value){

            $string = null;
            foreach($mergeKeys as $key) {
                $string .= (string) $value[$key] . $separator;
            }
            $rows[$value[$mainKey]] = $string;
        }

        return $rows;
    }

    /**
     * Рекурсивный поиск в массиве
     *
     * @return array | keys
     */
    public static function recursiveArraySearch($needle, $haystack)
    {

        $arr = null;
        foreach ($haystack as $key => $value)
        {
            $current_key = $key;
            if (array_search($needle, $value, true))
                $arr[] = $current_key;

        }

        return $arr;
    }

    /**
     * Получить данные из массива по ID
     *
     * [
     *  [
     *    'id' => 1,
     *    'name' => 'name1'
     *  ],
     *  [
     *    'id' => 2,
     *    'name' => 'name2'
     *  ],
     *  ...
     *  [
     *    'id' => N,
     *    'name' => 'nameN'
     *  ],
     * ]
     *
     * @param $id
     * @return mixed
     */
    public static function getDataById($array, $id)
    {

        foreach ($array as $key => $value)
        {
            $current_key = $key;
            if (array_search($id, $value, true))
                $arr[] = $current_key;

        }

        return $array[self::recursiveArraySearch($id,$array)[0]];
    }


    /**
     * Рекурсивный поиск в массиве
     *
     * @return array | keys
     */
    public static function ArrayValueFilter($array, $key, $value)
    {

        $arr = null;
        foreach($array as $k => $v){
            if($v[$key] == $value){
                $arr[] = $v;
            }
        }

        return $arr;

    }
}