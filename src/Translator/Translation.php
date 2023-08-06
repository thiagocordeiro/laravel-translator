<?php declare(strict_types=1);

namespace Translator\Translator;

class Translation
{
  private string $key;
  private string $value;
  private string $module;

  public function __construct(string $key, string $value, string $module = '')
  {
    $this->key = $key;
    $this->value = $value;
    $this->module = $module;
  }

  public function getKey(): string
  {
    return $this->key;
  }

  public function getValue(): string
  {
    return $this->value;
  }

  public function getModule(): string
  {
    return $this->module;
  }
}
