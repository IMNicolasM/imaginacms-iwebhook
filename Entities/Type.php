<?php

namespace Modules\Iwebhooks\Entities;

class Type
{
  const EVENT = 1;
  const ACTION = 2;
  const DEFAULT_TYPE = self::EVENT;

  private $types = [];

  public function __construct()
  {
    $this->types = [
      self::EVENT => trans('iwebhooks::types.event'),
      self::ACTION => trans('iwebhooks::types.action')
    ];
  }

  public function lists()
  {
    return $this->types;
  }

  public function index()
  {
    //Instance response
    $response = [];
    //AMp status
    foreach ($this->types as $key => $status) {
      array_push($response, ['id' => $key, 'title' => $status]);
    }
    //Repsonse
    return collect($response);
  }

  public function get($statusId)
  {
    $response = isset($this->types[$statusId]) ? ['id' => $statusId, 'title' => $this->types[$statusId]] :
      ['id' => self::DEFAULT_TYPE, 'title' => $this->types[self::DEFAULT_TYPE]];
    //Repsonse
    return $response;
  }
}
