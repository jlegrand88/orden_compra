<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    protected $primaryKey = 'id_orden_compra';
    protected $table = 'orden_compra';

    public function listar()
    {
        $ocs = $this::all();
        $response = array();
        $i = 0;
        foreach ($ocs as $oc)
        {
            $response[$i]['id_orden_compra'] = $oc->id_orden_compra;
            $response[$i]['created_at'] = $oc->created_at->format('d-m-Y');
            $response[$i]['proveedor'] = Proveedor::find($oc->id_proveedor)->nombre;
            $detalles = DetalleOrdenCompra::all()->where('id_orden_compra',$oc->id_orden_compra);
            $bruto = 0;
            foreach ($detalles as $detalle)
            {
                $bruto = $bruto + $detalle->valor_total;
            }
            $response[$i]['valor_neto'] = (int)($bruto * 1.19);
            $response[$i]['iva'] = (int)($bruto * 0.19);
            $response[$i]['bruto'] = $bruto;
            $response[$i]['cotizacion1'] = $oc->cotizacion1;
            $response[$i]['cotizacion2'] = $oc->cotizacion2;
            $response[$i]['cotizacion3'] = $oc->cotizacion3;
            $response[$i]['autorizada'] = ($oc->autorizada) ? 'SI' : 'NO';
//            $response[$i]['facturada'] = $oc->facturada;
            $response[$i]['facturada'] = '';
//            $response[$i]['fecha_facturacion'] = $oc->fecha_facturacion;
            $response[$i]['fecha_facturacion'] = '';
            $response[$i]['comentario'] = $oc->observacion;
            $i++;
        }
        return $response;
    }
}
