<?php

namespace App\Article;

class Status
{
  const BRUILLON = 1;
  const VENDU = 2;
  const EN_STOCK = 3;

  public static function getStatus(): array
  {
    return [
      self::BRUILLON ,
      self::VENDU,
      self::EN_STOCK
    ];
  }
}
