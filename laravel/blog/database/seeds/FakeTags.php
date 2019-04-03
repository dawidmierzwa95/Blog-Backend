<?php

use Illuminate\Database\Seeder;
use App\Tag;

class FakeTags extends Seeder
{
    private $data = [
        'tag1', 'tag2', 'fajnytag', 'innyfajnytag', 'alonetag'
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
            $new = new Tag();

            $new->name = $item;
            $new->save();
        }
    }
}
