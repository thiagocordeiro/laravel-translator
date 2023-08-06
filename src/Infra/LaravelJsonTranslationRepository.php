<?php declare(strict_types=1);

namespace Translator\Infra;

use Translator\Infra\Exception\InvalidTranslationFile;
use Translator\Infra\Exception\TranslationFileDoesNotExistForLanguage;
use Translator\Infra\Exception\UnableToSaveTranslationKeyAlreadyExists;
use Translator\Translator\ConfigLoader;
use Translator\Translator\Translation;
use Translator\Translator\TranslationRepository;

class LaravelJsonTranslationRepository implements TranslationRepository
{
    private ConfigLoader $config;
    
    /** @var array<string, array<string>> */
    private array $fileCache = [];
    
    public function __construct(ConfigLoader $config)
    {
        $this->config = $config;
    }
    
    /**
     * @throws TranslationFileDoesNotExistForLanguage
     * @throws InvalidTranslationFile
     */
    public function exists(Translation $translation, string $language): bool
    {
        $translations = $this->getTranslations($language, $translation->getModule());
        return isset($translations[$translation->getKey()]);
    }
    
    /**
     * @throws InvalidTranslationFile
     * @throws TranslationFileDoesNotExistForLanguage
     * @throws UnableToSaveTranslationKeyAlreadyExists
     */
    public function save(Translation $translation, string $language): void
    {
        $translations = $this->getTranslations($language, $translation->getModule());
        if ($this->exists($translation, $language)) {
            throw new UnableToSaveTranslationKeyAlreadyExists($translation, $language);
        }
        
        if (!empty($translation->getModule()) && $this->config->modules()) {
            $translations[$translation->getKey()] = $this->useKeyAsDefaultValue($translation, $language) ?
              $translation->getKey() :
              $translation->getValue();
            $this->fileCache[$translation->getModule()][$language] = $translations;
        } else {
            $translations[$translation->getKey()] = $this->useKeyAsDefaultValue($translation, $language) ?
              $translation->getKey() :
              $translation->getValue();
            $this->fileCache[$language] = $translations;
        }
        $this->writeFile($language, $translation->getModule());
    }
    
    /**
     * @return array<string>
     * @throws InvalidTranslationFile
     * @throws TranslationFileDoesNotExistForLanguage
     */
    private function getTranslations(string $language, string $module = ''): array
    {
        if ($this->config->modules() && !empty($module)) {
            if (!isset($this->fileCache[$module][$language])) {
                $this->fileCache[$module][$language] = $this->readFile($language, $module);
            }
            return $this->fileCache[$module][$language];
        } else {
            if (!isset($this->fileCache[$language])) {
                $this->fileCache[$language] = $this->readFile($language) ?? [];
            }
            return $this->fileCache[$language];
        }
    }
    
    private function getFileNameForLanguage(string $language, string $module = ''): string
    {
        if ($this->config->modules() && !empty($module)) {
            if ($this->config->modulesOutput()) {
                $directory = $this->config->modulesDirName() . '/' . $module . '/Resources/lang';
            } else {
                $directory = $this->config->output() . "/modules/{$module}";
            }
        } else {
            $directory = $this->config->output();
        }
        return $directory . "/{$language}.json";
    }
    
    private function getFileNameForModuleLanguage(string $language, string $module): string
    {
        $directory = $this->config->modulesDirName() . '/' . $module . '/Resources/lang';
        return $directory . "/{$language}.json";
    }
    
    /**
     * @return string[]
     * @throws InvalidTranslationFile
     * @throws TranslationFileDoesNotExistForLanguage
     */
    private function readFile(string $language, string $module = ''): array
    {
        $filename = $this->getFileNameForLanguage($language, $module);
        $sp = explode('/', $filename);
        unset($sp[count($sp) - 1]);
        $sir_path = implode('/', $sp);
        
        if (!is_dir($sir_path)) {
            mkdir($sir_path, 0755, true);
        }
        
        if (!file_exists($filename)) {
            $file = fopen($filename, 'w+');
            
            $mcontent = '[]';
            if($module != '' && !$this->config->modulesOutput()){
                $mfilename = $this->getFileNameForModuleLanguage($language,$module);
                if(file_exists($mfilename)){
                    $mcontent = file_get_contents($mfilename);
                }
            }
            fwrite($file, $mcontent);
            fclose($file);
        }
        
        $content = file_get_contents($filename);
        if (!$content) {
            throw new InvalidTranslationFile($language);
        }
        
        $translations = json_decode($content, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidTranslationFile($language);
        }
        return $translations;
    }
    
    private function writeFile(string $language, string $module = ''): void
    {
        if (!empty($module)) {
            $content = $this->fileCache[$module][$language];
        } else {
            $content = $this->fileCache[$language];
        }
        ksort($content);
        file_put_contents(
          $this->getFileNameForLanguage($language, $module),
          json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }
    
    private function useKeyAsDefaultValue(Translation $translation, string $language): bool
    {
        return empty($translation->getValue()) &&
          $this->config->defaultLanguage() === $language &&
          $this->config->useKeysAsDefaultValue();
    }
}
