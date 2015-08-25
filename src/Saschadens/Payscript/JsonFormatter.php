<?php
namespace Saschadens\Payscript;

use Saschadens\Payscript\Collection\PayDate as PayDateCollection;

class JsonFormatter implements Formatter
{
    public function output(PayDateCollection $collection)
    {
        $arr = [];
        foreach ($collection as $model) {
            $arr[] = array(
                'bonusDate' => $model->getBonusDate(),
                'salaryDate' => $model->getSalaryDate(),
            );
        }
        return json_encode($arr);
    }
}
