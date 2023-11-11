<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\BankAccountsInfo;
use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountsInfoResource extends JsonResource
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
            'Nombre del banco' => $this->bank_name,
            'Numero de la cuenta'=> $this->account_number,
            'Nombre de la cuenta'=> $this->account_name,
        ];
    }
}
