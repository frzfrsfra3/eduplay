<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    //we should return here the question
    public function toArray($request)
    {
     //   return json_encode($this);
       // return $this->toJson(JSON_PRETTY_PRINT);


       return [
            'details' =>$this->details,
            'questiontype' =>$this-> questiontype,
            'maxtime' =>$this->maxtime,
            'mark' =>$this->mark,
            'difficultylevel'=>$this->difficultylevel,
            'hint'=>$this->hint,
            ];
    }
}
