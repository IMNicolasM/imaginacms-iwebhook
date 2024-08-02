<?php

namespace Modules\Iwebhooks\Entities;

use Modules\Core\Icrud\Entities\CrudStaticModel;

class Type extends CrudStaticModel
{
  const EVENT = 1;
  const ACTION = 2;

  public function __construct()
  {
    $this->records = [
      self::EVENT => trans('iwebhooks::statics.type.event'),
      self::ACTION => trans('iwebhooks::statics.type.action')
    ];
  }
}
