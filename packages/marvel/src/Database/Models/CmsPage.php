<?php

declare(strict_types=1);

namespace Marvel\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsPage extends Model
{
    use SoftDeletes;

    protected $table = 'cms_pages';

    protected $guarded = [];

    protected $casts = [
        'content' => 'array',
        'meta' => 'array',
    ];
}

