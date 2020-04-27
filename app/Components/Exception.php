<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/27/2020
 * Time: 9:37 AM
 */

namespace App\Components;

use Throwable;


class Exception  extends \Exception
{
    protected $special_code;
    protected $data;

    public function __construct($message = "", $code = 0, $data = null, Throwable $previous = null)
    {
        $this->data = $data;
        $this->special_code = $code;
        parent::__construct($message, 0, $previous);
    }

    public function getSpecialCode()
    {
        return $this->special_code;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }
}