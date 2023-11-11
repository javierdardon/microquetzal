<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            '#Pedido' => $this->id,
            'Cliente' => "{$this->user->name} {$this->user->lastname}",
            'Estado' => $this->status,
            'Total' => 'Q.'.number_format($this->total,2),
            'Unidades' => $this->quantity,
            'Fecha' => date("d/m/Y", strtotime($this->created_at))
        ];
    }
}
