<?php

namespace App\Http\Controllers;

use App\Imports\accountingExcel;
use App\Imports\coretaxExcel;
use App\Imports\invoiceImport;
use Carbon\Carbon;
use App\Imports\xls;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Customers;
use DOMDocument;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleXMLElement;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class NonOperasionalController extends Controller
{
    private $xml;
    public function xmlCoretax()
    {
        $attr = [
            'title' => 'Fitur Coretax',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'sbu' => Customers::all()->sortBy('name')
        ];
        return view('non-operasional.upxls', $attr);
    }
    public function convertXlsToXml()
    {
        if (request()->invoiceImport == "true") {
            $import = new invoiceImport;
            Excel::import($import, request()->file('file'));
            $attr = [
                'sbu' => Customers::all()->sortBy('name'),
                'invoices' => $import->data
            ];
            $this->xml = new SimpleXMLElement('<TaxInvoiceBulk xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"></TaxInvoiceBulk>');
            $this->xml->addChild('TIN', '0704142322402000');
            $this->xml->addChild('ListOfTaxInvoice');
            $taxInvoice = $this->xml->ListOfTaxInvoice->addChild('TaxInvoice');
            foreach ($attr['invoices'] as $invoice) {
                if ($invoice['status'] == 'Tidak Terdaftar') {
                    Alert::error('Gagal', 'Pelanggan ' . $invoice['nama_pelanggan'] . ' tidak terdaftar');
                    return redirect()->route('xml-coretax');
                }
                $taxInvoice->addChild('TaxInvoiceDate', $invoice['tanggal_invoice']);
                $taxInvoice->addChild('TaxInvoiceOpt', 'Normal');
                $taxInvoice->addChild('TrxCode', '05');
                $taxInvoice->addChild('AddInfo');
                $taxInvoice->addChild('CustomDoc');
                $taxInvoice->addChild('RefDesc', $invoice['no_invoice']);
                $taxInvoice->addChild('FacilityStamp');
                $taxInvoice->addChild('SellerIDTKU', '0704142322402000000000');
                foreach ($attr['sbu'] as $sbu) {
                    if ($sbu->name == $invoice['nama_pelanggan']) {
                        if ($sbu->type == 'NPWP') {
                            $taxInvoice->addChild('BuyerTin', $sbu->id);
                            $taxInvoice->addChild('BuyerDocument', 'TIN');
                            $taxInvoice->addChild('BuyerCountry', 'IDN');
                            $taxInvoice->addChild('BuyerDocumentNumber', '-');
                            $taxInvoice->addChild('BuyerName', $sbu->name);
                            $taxInvoice->addChild('BuyerAdress', $sbu->address);
                            $taxInvoice->addChild('BuyerEmail');
                            $taxInvoice->addChild('BuyerIDTKU', $sbu->id . '000000');
                        } else {
                            $taxInvoice->addChild('BuyerTin', '0000000000000000');
                            $taxInvoice->addChild('BuyerDocument', 'National ID');
                            $taxInvoice->addChild('BuyerCountry', 'IDN');
                            $taxInvoice->addChild('BuyerDocumentNumber', $sbu->id);
                            $taxInvoice->addChild('BuyerName', $sbu->name);
                            $taxInvoice->addChild('BuyerAdress', $sbu->address);
                            $taxInvoice->addChild('BuyerEmail');
                            $taxInvoice->addChild('BuyerIDTKU', '000000');
                        }
                    }
                }
                $goodService = $taxInvoice->addChild('ListOfGoodService');
                foreach (array_keys($invoice['deskripsi']) as $deskripsi) {
                    $listOfGoodService = $goodService->addChild('GoodService');
                    $listOfGoodService->addChild('Opt', 'B');
                    $listOfGoodService->addChild('Code', '000000');
                    $listOfGoodService->addChild('Name', $invoice['deskripsi'][$deskripsi]);
                    $listOfGoodService->addChild('Unit', 'UM.0033');
                    $listOfGoodService->addChild('Price', $invoice['jumlah'][$deskripsi] / $invoice['unit'][$deskripsi]);
                    $listOfGoodService->addChild('Qty', $invoice['unit'][$deskripsi]);
                    $listOfGoodService->addChild('TotalDiscount', '0');
                    $listOfGoodService->addChild('TaxBase', $invoice['jumlah'][$deskripsi]);
                    $listOfGoodService->addChild('OtherTaxBase', '0');
                    $listOfGoodService->addChild('VATRate', 12);
                    $listOfGoodService->addChild('VAT', $invoice['jumlah'][$deskripsi] * 0.011);
                    $listOfGoodService->addChild('STLGRate', '0');
                    $listOfGoodService->addChild('STLG', '0');
                }
                // dd($this->xml);
                $attr['xml'] = $this->xml;
                $dom = new DOMDocument('1.0', 'UTF-8');
                $dom->preserveWhiteSpace = false;
                $dom->formatOutput = true;
                $dom->loadXML($attr['xml']->asXML());

                return response($dom->saveXML(), 200)
                    ->header('Content-Type', 'text/xml')
                    ->header('Content-Disposition', 'attachment; filename="' . pathinfo(request()->file('file')->getClientOriginalName(), PATHINFO_FILENAME) . '.xml"');
            }
        }
        $import = new xls;
        Excel::import($import, request()->file('file'));
        $attr = [
            'sbu' => Customers::all()->sortBy('name'),
            'invoices' => $import->data
        ];
        $this->xml = new SimpleXMLElement('<TaxInvoiceBulk xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"></TaxInvoiceBulk>');
        $this->xml->addChild('TIN', '0704142322402000');
        $this->xml->addChild('ListOfTaxInvoice');
        foreach ($attr['invoices'] as $invoice) {
            if ($invoice['pelanggan'] == 'PELANGGAN') {
                continue;
            }
            if ($invoice['status'] == 'Tidak Terdaftar') {
                Alert::error('Gagal', 'Pelanggan ' . $invoice['pelanggan'] . ' tidak terdaftar');
                return redirect()->route('xml-coretax');
            }
            if (gettype($invoice['tgl_invoice']) == 'integer') {
                $date = Date::excelToDateTimeObject($invoice['tgl_invoice'])->format('Y-d-m');
            } else {
                $date = Carbon::createFromFormat('d/m/Y', $invoice['tgl_invoice'])->format('Y-m-d');
            }
            $otherTaxBase = intval($invoice['sub_total']) * 11 / 12;
            $vat = $otherTaxBase * 0.12;
            $taxInvoice = $this->xml->ListOfTaxInvoice->addChild('TaxInvoice');
            $taxInvoice->addChild('TaxInvoiceDate', $date);
            $taxInvoice->addChild('TaxInvoiceOpt', 'Normal');
            $taxInvoice->addChild('TrxCode', '08');
            $taxInvoice->addChild('AddInfo', 'TD.00510');
            $taxInvoice->addChild('CustomDoc', 'INVOICE');
            $taxInvoice->addChild('RefDesc', $invoice['no_invoice']);
            $taxInvoice->addChild('FacilityStamp', 'TD.01110');
            $taxInvoice->addChild('SellerIDTKU', '0704142322402000000000');
            foreach ($attr['sbu'] as $sbu) {
                if ($sbu->name == $invoice['pelanggan']) {
                    if ($sbu->type == 'NPWP') {
                        $taxInvoice->addChild('BuyerTin', $sbu->id);
                        $taxInvoice->addChild('BuyerDocument', 'TIN');
                        $taxInvoice->addChild('BuyerCountry', 'IDN');
                        $taxInvoice->addChild('BuyerDocumentNumber', '-');
                        $taxInvoice->addChild('BuyerName', $sbu->name);
                        $taxInvoice->addChild('BuyerAdress', $sbu->address);
                        $taxInvoice->addChild('BuyerEmail');
                        $taxInvoice->addChild('BuyerIDTKU', $sbu->id . '000000');
                    } else {
                        $taxInvoice->addChild('BuyerTin', '0000000000000000');
                        $taxInvoice->addChild('BuyerDocument', 'National ID');
                        $taxInvoice->addChild('BuyerCountry', 'IDN');
                        $taxInvoice->addChild('BuyerDocumentNumber', $sbu->id);
                        $taxInvoice->addChild('BuyerName', $sbu->name);
                        $taxInvoice->addChild('BuyerAdress', $sbu->address);
                        $taxInvoice->addChild('BuyerEmail');
                        $taxInvoice->addChild('BuyerIDTKU', '000000');
                    }
                }
            }
            $listOfGoodService = $taxInvoice->addChild('ListOfGoodService')->addChild('GoodService');
            $listOfGoodService->addChild('Opt', 'B');
            $listOfGoodService->addChild('Code', '060000');
            $listOfGoodService->addChild('Name', 'BIAYA ONGKOS ANGKUT');
            $listOfGoodService->addChild('Unit', 'UM.0030');
            $listOfGoodService->addChild('Price', $invoice['sub_total']);
            $listOfGoodService->addChild('Qty', '1');
            $listOfGoodService->addChild('TotalDiscount', '0');
            $listOfGoodService->addChild('TaxBase', $invoice['sub_total']);
            $listOfGoodService->addChild('OtherTaxBase', rtrim(rtrim(number_format($otherTaxBase, 2, '.', ''), '0'), '.'));
            $listOfGoodService->addChild('VATRate', '12');
            $listOfGoodService->addChild('VAT', rtrim(rtrim(number_format($vat, 2, '.', ''), '0'), '.'));
            $listOfGoodService->addChild('STLGRate', '0');
            $listOfGoodService->addChild('STLG', '0');
        }
        $attr['xml'] = $this->xml;
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($attr['xml']->asXML());

        return response($dom->saveXML(), 200)
            ->header('Content-Type', 'text/xml')
            ->header('Content-Disposition', 'attachment; filename="' . pathinfo(request()->file('file')->getClientOriginalName(), PATHINFO_FILENAME) . '.xml"');
    }
    public function convertXlsToXlsx()
    {
        $import = new xls;
        Excel::import($import, request()->file('file'));
        $attr = [
            'sbu' => Customers::all()->sortBy('name'),
            'invoices' => array_reverse($import->data)
        ];
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No Invoice');
        $sheet->setCellValue('B1', 'Pelanggan');
        $sheet->setCellValue('C1', 'Tanggal Invoice');
        $sheet->setCellValue('D1', 'Harga Satuan');
        $sheet->setCellValue('E1', 'DPP');
        $sheet->setCellValue('F1', 'DPP Nilai Lain');
        $sheet->setCellValue('G1', 'PPn');

        // Set header with bold text, center text, and font size 11
        $headerStyleArray = [
            'font' => [
                'bold' => true,
                'size' => 11,
                'name' => 'Calibri',
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyleArray);

        $row = 2;
        foreach ($attr['invoices'] as $invoice) {
            if ($invoice['pelanggan'] == 'PELANGGAN') {
                continue;
            }
            if (gettype($invoice['tgl_invoice']) == 'integer') {
                $date = Date::excelToDateTimeObject($invoice['tgl_invoice'])->format('m-d-Y');
            } else {
                $date = Carbon::createFromFormat('d/m/Y', $invoice['tgl_invoice'])->format('d-m-Y');
            }
            $otherTaxBase = intval($invoice['sub_total']) * 11 / 12;
            $vat = $otherTaxBase * 0.12;

            $sheet->setCellValue('A' . $row, $invoice['no_invoice']);
            $sheet->setCellValue('B' . $row, $invoice['pelanggan']);
            $sheet->setCellValue('C' . $row, $date);
            $sheet->setCellValue('D' . $row, number_format($invoice['sub_total'], 2, ',', '.'));
            $sheet->setCellValue('E' . $row, number_format($invoice['sub_total'], 2, ',', '.'));
            $sheet->setCellValue('F' . $row, number_format($otherTaxBase, 2, ',', '.'));
            $sheet->setCellValue('G' . $row, number_format($vat, 2, ',', '.'));

            $row++;
        }

        // Auto size columns to fit content
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Add border to cells
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $sheet->getStyle('A1:G' . ($row - 1))->applyFromArray($styleArray);

        // Center align all cells and set font to Calibri with size 11
        $sheet->getStyle('A1:G' . ($row - 1))->applyFromArray([
            'font' => [
                'name' => 'Calibri',
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Set print settings
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set repeating rows for print title
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = storage_path('app/public/' . pathinfo(request()->file('file')->getClientOriginalName(), PATHINFO_FILENAME) . '.xlsx');
        $writer->save($filename);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
    public function taxInvoiceCorrection()
    {
        $coretaxExcel = new coretaxExcel;
        $accountingExcel = new accountingExcel;
        Excel::import($accountingExcel, request()->file('accountingExcel'));
        Excel::import($coretaxExcel, request()->file('coretaxExcel'));
        $coretax = collect($coretaxExcel->data)->sortBy(['sub_total', 'no_invoice'])->values()->all();
        $accounting = collect($accountingExcel->data)->sortBy(['sub_total', 'no_invoice'])->values()->all();
        $attr = [
            'title' => 'Fitur Coretax',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'sbu' => Customers::all()->sortBy('name'),
            'coretax' => $coretax,
            'accounting' => $accounting,
        ];
        return view('non-operasional.upxlstable', $attr);
    }
}
