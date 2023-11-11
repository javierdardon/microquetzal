<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Código' => $this->id,
            'id' => $this->id,
            'Nombre' => $this->name,
            'Imagen' => $this->images,
            'Oferta' => $this->percentage ? "{$this->percentage}%" : 'No',
            'Precio Efectivo' => 'Q.'.number_format($this->price,2),
            'Precio Normal' => 'Q.'.number_format($this->normal_price,2),
            'Precio Oferta' => 'Q.'.number_format($this->sale_price,2),
            'Precio Normal Oferta' => 'Q.'.number_format($this->sale_normal_price,2),
            'show_price' => 'Q.'.number_format($this->show_price,2),
            'Categoria' => $this->category->name,
            'Marca' => $this->brand->name,
            'Existencias' => $this->quantity,
            'Descripcion' => $this->description,
            'Garantía' => $this->warranty,
            'Estado' => $this->condition,
            'Visacuotas' => $this->visacuotas ? 'Sí' : 'No',
            'Envío' => $this->shipping ? 'Incluído' : 'No incluye',
            'Destacado' => $this->featured ? 'Sí' : 'No',
            'featured' => $this->featured,
            'sale' => $this->sale,
        ];
    }
}
