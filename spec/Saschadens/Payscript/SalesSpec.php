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

    /**
     * Exceptions: unless that day is a Saturday or a Sunday.
     */
    function it_translates_Jan_2015_datatime_to_salary_payday_30_Jan_2015_datetime()
    {
        $this->checkMonthSalaryDate(2015, 1, 30);
    }

    /**
     * Exceptions: unless that day is a Saturday or a Sunday.
     */
    function it_translates_Feb_2015_datatime_to_salary_payday_27_Feb_2015_datetime()
    {
        $this->checkMonthSalaryDate(2015, 2, 27);
    }


    function it_translates_Mar_2015_datatime_to_salary_payday_31_Mar_2015_datetime()
    {
        $this->checkMonthSalaryDate(2015, 3, 31);
    }

    function it_translates_Apr_2015_datatime_to_salary_payday_30_Apr_2015_datetime()
    {
        $this->checkMonthSalaryDate(2015, 4, 30);
    }

    /**
     * Exceptions: unless that day is a Saturday or a Sunday.
     */
    function it_translates_May_2015_datatime_to_salary_payday_29_May_2015_datetime()
    {
        $this->checkMonthSalaryDate(2015, 5, 29);
    }

    function it_translates_Jun_2015_datatime_to_salary_payday_30_Jun_2015_datetime()
    {
        $this->checkMonthSalaryDate(2015, 6, 30);
    }

    function it_translates_Jul_2015_datatime_to_salary_payday_31_Jul_2015_datetime()
    {
        $this->checkMonthSalaryDate(2015, 7, 31);
    }

    function it_translates_Aug_2015_datatime_to_salary_payday_31_Aug_2015_datetime()
    {
        $this->checkMonthSalaryDate(2015, 8, 31);
    }

    function it_translates_Sep_2015_datatime_to_salary_payday_30_Sep_2015_datetime()
    {
        $this->checkMonthSalaryDate(2015, 9, 30);
    }

    function it_translates_Oct_2015_datatime_to_salary_payday_30_Oct_2015_datetime()
    {
        $this->checkMonthSalaryDate(2015, 10, 30);
    }

    function it_translates_Nov_2015_datatime_to_salary_payday_30_Nov_2015_datetime()
    {
        $this->checkMonthSalaryDate(2015, 11, 30);
    }

    function it_translates_Dec_2015_datatime_to_salary_payday_31_Dec_2015_datetime()
    {
        $this->checkMonthSalaryDate(2015, 12, 31);
    }

    function it_translates_Jan_2015_datatime_to_salary_bonusday_15_Jan_2015_datetime()
    {
        $this->checkMonthBonusDate(2015, 1, 15);
    }

    /**
     * On the 15th of every month bonuses are paid for the previous month, unless that day is a Saturday or a Sunday (weekend).
     * In that case, they are paid the first Wednesday after the 15th.
     */
    function it_translates_Feb_2015_datatime_to_salary_bonusday_18_Feb_2015_datetime()
    {
        $this->checkMonthBonusDate(2015, 2, 18);
    }

    function it_translates_Mar_2015_datatime_to_salary_bonusday_18_Mar_2015_datetime()
    {
        $this->checkMonthBonusDate(2015, 3, 18);
    }

    function it_translates_Apr_2015_datatime_to_salary_bonusday_15_Apr_2015_datetime()
    {
        $this->checkMonthBonusDate(2015, 4, 15);
    }

    function it_translates_May_2015_datatime_to_salary_bonusday_15_May_2015_datetime()
    {
        $this->checkMonthBonusDate(2015, 5, 15);
    }

    function it_translates_Jun_2015_datatime_to_salary_bonusday_15_Jun_2015_datetime()
    {
        $this->checkMonthBonusDate(2015, 6, 15);
    }

    function it_translates_Jul_2015_datatime_to_salary_bonusday_15_Jul_2015_datetime()
    {
        $this->checkMonthBonusDate(2015, 7, 15);
    }

    function it_translates_Aug_2015_datatime_to_salary_bonusday_19_Aug_2015_datetime()
    {
        $this->checkMonthBonusDate(2015, 8, 19);
    }

    function it_translates_Sep_2015_datatime_to_salary_bonusday_15_Sep_2015_datetime()
    {
        $this->checkMonthBonusDate(2015, 9, 15);
    }

    function it_translates_Oct_2015_datatime_to_salary_bonusday_15_Oct_2015_datetime()
    {
        $this->checkMonthBonusDate(2015, 10, 15);
    }

    /**
     * On the 15th of every month bonuses are paid for the previous month, unless that day is a Saturday or a Sunday (weekend).
     * In that case, they are paid the first Wednesday after the 15th.
     */
    function it_translates_Nov_2015_datatime_to_salary_bonusday_18_Nov_2015_datetime()
    {
        $this->checkMonthBonusDate(2015, 11, 18);
    }

    function it_translates_Dec_2015_datatime_to_salary_bonusday_15_Dec_2015_datetime()
    {
        $this->checkMonthBonusDate(2015, 12, 15);
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

    private function checkMonthSalaryDate($year, $month, $day)
    {
        $currentDate = $this->getDatetime($year, $month, 1);
        $expectedDate = $this->getDatetime($year, $month, $day);

        $this->getMonthlySalaryDate($currentDate)->shouldBeLike($expectedDate);
    }

    private function checkMonthBonusDate($year, $month, $day)
    {
        $currentDate = $this->getDatetime($year, $month, 1);
        $expectedDate = $this->getDatetime($year, $month, $day);

        $this->getMonthlyBonusDate($currentDate)->shouldBeLike($expectedDate);
    }
}
