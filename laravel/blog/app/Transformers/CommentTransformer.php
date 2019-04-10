<?php
namespace App\Transformers;

use App\Model\Comment;
use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    /**
     * Set single element
     *
     * @param Comment $comment
     * @return array
     */
    public function transform(Comment $comment)
    {
        return [
            'id' => (int) $comment->id,
            'content' => (string) $comment->content,
            'creator_id' => (int) $comment->creator_id,
            'article_id' => (int) $comment->image,
            'status' => (string) $comment->status,
            'created_at' => (string) $comment->created_at->format('d/m/Y - H:i'),
            'author' => (object) $comment->author
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
