<?php

use Illuminate\Database\Seeder;
use App\Comment;

class FakeComments extends Seeder
{
    private $data = [
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam quis ante nibh. Fusce ultricies quis turpis eget mattis.',
        'Consectetur adipiscing elit.',
        'Aliquam quis ante nibh. Fusce ultricies quis turpis eget mattis.',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->data;

        foreach($data as &$item)
        {
            $new = new Comment();

            $new->content = $item;
            $new->creator_id = 1;
            $new->article_id = 1;
            $new->save();
        }
    }
}
