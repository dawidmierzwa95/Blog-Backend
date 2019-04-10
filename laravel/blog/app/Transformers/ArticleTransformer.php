<?php
namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;
use App\Model\Article;

class ArticleTransformer extends TransformerAbstract
{
    /**
     * Set single element
     *
     * @param Article $article
     * @return array
     */
    public function transform(Article $article)
    {
        return [
            'id' => (int) $article->id,
            'slug' => (string) $article->slug,
            'title' => (string) $article->title,
            'image' => (string) $article->image,
            'content' => (string) $article->content,
            'creator_id' => (int) $article->creator_id,
            'author' => (object) $article->author,
            'tags' => $article->tags,
            'created_at' => (string) $article->created_at
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
