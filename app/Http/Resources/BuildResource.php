<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class BuildResource extends JsonResource
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
            'Código' => $this->id,
            'Nombre' => $this->name,
            'Imagen' => $this->images,
            'Oferta' => $this->percentage ? "{$this->percentage}%" : 'No',
            'Precio efectivo' => 'Q.'.number_format($this->price,2),
            'Precio normal' => 'Q.'.number_format($this->normal_price,2),
            'Precio Oferta' => 'Q.'.number_format($this->sale_price,2),
            'Precio normal oferta' => 'Q.'.number_format($this->sale_normal_price,2),
            'show_price' => 'Q.'.number_format($this->show_price,2),
            'Gama' => $this->gama->name,
            'En existencia' => $this->quantity,
            'Descripcion' => $this->description,
            'CPU' => $this->cpu_id ? $this->cpu->name : $this->cpu_name,
            'Cooler' => $this->cooler_stock ? 'Stock': ($this->cooler_id ? $this->cooler->name : $this->cooler_name),
            'RAM' => $this->ram_id ? $this->ram->name : $this->ram_name,
            'GPU' => $this->gpu_id ? $this->gpu->name : $this->gpu_name,
            'PSU' => $this->psu_id ? $this->psu->name : $this->psu_name,
            'Motherboard' => $this->mobo_id ? $this->mobo->name : $this->mobo_name,
            'Case' => $this->case_id ? $this->case->name : $this->case_name,
            'ROM' => $this->rom_id ? $this->rom->name : $this->rom_name,
            'Garantia' => $this->warranty,
            'Envío' => $this->shipping ? 'Incluído' : 'No incluye',
            'Visacuotas' => $this->visacuotas ? 'Sí' : 'No',
            'Destacado' => $this->featured ? 'Sí' : 'No',
            'sale' => $this->sale,
            'featured' => $this->featured,
        ];
    }
}