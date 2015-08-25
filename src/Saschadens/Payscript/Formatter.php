<?php
namespace Saschadens\Payscript;

use Saschadens\Payscript\Collection\PayDate as PayDateCollection;

interface Formatter {

    /**
     * @param PayDateCollection $collection
     *
     * @return mixed
     */
    public function output(PayDateCollection $collection);

}
