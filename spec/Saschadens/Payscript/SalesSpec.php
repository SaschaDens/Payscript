<?php

namespace spec\Saschadens\Payscript;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use DateTime;
use Saschadens\Payscript\Formatter;

class SalesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Saschadens\Payscript\Sales');
    }

    function it_tests_if_salary_datetime_returns_a_datetime()
    {
        $datetime = new DateTime();

        $this->getMonthlySalaryDate($datetime)->shouldReturnAnInstanceOf('DateTime');
    }

    function it_translates_Mar_2015_datatime_to_salary_payday_31_Mar_2015_datetime()
    {
        $currentDate = $this->getDatetime(2015, 3, 1);
        $expectedDate = $this->getDatetime(2015, 3, 31);

        $this->getMonthlySalaryDate($currentDate)->shouldBeLike($expectedDate);
    }

    function it_translates_Apr_2015_datatime_to_salary_payday_30_Apr_2015_datetime()
    {
        $currentDate = $this->getDatetime(2015, 4, 1);
        $expectedDate = $this->getDatetime(2015, 4, 30);

        $this->getMonthlySalaryDate($currentDate)->shouldBeLike($expectedDate);
    }

    /**
     * Exceptions: unless that day is a Saturday or a Sunday.
     */
    function it_translates_Jan_2015_datatime_to_salary_payday_30_Jan_2015_datetime()
    {
        $currentDate = $this->getDatetime(2015, 1, 1);
        $expectedDate = $this->getDatetime(2015, 1, 30);

        $this->getMonthlySalaryDate($currentDate)->shouldBeLike($expectedDate);
    }

    /**
     * Exceptions: unless that day is a Saturday or a Sunday.
     */
    function it_translates_Feb_2015_datatime_to_salary_payday_27_Feb_2015_datetime()
    {
        $currentDate = $this->getDatetime(2015, 2, 1);
        $expectedDate = $this->getDatetime(2015, 2, 27);

        $this->getMonthlySalaryDate($currentDate)->shouldBeLike($expectedDate);
    }

    /**
     * Exceptions: unless that day is a Saturday or a Sunday.
     */
    function it_translates_May_2015_datatime_to_salary_payday_29_May_2015_datetime()
    {
        $currentDate = $this->getDatetime(2015, 5, 1);
        $expectedDate = $this->getDatetime(2015, 5, 29);

        $this->getMonthlySalaryDate($currentDate)->shouldBeLike($expectedDate);
    }

    function it_translates_Jan_2015_datatime_to_salary_bonusday_15_Jan_2015_datetime()
    {
        $currentDate = $this->getDatetime(2015, 1, 1);
        $expectedDate = $this->getDatetime(2015, 1, 15);

        $this->getMonthlyBonusDate($currentDate)->shouldBeLike($expectedDate);
    }

    function it_translates_May_2015_datatime_to_salary_bonusday_15_May_2015_datetime()
    {
        $currentDate = $this->getDatetime(2015, 5, 1);
        $expectedDate = $this->getDatetime(2015, 5, 15);

        $this->getMonthlyBonusDate($currentDate)->shouldBeLike($expectedDate);
    }

    /**
     * On the 15th of every month bonuses are paid for the previous month, unless that day is a Saturday or a Sunday (weekend).
     * In that case, they are paid the first Wednesday after the 15th.
     */
    function it_translates_Feb_2015_datatime_to_salary_bonusday_18_Feb_2015_datetime()
    {
        $currentDate = $this->getDatetime(2015, 2, 1);
        $expectedDate = $this->getDatetime(2015, 2, 18);

        $this->getMonthlyBonusDate($currentDate)->shouldBeLike($expectedDate);
    }

    /**
     * On the 15th of every month bonuses are paid for the previous month, unless that day is a Saturday or a Sunday (weekend).
     * In that case, they are paid the first Wednesday after the 15th.
     */
    function it_translates_Nov_2015_datatime_to_salary_bonusday_18_Nov_2015_datetime()
    {
        $currentDate = $this->getDatetime(2015, 11, 1);
        $expectedDate = $this->getDatetime(2015, 11, 18);

        $this->getMonthlyBonusDate($currentDate)->shouldBeLike($expectedDate);
    }

    function it_calculates_remaining_6_months_salary_to_paydate_collection()
    {
        $this->getPayDateCollectionRemainingMonths(6)->shouldReturnAnInstanceOf('Saschadens\Payscript\Collection\PayDate');
    }

    private function getDatetime($year, $month, $day)
    {
        $dt = new DateTime();
        $dt->setDate($year, $month, $day);
        $dt->setTime(0, 0, 0);

        return $dt;
    }
}
