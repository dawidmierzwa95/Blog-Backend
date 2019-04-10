<?php
namespace App\Transformers;

use App\Model\Tag;
use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;
use App\Model\Article;

class TagTransformer extends TransformerAbstract
{
    /**
     * Set single element
     *
     * @param Tag $tag
     * @return array
     */
    public function transform(Tag $tag)
    {
        return [
            'id' => (int) $tag->id,
            'name' => (string) $tag->name,
        ];
    }

    /**
     * Set collection
     *
     * @param Collection $items
     * @return Collection
     */
    public function transformCollection(Collection $items)
    {
        return $items->map(function ($item) {
            return $this->transform($item);
        });
    }
}
