# Payscript Kata
[![Build Status](https://travis-ci.org/SaschaDens/payscript.svg?branch=master)](https://travis-ci.org/SaschaDens/payscript)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SaschaDens/payscript/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SaschaDens/payscript/?branch=master)

This company is handling their sales payroll in the following way: Sales staff get a regular monthly fixed base salary
and a monthly bonus. The base salaries are paid on the last day of the month unless that day is a Saturday or a Sunday (weekend).

On the 15th of every month bonuses are paid for the previous month, unless that day is a Saturday or a Sunday (weekend).
In that case, they are paid the first Wednesday after the 15th.

The output of this utility is a formatter that supports the following formats with 3 columns (Month, Salary date and Bonus date) 
for the remaining months in the current year.
- Html
- Json
- Csv
