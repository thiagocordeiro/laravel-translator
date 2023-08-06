<?php declare(strict_types=1);
  
  namespace Translator\Framework;
  
  use Translator\Translator\ConfigLoader;
  
  class LaravelConfigLoader implements ConfigLoader
  {
    /**
     * @inheritDoc
     */
    public function languages(): array
    {
      return $this->loadConfigInArray('languages');
    }
    
    /**
     * @inheritDoc
     */
    public function defaultLanguage(): string
    {
      $defaultLanguage = $this->loadConfigInString('default_language');
      
      if ($defaultLanguage === '') {
        return 'en';
      }
      
      return $defaultLanguage;
    }
    
    /**
     * @inheritDoc
     */
    public function useKeysAsDefaultValue(): bool
    {
      return !!$this->load('use_keys_as_default_value');
    }
    
    /**
     * @inheritDoc
     */
    public function directories(): array
    {
      $directories = $this->loadConfigInArray('directories');
      if ($this->loadConfigInBool('modules')) {
        array_push($directories, $this->loadConfigInString('modules_dir'));
        return $directories;
      }
      return $directories;
    }
    
    /**
     * @inheritDoc
     */
    public function output(): string
    {
      return $this->loadConfigInString('output');
    }
    
    /**
     * @inheritDoc
     */
    public function extensions(): array
    {
      return $this->loadConfigInArray('extensions');
    }
    
    /**
     * @inheritDoc
     */
    public function functions(): array
    {
      return $this->loadConfigInArray('functions');
    }
    
    /**
     * @inheritDoc
     */
    public function modules(): bool
    {
      return $this->loadConfigInBool('modules');
    }
    
    /**
     * @inheritDoc
     */
    public function modulesDirName(): string
    {
      return $this->loadConfigInString('modules_dir');
    }
    
    /**
     * @inheritDoc
     */
    public function modulesOutput(): bool
    {
      return $this->loadConfigInBool('modules_output');
    }
    
    /**
     * @return array<string>
     */
    private function loadConfigInArray(string $key): array
    {
      $values = $this->load($key);
      
      if (!is_array($values)) {
        return [];
      }
      
      return $values;
    }
    
    private function loadConfigInString(string $key): string
    {
      $value = $this->load($key);
      
      if (!is_string($value)) {
        return '';
      }
      
      return $value;
    }
    
    private function loadConfigInBool(string $key): bool
    {
      $value = $this->load($key);
      
      if (!is_bool($value)) {
        return false;
      }
      
      return $value;
    }
    
    /**
     * @return string|string[]
     */
    private function load(string $key)
    {
      return config("translator.{$key}");
    }
  }
