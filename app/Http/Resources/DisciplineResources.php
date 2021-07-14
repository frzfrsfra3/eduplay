<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Input;

class DisciplineResources extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * param  \Illuminate\Http\Request $request
     * return array
     */
    public function toArray ($request)
    {



        return parent::toArray ($request);
    }
}
