<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 02/02/2018
 * Time: 14:47
 */
namespace App\Http\Middleware;

use Phpml\Association\Apriori;

class Predict_String {
    public  static function Predict_String ( $string )
    {
        $samples = [];
        $labels = [];

        $row = 1;
        if (($handle = fopen("../resources/searchingData/file_String_Search_2018-01-31.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($row > 1) {
                    $samples[] = explode(' ', $data[1]);
                }
                $row++;
            }
            fclose($handle);
        }

        $associator = new Apriori($support = 0, $confidence = 0);
        $associator->train($samples, $labels);

        $result = $associator->predict([$string]);

        return $result;
    }
}
