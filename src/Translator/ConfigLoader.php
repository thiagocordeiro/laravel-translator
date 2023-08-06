<?php declare(strict_types=1);

namespace Translator\Translator;

interface ConfigLoader
{
    /**
     * Load the list of project languages
     *
     * @return array<string>
     */
    public function languages(): array;

    /**
     * Specifies the default language.
     */
    public function defaultLanguage(): string;

    /**
     * Defines if the keys for the default language should be used as the default value
     */
    public function useKeysAsDefaultValue(): bool;

    /**
     * Load the list of directories to be scanned
     *
     * @return array<string>
     */
    public function directories(): array;

    /**
     * Load the directory where the updated translation file will be written
     */
    public function output(): string;

    /**
     * Load the list of file extensions to be scanned
     *
     * @return array<string>
     */
    public function extensions(): array;

    /**
     * Load the list of functions to be scanned
     *
     * @return array<string>
     */
    public function functions(): array;

    /**
     * Load name of Module directory
     * @return string
     */
    public function modulesDirName(): string;

    /**
     * Load status output path of modules language
     * @return bool
     */
    public function modulesOutput(): bool;

    /**
     * Load module status
     * @return bool
     */
    public function modules(): bool;
}