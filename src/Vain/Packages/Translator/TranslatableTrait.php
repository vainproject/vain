<?php

namespace Vain\Packages\Translator;

trait TranslatableTrait
{
    /**
     * @var \Illuminate\Database\Eloquent\Model[]
     */
    private $_content = [];

    /**
     * accessor for content current user language.
     *
     * @param $value
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getContentAttribute($value)
    {
        return $this->content();
    }

    /**
     * returns the localized content.
     *
     * @param null $locale
     * @param bool $fallback
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function content($locale = null, $fallback = true)
    {
        if ($locale === null) {
            $locale = app()->getLocale();
        }

        if ($this->has($locale)) {
            return $this->get($locale);
        }

        $content = $this->contents()
            ->where('locale', $locale)
            ->first();

        if ($fallback && $content === null) {
            $content = $this->contents()
                ->first();
        }

        $this->store($locale, $content);

        return $content;
    }

    /**
     * store internal runtime cache.
     *
     * @param string                              $locale
     * @param \Illuminate\Database\Eloquent\Model $content
     */
    private function store($locale, $content)
    {
        $this->_content[$locale] = $content;
    }

    /**
     * get internal runtime cache.
     *
     * @param $locale
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function get($locale)
    {
        return $this->_content[$locale];
    }

    /**
     * exists in internal runtime cache.
     *
     * @param $locale
     *
     * @return bool
     */
    private function has($locale)
    {
        return array_key_exists($locale, $this->_content);
    }
}
