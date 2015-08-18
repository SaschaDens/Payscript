<?php
namespace Saschadens\Payscript;

use DateTime;
use DateInterval;
use Saschadens\Payscript\Collection\PayDate as PayDateCollection;
use Saschadens\Payscript\Model\PayDate as PayDateModel;
use Saschadens\Payscript\Formatter as FormatterInterface;

class Sales
{

    private function daysInWeekend(DateTime $dt)
    {
        $daysLeft = 0;
        if (($dt->format('N') - 5) > 0) {
            $daysLeft = ($dt->format('N') - 5);
        }

        return $daysLeft;
    }

    public function getMonthlySalaryDate(DateTime $dt)
    {
        $dt->modify('last day of this month');
        $dt->setTime(0, 0, 0);

        if ($this->daysInWeekend($dt) != 0) {
            $daysToSubstract = new DateInterval('P' . $this->daysInWeekend($dt) . 'D');
            $dt->sub($daysToSubstract);
        }

        return $dt;
    }

    public function getMonthlyBonusDate(DateTime $dt)
    {
        $interval = new DateInterval('P14D');

        $dt->modify('first day of this month');
        $dt->setTime(0, 0, 0);
        $dt->add($interval);

        if ($this->daysInWeekend($dt) != 0) {
            $daysTillWednesday = 3;

            if ($this->daysInWeekend($dt) == 1) {
                $daysTillWednesday += 1;
            }
            $dayInterval = new DateInterval('P' . $daysTillWednesday . 'D');
            $dt->add($dayInterval);
        }

        return $dt;
    }

    public function getPaydateModelForMonth($month)
    {
        $year = date('Y');

        $salaryDate = new DateTime();
        $salaryDate->setDate($year, $month, 1);

        $bonusDate = new DateTime();
        $bonusDate->setDate($year, $month, 1);

        $model = new PayDateModel;
        $model->setSalaryDate($this->getMonthlySalaryDate($salaryDate));
        $model->setBonusDate($this->getMonthlyBonusDate($bonusDate));

        return $model;
    }

    public function getPayDateCollectionRemainingMonths($startMonth = 1)
    {
        $collection = new PayDateCollection;

        for ($i = $startMonth; $i <= 12; $i++) {
            $model = $this->getPaydateModelForMonth($i);
            $collection->offsetSet($i, $model);
        }

        return $collection;
    }

    public function format(FormatterInterface $formatter)
    {
        $currentMonth = date('m');
        $collection = $this->getPayDateCollectionRemainingMonths($currentMonth);

        return $formatter->output($collection);
    }
}
