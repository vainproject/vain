<?php

namespace Vain\Packages\Translator;

trait TranslatableContentTrait
{
    /**
     * name of the locale field.
     *
     * @var string
     */
    protected $locale_field = 'locale';

    /**
     * delimiter used to separate from form values.
     *
     * @var string
     */
    protected $locale_delimiter = '_';

    /**
     * fills the model with local data.
     *
     * @param $locale
     * @param $attributes
     *
     * @return $this
     */
    public function fillTranslated($locale, $attributes)
    {
        $this->{$this->locale_field} = $locale;

        foreach ($this->fillable as $fillable) {
            $key = $fillable.$this->locale_delimiter.$locale;

            $value = array_key_exists($key, $attributes)
                ? $attributes[$key]
                : null;

            if ($value !== null) {
                $this->{$fillable} = $value;
            }
        }

        return $this;
    }

    /**
     * basicly used to update a localization with ease.
     *
     * @param $query
     * @param $locale
     *
     * @return static
     */
    public function scopeLocaleOrNew($query, $locale)
    {
        $obj = $query->where($this->locale_field, $locale)->first();

        return $obj ?: new static();
    }
}
