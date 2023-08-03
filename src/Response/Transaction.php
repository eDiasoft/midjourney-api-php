<?php

namespace eDiasoft\Midjourney\Response;

class Transaction extends Response
{
    protected string $Send_Type;
    protected string $result;
    protected string $ret_msg;
    protected string $OrderID;
    protected string $e_Cur;
    protected string $e_money;
    protected string $e_date;
    protected string $e_time;
    protected string $e_orderno;
    protected string $e_no;
    protected string $e_outlay;
    protected string $str_check;
    protected string $bankname;
    protected string $avcode;
    protected string $Invoice_No;

    public function isSuccess(): bool
    {
        return $this->result == '1';
    }

    public function returnMessage(): string
    {
        return $this->ret_msg;
    }

    public function get(string $property): mixed
    {
        return $this->$property ?? null;
    }
}
