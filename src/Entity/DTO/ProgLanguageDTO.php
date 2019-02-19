<?php
/**
 * Created by PhpStorm.
 * User: OSBKONE
 * Date: 17/02/2019
 * Time: 20:06
 */

namespace App\Entity\DTO;


class ProgLanguageDTO
{
    private $value;
    private $data;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }
}