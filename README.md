# Seaaaaarch

## Install

```
composer require fusic/Seaaaaarch
```

## Setting

add providers

```
Search\Providers\SearchServiceProvider::class
```

## Create Searchable

app\Search\HogeSearch.php
```
<?php

namespace App\Search;

use Illuminate\Database\Eloquent\Builder;
use Search\Searchable;

class HogeSearch extends Searchable
{
    public function __construct()
    {
        $this->params = [
            'name' => [
                'type' => 'text'
            ],
            'start_date' => [
                'type' => 'date',
                'comparison' => '>='
            ],
            'end_date' => [
                'type' => 'date',
                'comparison' => '<='
            ],
            'category_id' => [
                'type' => 'integer'
            ],
            'public_flg' => [
                'type' => 'bool'
            ],
            'body' => [
                'type' => 'callback',
                'method' => 'example'
            ]
        ];
    }


    public function example(Builder $builder, $key, $value)
    {
        $body = trim($body);
        $builder->where($key, 'like', $value);
        
        return $builder;
    }
}
```

# usage

```
ExampleMode::search(new HogeSearch())
  ->whre('hoge', 'fuga')
```

or

```
ExampleMode::whre('hoge', 'fuga')
  ->search(new HogeSearch())
```