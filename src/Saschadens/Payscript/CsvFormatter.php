<?php
namespace Saschadens\Payscript;

use Saschadens\Payscript\Collection\PayDate as PayDateCollection;

class CsvFormatter implements Formatter
{

    protected function _setHeaders()
    {
        header('Content-Type:text/csv');
    }

    public function output(PayDateCollection $collection)
    {
        $this->_setHeaders();

        $fp = fopen('php://output', 'w+');
        $header = ['Salary', 'Bonusdate'];
        fputcsv($fp, $header);
        foreach ($collection as $model) {
            $rule = [
                $model->getSalaryDate()->format('d M Y'),
                $model->getBonusDate()->format('d M Y'),
            ];

            fputcsv($fp, $rule);
        }
        fclose($fp);

        return true;
    }

}
