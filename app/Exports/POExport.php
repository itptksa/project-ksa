<?php

namespace App\Exports;

use App\Models\OrderDetail;
use App\Models\OrderHead;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class POExport implements FromQuery, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable, RegistersEventListeners;

    public function __construct($order_id)
    {
        $this->order_id = $order_id;
        $this->price = OrderHead::where('order_id', $order_id)->pluck('totalPrice')[0];
        $this->invoiceAddress = OrderHead::where('order_id', $order_id)->pluck('invoiceAddress')[0];
        $this->itemAddress = OrderHead::where('order_id', $order_id)->pluck('itemAddress')[0];
        $this->cabang = OrderHead::where('order_id', $order_id)->pluck('cabang')[0];
    }

    public function query()
    {
        $orderDetail = OrderDetail::join('order_heads', 'order_details.orders_id', '=', 'order_heads.id')->join('items', 'items.id', '=', 'order_details.item_id')->where('order_heads.order_id', $this->order_id)->select('noPo', 'boatName', 'department', 'noPr', 'itemName', 'quantity', 'items.unit', 'items.serialNo', 'codeMasterItem', 'note');

        return $orderDetail;
    }

    public function headings(): array{
        return ['Nomor PO', 'Nama Kapal', 'Department', 'Nomor PR', 'Nama Barang', 'Quantity', 'Satuan', 'Serial No', 'Code Master Item', 'Note'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:J1')->applyFromArray([
                    'font' => [
                        'color' => ['argb' => 'FFFFFF']
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['argb' => 'A01D23']
                    ]

                ]);

                $event->sheet->appendRows(array(
                    array(' '),
                    array('Total Harga', 'Rp. ' . number_format($this->price, 2, ",", ".")),
                    array('Alamat Pengiriman Invoice', $this->invoiceAddress),
                    array('Alamat Pengiriman Barang', $this->itemAddress),
                    array('Cabang', $this->cabang),
                ), $event);
            }
        ];
    }
}
