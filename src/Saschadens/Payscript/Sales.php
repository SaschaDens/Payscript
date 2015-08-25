<?php
namespace Saschadens\Payscript;

use DateTime;
use DateInterval;
use Saschadens\Payscript\Collection\PayDate as PayDateCollection;
use Saschadens\Payscript\Model\PayDate as PayDateModel;
use Saschadens\Payscript\Formatter as FormatterInterface;

class Sales
{

    /**
     * @param DateTime $dt
     *
     * @return bool
     */
    private function isSunday(DateTime $dt)
    {
        return $dt->format('N') == 7;
    }

    /**
     * @param DateTime $dt
     *
     * @return bool
     */
    private function isWeekend(DateTime $dt)
    {
        return $dt->format('N') >= 6;
    }

    public function getMonthlySalaryDate(DateTime $dt)
    {
        $dt->modify('last day of this month');
        $dt->setTime(0, 0, 0);

        if ($this->isWeekend($dt)) {
            $setFriday = 'Friday this week';

            if ($this->isSunday($dt)) {
                // Workaround for bug http://php.net/manual/en/datetime.formats.relative.php#108317
                $setFriday = 'Friday previous week';
            }

            $dt->modify($setFriday);
        }

        return $dt;
    }

    public function getMonthlyBonusDate(DateTime $dt)
    {
        $dt->modify('first day of this month');
        $dt->setTime(0, 0, 0);
        $dt->add(new DateInterval('P14D'));

        if ($this->isWeekend($dt)) {
            $setWednesday = 'Wednesday next week';

            if ($this->isSunday($dt)) {
                // Workaround for bug http://php.net/manual/en/datetime.formats.relative.php#108317
                $setWednesday = 'Wednesday this week';
            }

            $dt->modify($setWednesday);
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
