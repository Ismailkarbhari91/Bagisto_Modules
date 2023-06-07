<?php

namespace Webkul\Quote\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Webkul\Core\Eloquent\Repository;
use Webkul\Quote\Models\Quote;


class QuoteRepository extends Repository
{

    public function __construct(App $app)
    {
        parent::__construct($app);
    }

  
    public function model()
    {
        return 'Webkul\Quote\Models\Quote';
    }

    public function update(array $data, $id, $attribute = "id")
    {
        $quote = $this->find($id);
        $quote->update($data);
        return $quote;
    }


}