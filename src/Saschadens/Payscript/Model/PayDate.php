<?php

namespace Saschadens\Payscript\Model;

use Saschadens\Payscript\Model\AbstractModel;
use DateTime;

class PayDate extends AbstractModel {

    /**
     * @var DateTime
     */
    protected $_bonusDate;

    /**
     * @var DateTime
     */
    protected $_salaryDate;

    /**
     * @return DateTime
     */
    public function getBonusDate()
    {
        return $this->_bonusDate;
    }

    /**
     * @return DateTime
     */
    public function getSalaryDate()
    {
        return $this->_salaryDate;
    }

    /**
     * @param DateTime $dt
     */
    public function setBonusDate(DateTime $dt)
    {
        $this->_bonusDate = $dt;
    }

    /**
     * @param DateTime $dt
     */
    public function setSalaryDate(DateTime $dt)
    {
        $this->_salaryDate = $dt;
    }
}
