<?php

namespace App\Http\Resources;

use App\Models\Author;
use App\Models\Cover;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'published_at' => $this->published_at,
            'src' => Cover::where('book_id', $this->id)->first()->src,
            'first_name' => Author::where('book_id', $this->id)->first()->first_name,
            'last_name' => Author::where('book_id', $this->id)->first()->last_name,
            'second_name' => Author::where('book_id', $this->id)->first()->second_name
        ];
    }
}
