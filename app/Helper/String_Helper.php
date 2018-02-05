<?php
/**
 * Created by PhpStorm.
 * User: thinh
 * Date: 05/02/2018
 * Time: 13:52
 */

namespace App\Helper;

use Phpml\Association\Apriori;
use App\String_Search;


class String_Helper
{
    public static function Predict_String( $string )
    {
        $samples = [];
        $labels = [];

        $data = String_Search::String_Search_query();
        foreach($data as $field)
        {
            foreach($field as $column)
            {
                $samples[] = explode(' ', $column);
            }
        }

        $associator = new Apriori($support = 0, $confidence = 0);
        $associator->train($samples, $labels);
        $result = $associator->predict([$string]);

        return $result;
    }
}
