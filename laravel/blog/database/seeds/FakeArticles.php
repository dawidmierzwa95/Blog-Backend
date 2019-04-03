<?php

use Illuminate\Database\Seeder;
use App\Article;
use Illuminate\Support\Facades\DB;
use App\Tag;

class FakeArticles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $new = new Article();

        $new->slug = "wpis-testowy";
        $new->title = "Wpis testowy";
        $new->content = "
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam quis ante nibh. Fusce ultricies quis turpis eget mattis. Vestibulum convallis eleifend est in lacinia. Mauris non sem dictum, eleifend mauris at, euismod dui. Maecenas rutrum euismod rutrum. Curabitur odio urna, euismod ut finibus in, pharetra nec eros. Nullam pellentesque condimentum magna, sed euismod felis mollis nec. Donec tincidunt interdum mauris eu laoreet. <strong>Test</strong>";
        $new->creator_id = 1;
        $new->save();

        $new->tags()->attach(Tag::find([1, 2, 3, 4]));
    }
}
