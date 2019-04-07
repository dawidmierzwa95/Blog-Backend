<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait Sluggable
{
    public static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            $model->slug = $model->generateSlugFromModel($model);
        });
    }

    public function generateSlugFromModel(Model $model)
    {
        $config = $model->sluggable();
        $suffix = "";
        $slug = str_replace(
            ['ą', 'ę', 'ó', 'ł', 'ś', 'ż', 'ź', 'ć', 'ń', ' '],
            ['a', 'e', 'o', 'l', 's', 'z', 'z', 'c', 'n', '-'],
            mb_strtolower($model->{$config["source"]})
        );

        if(isset($config["unique"]))
        {
            while(1)
            {
                if($model::where([["slug", "=", $slug.$suffix], ["id", "!=", $model->id]])->first())
                {
                    $suffix = rand(0, 9999);
                    continue;
                }

                break;
            }
        }

        return $slug.$suffix;
    }

    abstract public function sluggable(): array;
}
