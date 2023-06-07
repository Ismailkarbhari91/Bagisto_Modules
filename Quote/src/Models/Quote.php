<?php

namespace Webkul\Quote\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Quote\Contracts\Quote as QuoteContract;
class Quote extends Model implements QuoteContract
{
	protected $table = 'quote';
    protected $fillable = ['name','email','message_title','message_body','pcurrency','locationtype','quotestatus','pid']; 

}