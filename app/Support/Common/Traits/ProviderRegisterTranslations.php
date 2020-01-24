<?php

namespace Support\Common\Traits;

trait ProviderRegisterTranslations
{
    /**
     * Alias for translations.
     *
     * @var string
     */
    protected string $translationAlias;

    /**
     * Translation resource path.
     *
     * @var string
     */
    protected string $translationPath = 'Resources' . DIRECTORY_SEPARATOR . 'Lang';

    /**
     * Enable translations loading.
     *
     * @var bool
     */
    protected bool $hasTranslations = false;

    protected function loadTranslations(): void
    {
        if ($this->hasTranslations) {
            $this->loadTranslationsFrom(
                $this->componentPath($this->translationPath),
                $this->translationAlias
            );
        }
    }
}
