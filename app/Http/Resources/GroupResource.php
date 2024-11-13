<?php

namespace App\Http\Resources;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    protected $model = Group::class;
    
    public function toArray(Request $request): array
    {
        return [
            'name'=> $this->nameGroup,
            'description'=>$this->description
        ];
    }
}
