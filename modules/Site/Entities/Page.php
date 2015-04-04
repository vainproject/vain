<?php namespace Modules\Site\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Vain\Packages\Translator\Translatable as TranslatableContract;
use Vain\Packages\Translator\TranslatableTrait;

class Page extends Model implements TranslatableContract {

    use SoftDeletes, TranslatableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'slug', 'role', 'published_at', 'concealed_at' ];

    /**
     * used for soft deletion
     *
     * @var array
     */
    protected $dates = [ 'published_at', 'concealed_at', 'deleted_at' ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contents()
    {
        return $this->hasMany('Modules\Site\Entities\Content');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Modules\User\Entities\User');
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where(function($query) {

            $query->where(function($query) {
                $query->where('published_at', '<=', Carbon::now())
                    ->orWhere('published_at', null);
            });

            $query->where(function($query) {
                $query->where('concealed_at', '>=', Carbon::now())
                    ->orWhere('concealed_at', null);
            });
        });
    }

    /**
     * fix optional empty dates
     *
     * @param $value
     */
    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = !empty($value)
            ? $value
            : null;
    }

    /**
     * fix optional empty dates
     *
     * @param $value
     */
    public function setConcealedAtAttribute($value)
    {
        $this->attributes['concealed_at'] = !empty($value)
            ? $value
            : null;
    }
}
