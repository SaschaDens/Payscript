<?php
namespace Saschadens\Payscript;

use Saschadens\Payscript\Collection\PayDate as PayDateCollection;

class HtmlFormatter implements Formatter
{
    public function output(PayDateCollection $collection)
    {
        $s = '<table><thead><th>Salary</th><th>Bonus</th></thead>';
        foreach ($collection as $model) {
            $s .= '<tr>';
            $s .= '<td>' . $model->getSalaryDate()->format('d M Y') . '</td>';
            $s .= '<td>' . $model->getBonusDate()->format('d M Y') . '</td>';
            $s .= '</tr>';
        }
        return $s;
    }
}
