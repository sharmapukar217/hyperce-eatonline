<?php

namespace Hyperce\EatOnline\Models;

use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Flame\Database\Traits\Validation;


/**
 * Location Headers Model Class
 */
class Location_headers_model extends Model
{
    use Validation;
    use Sortable;

    const SORT_ORDER = 'priority';
    public static $MAX_ALLOWED_HEADERS = 5;

    protected $primaryKey = 'id';
    protected $table = 'location_headers';
    protected $fillable = ['location_id', 'title', 'href', 'priority'];

    public $rules = [
        ['location_id', 'location_id', 'integer'],
        ['title', 'hyperce.eatonline::default.header.label_title', 'required|string'],
        ['href', 'hyperce.eatonline::default.header.label_href', 'sometimes|required|string|url'],
    ];

}
