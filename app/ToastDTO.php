<?php

class ToastDTO
{

  private $type;
  private $message;

  public function __construct(string $type = null, string $message = null)
  {
    $this->type = $type;
    $this->message = $message;
  }

  public function getType()
  {
    return $this->type;
  }

  public function setType(string $type)
  {
    $this->type = $type;
  }

  public function getMessage()
  {
    return $this->message;
  }

  public function setMessage(string $message)
  {
    $this->message = $message;
  }
}
