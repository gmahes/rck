<?php

namespace App\Http\Controllers;

use App\Imports\accountingExcel;
use App\Imports\coretaxExcel;
use App\Imports\invoiceBengkel;
use App\Imports\invoiceImport;
use Carbon\Carbon;
use App\Imports\xls;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Customers;
use App\Models\ITDocs;
use DOMDocument;
use App\Models\Suppliers;
use App\Models\UserDetail;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleXMLElement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\BupotList;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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
        return view('non-operasional.coretax-taxinvoice.taxinvoice', $attr);
    }
    public function convertXlsToXml()
    {
        if (request()->invoice == "imp") {
            $import = new invoiceImport;
            Excel::import($import, request()->file('file'));
            $attr = [
                'sbu' => Customers::all()->sortBy('name'),
                'invoices' => $import->data
            ];
            $this->xml = new SimpleXMLElement('<TaxInvoiceBulk xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"></TaxInvoiceBulk>');
            $this->xml->addChild('TIN', '0704142322402000');
            $this->xml->addChild('ListOfTaxInvoice');
            foreach ($attr['invoices'] as $invoice) {
                if ($invoice['status'] == 'Tidak Terdaftar') {
                    Alert::error('Gagal', 'Pelanggan ' . $invoice['nama_pelanggan'] . ' tidak terdaftar');
                    return redirect()->route('xml-coretax');
                }
                $taxInvoice = $this->xml->ListOfTaxInvoice->addChild('TaxInvoice');
                $taxInvoice->addChild('TaxInvoiceDate', $invoice['tanggal_invoice']);
                $taxInvoice->addChild('TaxInvoiceOpt', 'Normal');
                $taxInvoice->addChild('TrxCode', '05');
                $taxInvoice->addChild('AddInfo');
                $taxInvoice->addChild('CustomDoc');
                $taxInvoice->addChild('CustomDocMonthYear');
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
                if (gettype($invoice['deskripsi']) == 'string') {
                    $listOfGoodService = $goodService->addChild('GoodService');
                    $listOfGoodService->addChild('Opt', 'B');
                    $listOfGoodService->addChild('Code', '000000');
                    $listOfGoodService->addChild('Name', $invoice['deskripsi']);
                    $listOfGoodService->addChild('Unit', 'UM.0033');
                    $listOfGoodService->addChild('Price', $invoice['jumlah'] / $invoice['unit']);
                    $listOfGoodService->addChild('Qty', $invoice['unit']);
                    $listOfGoodService->addChild('TotalDiscount', '0');
                    $listOfGoodService->addChild('TaxBase', $invoice['jumlah']);
                    $listOfGoodService->addChild('OtherTaxBase', '0');
                    $listOfGoodService->addChild('VATRate', '12');
                    $listOfGoodService->addChild('VAT', rtrim(rtrim(number_format($invoice['jumlah'] * 0.011, 2, '.', ''), '0'), '.'));
                    $listOfGoodService->addChild('STLGRate', '0');
                    $listOfGoodService->addChild('STLG', '0');
                } else {
                    foreach (array_keys($invoice['deskripsi']) as $key) {
                        $listOfGoodService = $goodService->addChild('GoodService');
                        $listOfGoodService->addChild('Opt', 'B');
                        $listOfGoodService->addChild('Code', '000000');
                        $listOfGoodService->addChild('Name', $invoice['deskripsi'][$key]);
                        $listOfGoodService->addChild('Unit', 'UM.0033');
                        $listOfGoodService->addChild('Price', $invoice['jumlah'][$key] / $invoice['unit'][$key]);
                        $listOfGoodService->addChild('Qty', $invoice['unit'][$key]);
                        $listOfGoodService->addChild('TotalDiscount', '0');
                        $listOfGoodService->addChild('TaxBase', $invoice['jumlah'][$key]);
                        $listOfGoodService->addChild('OtherTaxBase', '0');
                        $listOfGoodService->addChild('VATRate', '12');
                        $listOfGoodService->addChild('VAT', rtrim(rtrim(number_format($invoice['jumlah'][$key] * 0.011, 2, '.', ''), '0'), '.'));
                        $listOfGoodService->addChild('STLGRate', '0');
                        $listOfGoodService->addChild('STLG', '0');
                    }
                }
                $attr['xml'] = $this->xml;
                $dom = new DOMDocument('1.0', 'UTF-8');
                $dom->preserveWhiteSpace = false;
                $dom->formatOutput = true;
                $dom->loadXML($attr['xml']->asXML());
            }
            return response($dom->saveXML(), 200)
                ->header('Content-Type', 'text/xml')
                ->header('Content-Disposition', 'attachment; filename="' . pathinfo(request()->file('file')->getClientOriginalName(), PATHINFO_FILENAME) . '.xml"');
        } elseif (request()->invoice == "bkl" or Auth::user()->userDetail->position == 'Admin MR') {
            $import = new invoiceBengkel;
            Excel::import($import, request()->file('file'));
            $attr = [
                'sbu' => Customers::all()->sortBy('name'),
                'invoices' => $import->data,
                'units' => [
                    'kg' => 'UM.0003',
                    'unit' => 'UM.0018',
                    'm' => 'UM.0013',
                    'set' => 'UM.0019',
                    'pcs' => 'UM.0021',
                    'ltr' => 'UM.0007',
                    'lbr' => 'UM.0020',

                ]
            ];
            $this->xml = new SimpleXMLElement('<TaxInvoiceBulk xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"></TaxInvoiceBulk>');
            $this->xml->addChild('TIN', '0704142322402000');
            $this->xml->addChild('ListOfTaxInvoice');
            foreach ($attr['invoices'] as $invoice) {
                if ($invoice['status'] == 'Tidak Terdaftar') {
                    Alert::error('Gagal', 'Pelanggan ' . $invoice['nama_pelanggan'] . ' tidak terdaftar');
                    return redirect()->route('xml-coretax');
                }
                $taxInvoice = $this->xml->ListOfTaxInvoice->addChild('TaxInvoice');
                $taxInvoice->addChild('TaxInvoiceDate', $invoice['tanggal_invoice']);
                $taxInvoice->addChild('TaxInvoiceOpt', 'Normal');
                $taxInvoice->addChild('TrxCode', '04');
                $taxInvoice->addChild('AddInfo');
                $taxInvoice->addChild('CustomDoc');
                $taxInvoice->addChild('CustomDocMonthYear');
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
                if (gettype($invoice['satuan']) == 'NULL') {
                    $otherTaxBase = intval($invoice['jumlah']) * 11 / 12;
                    $vat = $otherTaxBase * 0.12;
                    $listOfGoodService = $goodService->addChild('GoodService');
                    $listOfGoodService->addChild('Opt', 'B');
                    $listOfGoodService->addChild('Code', '000000');
                    $listOfGoodService->addChild('Name', $invoice['deskripsi']);
                    $listOfGoodService->addChild('Unit', 'UM.0033');
                    $listOfGoodService->addChild('Price', $invoice['jumlah']);
                    $listOfGoodService->addChild('Qty', $invoice['qty']);
                    $listOfGoodService->addChild('TotalDiscount', '0');
                    $listOfGoodService->addChild('TaxBase', $invoice['jumlah']);
                    $listOfGoodService->addChild('OtherTaxBase', rtrim(rtrim(number_format($otherTaxBase, 2, '.', ''), '0'), '.'));
                    $listOfGoodService->addChild('VATRate', '12');
                    $listOfGoodService->addChild('VAT', rtrim(rtrim(number_format($vat, 2, '.', ''), '0'), '.'));
                    $listOfGoodService->addChild('STLGRate', '0');
                    $listOfGoodService->addChild('STLG', '0');
                } elseif (gettype($invoice['satuan']) == 'array') {
                    foreach (array_keys($invoice['deskripsi']) as $key) {
                        $otherTaxBase = intval($invoice['jumlah'][$key]) * 11 / 12;
                        $vat = $otherTaxBase * 0.12;
                        $listOfGoodService = $goodService->addChild('GoodService');
                        $listOfGoodService->addChild('Opt', 'A');
                        $listOfGoodService->addChild('Code', '000000');
                        $listOfGoodService->addChild('Name', $invoice['deskripsi'][$key]);
                        $listOfGoodService->addChild('Unit', $attr['units'][$invoice['satuan'][$key]] ?? 'UM.0033');
                        $listOfGoodService->addChild('Price', intval($invoice['jumlah'][$key]) / floatval($invoice['qty'][$key]));
                        $listOfGoodService->addChild('Qty', $invoice['qty'][$key]);
                        $listOfGoodService->addChild('TotalDiscount', '0');
                        $listOfGoodService->addChild('TaxBase', $invoice['jumlah'][$key]);
                        $listOfGoodService->addChild('OtherTaxBase', rtrim(rtrim(number_format($otherTaxBase, 2, '.', ''), '0'), '.'));
                        $listOfGoodService->addChild('VATRate', '12');
                        $listOfGoodService->addChild('VAT
                        ', rtrim(rtrim(number_format($vat, 2, '.', ''), '0'), '.'));
                        $listOfGoodService->addChild('STLGRate', '0');
                        $listOfGoodService->addChild('STLG', '0');
                    }
                } else {
                    $otherTaxBase = intval($invoice['jumlah']) * 11 / 12;
                    $vat = $otherTaxBase * 0.12;
                    $listOfGoodService = $goodService->addChild('GoodService');
                    $listOfGoodService->addChild('Opt', 'A');
                    $listOfGoodService->addChild('Code', '000000');
                    $listOfGoodService->addChild('Name', $invoice['deskripsi']);
                    $listOfGoodService->addChild('Unit', 'UM.0033');
                    $listOfGoodService->addChild('Price', intval($invoice['jumlah']) / floatval($invoice['qty']));
                    $listOfGoodService->addChild('Qty', $invoice['qty']);
                    $listOfGoodService->addChild('TotalDiscount', '0');
                    $listOfGoodService->addChild('TaxBase', $invoice['jumlah']);
                    $listOfGoodService->addChild('OtherTaxBase', rtrim(rtrim(number_format($otherTaxBase, 2, '.', ''), '0'), '.'));
                    $listOfGoodService->addChild('VATRate', '12');
                    $listOfGoodService->addChild('VAT', rtrim(rtrim(number_format($vat, 2, '.', ''), '0'), '.'));
                    $listOfGoodService->addChild('STLGRate', '0');
                    $listOfGoodService->addChild('STLG', '0');
                }
            }
            $attr['xml'] = $this->xml;
            $dom = new DOMDocument('1.0', 'UTF-8');
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($attr['xml']->asXML());

            return response($dom->saveXML(), 200)
                ->header('Content-Type', 'text/xml')
                ->header('Content-Disposition', 'attachment; filename="' . pathinfo(request()->file('file')->getClientOriginalName(), PATHINFO_FILENAME) . '.xml"');
        } else {
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
                $taxInvoice->addChild('CustomDocMonthYear');
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
    }
    public function convertXlsToXlsx()
    {
        if (request()->invoice == "imp") {
            $import = new invoiceImport;
            Excel::import($import, request()->file('file'));
            $attr = [
                'sbu' => Customers::all()->sortBy('name'),
                'invoices' => $import->data
            ];
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'No Invoice');
            $sheet->setCellValue('B1', 'Tanggal Invoice');
            $sheet->setCellValue('C1', 'Nama Pelanggan');
            $sheet->setCellValue('D1', 'Qty');
            $sheet->setCellValue('E1', 'Deskripsi');
            $sheet->setCellValue('F1', 'DPP');
            $sheet->setCellValue('G1', 'PPN 1,1%');

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
                if (gettype($invoice['deskripsi']) == 'string') {
                    $ppn = $invoice['jumlah'] * 0.011;
                    $sheet->setCellValue('A' . $row, $invoice['no_invoice']);
                    $sheet->setCellValue('B' . $row, Carbon::parse($invoice['tanggal_invoice'])->translatedFormat('d-m-Y'));
                    $sheet->setCellValue('C' . $row, $invoice['nama_pelanggan']);
                    $sheet->setCellValue('D' . $row, $invoice['unit']);
                    $sheet->setCellValue('E' . $row, $invoice['deskripsi']);
                    $sheet->setCellValue('F' . $row, number_format($invoice['jumlah'], 0, '.', ','));
                    $sheet->setCellValue('G' . $row, number_format($ppn, 0, '.', ','));
                    $row++;
                } else {
                    foreach (array_keys($invoice['deskripsi']) as $key) {
                        $sumJumlah = array_sum($invoice['jumlah']);
                        $sumPPn = $sumJumlah * 0.011;
                        // dd($sumPPn);
                        $sheet->setCellValue('A' . $row, $invoice['no_invoice']);
                        $sheet->setCellValue('B' . $row, Carbon::parse($invoice['tanggal_invoice'])->translatedFormat('d-m-Y'));
                        $sheet->setCellValue('C' . $row, $invoice['nama_pelanggan']);
                        $sheet->setCellValue('D' . $row, $invoice['unit'][$key]);
                        $sheet->setCellValue('E' . $row, $invoice['deskripsi'][$key]);
                        $sheet->setCellValue('F' . $row, number_format($invoice['jumlah'][$key], 0, '.', ','));
                        $sheet->setCellValue('G' . $row, number_format($invoice['jumlah'][$key] * 0.011, 2, '.', ','));
                        $row++;
                    }
                    //Total
                    $sheet->mergeCells('A' . $row . ':E' . $row);
                    $sheet->setCellValue('A' . $row, 'Total');
                    $sheet->getStyle('A' . $row)->getFont()->setBold(true);
                    $sheet->setCellValue('F' . $row, number_format($sumJumlah, 0, '.', ','));
                    $sheet->setCellValue('G' . $row, number_format($sumPPn, 0, '.', ','));
                    $sheet->getStyle('F' . $row . ':G' . $row)->getFont()->setBold(true);
                    $sheet->mergeCells('A' . ($row - count($invoice['deskripsi'])) . ':A' . ($row - 1));
                    $sheet->mergeCells('B' . ($row - count($invoice['deskripsi'])) . ':B' . ($row - 1));
                    $sheet->mergeCells('C' . ($row - count($invoice['deskripsi'])) . ':C' . ($row - 1));
                    $sheet->getStyle('A' . ($row - count($invoice['deskripsi'])) . ':A' . ($row - 1))
                        ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('B' . ($row - count($invoice['deskripsi'])) . ':B' . ($row - 1))
                        ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('C' . ($row - count($invoice['deskripsi'])) . ':C' . ($row - 1))
                        ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                }
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
        } elseif (request()->invoice == 'bkl' or Auth::user()->userDetail->position == 'Admin MR') {
            $import = new invoiceBengkel;
            Excel::import($import, request()->file('file'));
            $attr = [
                'sbu' => Customers::all()->sortBy('name'),
                'invoices' => $import->data,
                'units' => [
                    'kg' => 'UM.0003',
                    'unit' => 'UM.0018',
                    'm' => 'UM.0013',
                    'set' => 'UM.0019',
                    'pcs' => 'UM.0021',
                    'ltr' => 'UM.0007',
                    'lbr' => 'UM.0020',

                ]
            ];
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'No Invoice');
            $sheet->setCellValue('B1', 'Tanggal Invoice');
            $sheet->setCellValue('C1', 'Nama Pelanggan');
            $sheet->setCellValue('D1', 'Qty');
            $sheet->setCellValue('E1', 'Deskripsi');
            $sheet->setCellValue('F1', 'DPP');
            $sheet->setCellValue('G1', 'DPP Nilai Lain');
            $sheet->setCellValue('H1', 'PPN 11%');

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
            $sheet->getStyle('A1:H1')->applyFromArray($headerStyleArray);

            $row = 2;
            foreach ($attr['invoices'] as $invoice) {
                if ($invoice['status'] == 'Tidak Terdaftar') {
                    Alert::error('Gagal', 'Pelanggan ' . $invoice['nama_pelanggan'] . ' tidak terdaftar');
                    return redirect()->route('xml-coretax');
                }
                if (gettype($invoice['deskripsi']) == 'string') {
                    $otherTaxBase = intval($invoice['jumlah']) * 11 / 12;
                    $vat = $otherTaxBase * 0.12;
                    $sheet->setCellValue('A' . $row, $invoice['no_invoice']);
                    $sheet->setCellValue('B' . $row, Carbon::parse($invoice['tanggal_invoice'])->translatedFormat('d-m-Y'));
                    $sheet->setCellValue('C' . $row, $invoice['nama_pelanggan']);
                    $sheet->setCellValue('D' . $row, $invoice['qty']);
                    $sheet->setCellValue('E' . $row, $invoice['deskripsi']);
                    $sheet->setCellValue('F' . $row, number_format($invoice['jumlah'], 0, '.', ','));
                    $sheet->setCellValue('G' . $row, number_format($otherTaxBase, 2, '.', ','));
                    $sheet->setCellValue('H' . $row, number_format($vat, 0, '.', ','));
                    $row++;
                    $sheet->mergeCells('A' . $row . ':H' . $row);
                } else {
                    foreach (array_keys($invoice['deskripsi']) as $key) {
                        $otherTaxBase = intval($invoice['jumlah'][$key]) * 11 / 12;
                        $vat = $otherTaxBase * 0.12;
                        $sheet->setCellValue('A' . $row, $invoice['no_invoice']);
                        $sheet->setCellValue('B' . $row, Carbon::parse($invoice['tanggal_invoice'])->translatedFormat('d-m-Y'));
                        $sheet->setCellValue('C' . $row, $invoice['nama_pelanggan']);
                        $sheet->setCellValue('D' . $row, $invoice['qty'][$key]);
                        $sheet->setCellValue('E' . $row, $invoice['deskripsi'][$key]);
                        $sheet->setCellValue('F' . $row, number_format($invoice['jumlah'][$key], 0, '.', ','));
                        $sheet->setCellValue('G' . $row, number_format($otherTaxBase, 2, '.', ','));
                        $sheet->setCellValue('H' . $row, number_format($vat, 0, '.', ','));
                        $row++;
                    }
                    //Total
                    $sheet->mergeCells('A' . $row . ':E' . $row);
                    $sheet->setCellValue('A' . $row, 'Total');
                    $sheet->getStyle('A' . $row)->getFont()->setBold(true);
                    $sheet->setCellValue('F' . $row, number_format(array_sum($invoice['jumlah']), 0, '.', ','));
                    $sheet->setCellValue('G' . $row, number_format(array_sum($invoice['jumlah']) * 11 / 12, 2, '.', ','));
                    $sheet->setCellValue('H' . $row, number_format(array_sum($invoice['jumlah']) * 0.011, 0, '.', ','));
                    $sheet->getStyle('F' . $row . ':H' . $row)->getFont()->setBold(true);
                    $sheet->mergeCells('A' . ($row - count($invoice['deskripsi'])) . ':A' . ($row - 1));
                    $sheet->mergeCells('B' . ($row - count($invoice['deskripsi'])) . ':B' . ($row - 1));
                    $sheet->mergeCells('C' . ($row - count($invoice['deskripsi'])) . ':C' . ($row - 1));
                    $sheet->getStyle('A' . ($row - count($invoice['deskripsi'])) . ':A' . ($row - 1))
                        ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('B' . ($row - count($invoice['deskripsi'])) . ':B' . ($row - 1))
                        ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('C' . ($row - count($invoice['deskripsi'])) . ':C' . ($row - 1))
                        ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $row++;
                    $sheet->mergeCells('A' . $row . ':H' . $row);
                }
                $row++;
            }

            // Auto size columns to fit content
            foreach (range('A', 'H') as $columnID) {
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
            $sheet->getStyle('A1:H' . ($row - 1))->applyFromArray($styleArray);

            // Center align all cells and set font to Calibri with size 11
            $sheet->getStyle('A1:H' . ($row - 1))->applyFromArray([
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
        } else {
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
            $sheet->setCellValue('D1', 'DPP');
            $sheet->setCellValue('E1', 'DPP Nilai Lain');
            $sheet->setCellValue('F1', 'PPN 11%');

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
            $sheet->getStyle('A1:F1')->applyFromArray($headerStyleArray);

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
                $sheet->setCellValue('D' . $row, number_format($invoice['sub_total'], 0, '.', ','));
                $sheet->setCellValue('E' . $row, number_format($otherTaxBase, 2, '.', ','));
                $sheet->setCellValue('F' . $row, number_format($vat, 0, '.', ','));

                $row++;
            }

            // Auto size columns to fit content
            foreach (range('A', 'F') as $columnID) {
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
            $sheet->getStyle('A1:F' . ($row - 1))->applyFromArray($styleArray);

            // Center align all cells and set font to Calibri with size 11
            $sheet->getStyle('A1:F' . ($row - 1))->applyFromArray([
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
        return view('non-operasional.coretax-taxinvoice.taxinvoice-table', $attr);
    }
    public function bupot()
    {
        $attr = [
            'title' => 'Bupot PPh',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'supplier' => Suppliers::all()->sortBy('name'),
        ];
        return view('non-operasional.coretax-bupot.bupot', $attr);
    }
    public function saveBupot()
    {
        $validator = Validator::make(request()->all(), [
            'supplier' => 'required',
            'date' => 'required',
            'docId' => 'required',
            'dpp' => 'required',
        ], [
            'supplier.required' => 'Supplier wajib diisi',
            'date.required' => 'Tanggal
            wajib diisi',
            'docId.required' => 'Nomor Dokumen wajib diisi
            ',
            'dpp.required' => 'DPP wajib diisi',
        ]);
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('bupot');
        }
        $validated = $validator->validated();
        $bupotList = [
            'id' => Str::uuid7(),
            'supplier_id' => $validated['supplier'],
            'date' => $validated['date'],
            'docId' => $validated['docId'],
            'dpp' => $validated['dpp'],
            'pph' => number_format(intval(preg_replace('/[^0-9]/', '', $validated['dpp'])) * Suppliers::find($validated['supplier'])->percentage / 100, 0, '', '.'),
            'whdate' => $validated['date'],
        ];
        BupotList::create($bupotList);
        Alert::toast('Data berhasil disimpan', 'success');
        return redirect()->route('bupot');
    }
    public function editBupot($id)
    {
        $validator = Validator::make(request()->all(), [
            'date' => 'required',
            'docId' => 'required',
            'dpp' => 'required',
        ], [
            'date.required' => 'Tanggal wajib diisi',
            'docId.required' => 'Nomor Dokumen wajib diisi',
            'dpp.required' => 'DPP wajib diisi',
        ]);
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('bupot');
        }
        $validated = $validator->validated();
        $bupotList = [
            'date' => $validated['date'],
            'docId' => $validated['docId'],
            'dpp' => $validated['dpp'],
            'pph' => number_format(intval(preg_replace('/[^0-9]/', '', $validated['dpp'])) * intval(request()->percentage) / 100, 0, '', '.'),
            'whdate' => $validated['date'],
        ];
        BupotList::where('id', $id)->update($bupotList);
        Alert::toast('Data berhasil diubah', 'success');
        return redirect()->route('bupot');
    }
    public function filterBupot()
    {
        $attr = [
            'title' => 'Bupot PPh',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'bupots' => BupotList::all()->whereBetween('date', [request()->start_date, Carbon::parse(request()->end_date)->setTime(23, 59, 59)])->sortBy('date'),
        ];
        if (count($attr['bupots']) == 0) {
            Alert::error('Gagal', 'Data tidak ditemukan');
            return redirect()->route('bupot');
        }
        $document = [
            'TaxInvoice' => 'Faktur Pajak',
            'PaymentProof' => 'Bukti Pembayaran',
        ];
        $facility = [
            'N/A' => 'Tanpa Fasilitas',
            'TaxExAr22' => 'SKB PPh Pasal 22',
            'TaxExAr23' => 'SKB PPh Pasal 23',
            'PP23' => 'SK PP 23/2018'
        ];
        session([
            'start_date' => request()->start_date,
            'end_date' => request()->end_date,
        ]);
        foreach ($attr['bupots'] as $bupot) {
            $bupot->supplier->document = $document[$bupot->supplier->document];
            $bupot->supplier->facility = $facility[$bupot->supplier->facility];
        }
        return view('non-operasional.coretax-bupot.bupotTable', $attr);
    }
    public function deleteBupot($id)
    {
        BupotList::find($id)->delete();
        Alert::toast('Data berhasil dihapus', 'success');
        return redirect()->route('bupot');
    }
    public function xmlBupot()
    {
        $attr = [
            'title' => 'Bupot PPh',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'bupots' => BupotList::all()->whereBetween('date', [request()->start_date, Carbon::parse(request()->end_date)->setTime(23, 59, 59)])->sortBy('date'),
        ];
        if (count($attr['bupots']) == 0) {
            Alert::error('Gagal', 'Data tidak ditemukan');
            return redirect()->route('bupot');
        }
        $tin = '0704142322402000';
        $this->xml = new SimpleXMLElement('<BpuBulk xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="schema.xsd"></BpuBulk>');
        $this->xml->addChild('TIN', $tin);
        $this->xml->addChild('ListOfBpu');
        foreach ($attr['bupots'] as $bupot) {
            $taxBase = intval(preg_replace('/[^0-9]/', '', $bupot->dpp));
            $bpu = $this->xml->ListOfBpu->addChild('Bpu');
            $bpu->addChild('TaxPeriodMonth', Carbon::parse($bupot->whdate)->format('n'));
            $bpu->addChild('TaxPeriodYear', Carbon::parse($bupot->whdate)->format('Y'));
            $bpu->addChild('CounterpartTin', $bupot->supplier_id);
            $bpu->addChild('IDPlaceOfBusinessActivityOfIncomeRecipient', $bupot->supplier_id . '000000');
            $bpu->addChild('TaxCertificate', $bupot->supplier->facility);
            $bpu->addChild('TaxObjectCode', $bupot->supplier->code);
            $bpu->addChild('TaxBase', $taxBase);
            $bpu->addChild('Rate', $bupot->supplier->percentage);
            $bpu->addChild('Document', $bupot->supplier->document);
            $bpu->addChild('DocumentNumber', $bupot->docId);
            $bpu->addChild('DocumentDate', $bupot->date);
            $bpu->addChild('IDPlaceOfBusinessActivity', $tin . '000000');
            $bpu->addChild('GovTreasurerOpt', 'N/A');
            $bpu->addChild('SP2DNumber');
            $bpu->addChild('WithholdingDate', $bupot->whdate);
        }
        $attr['xml'] = $this->xml;
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        $dom->loadXML($attr['xml']->asXML());

        return response($dom->saveXML(), 200)
            ->header('Content-Type', 'text/xml')
            ->header('Content-Disposition', 'attachment; filename="Bupot ' . Carbon::parse(session('start_date'))->format('d M Y') . ' - ' . Carbon::parse(session('end_date'))->format('d M Y') . '.xml"');
    }
    private function generateKodeDokumentasi()
    {
        $tanggal = now()->format('ymd'); // Hasil: 240514
        $prefix = "IT-RCK/{$tanggal}/";

        // Hitung jumlah entri hari ini
        $count = ITDocs::where('troubleID', 'like', $prefix . '%')->count();

        // Nomor urut + 1, dengan padding 3 digit (001, 002, dst)
        $urut = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        return $prefix . $urut; // Contoh: IT-RCK/240514/001
    }
    public function itdocs()
    {
        $attr = [
            'title' => 'Dokumentasi IT',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'employees' => UserDetail::whereHas('userAuth', function ($query) {
                $query->where('role', '!=', 'superadmin');
            })->orderBy('fullname')->get(),
            'troubles' => ITDocs::all()->sortBy('created_at'),
        ];
        $dateCode = date('ymd');
        $prefix = 'IT-RCK/' . $dateCode . '/';

        $lastKode = ITDocs::where('troubleID', 'like', $prefix . '%')
            ->orderBy('troubleID', 'desc')
            ->value('troubleID');

        if ($lastKode) {
            $lastNumber = (int) substr($lastKode, -3);
            $urut = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $urut = '001';
        }
        $troubleID = $prefix . $urut;
        $attr['troubleID'] = $troubleID;
        return view('non-operasional.itdocs.itdocs', $attr);
    }
    public function saveITDocs()
    {
        $validator = Validator::make(request()->all(), [
            'user' => 'required',
            'devices' => 'required',
            'trouble' => 'required',
            'status' => 'required',
            'photo' => 'mimes:jpeg,jpg,png|max:2048',
        ], [
            'user.required' => 'Nama Karyawan wajib diisi',
            'devices.required' => 'Sistem wajib diisi',
            'trouble.required' => 'Masalah wajib diisi',
            'status.required' => 'Status wajib diisi',
            'photo.mimes' => 'File harus berupa gambar (jpeg, jpg, png)',
        ]);
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('itdocs');
        }
        $validated = $validator->validated();
        $itdocs = [
            'nik' => $validated['user'],
            'devices' => $validated['devices'],
            'trouble' => $validated['trouble'],
            'status' => $validated['status'],
            'photo' => request()->hasFile('photo') ? request()->file('photo')->storeAs('itdocs', Str::uuid()->toString() . '.' . request()->file('photo')->getClientOriginalExtension(), 'public') : null,
            'action' => request()->has('action') ? request()->action : null,
            'created_by' => Auth::user()->username,
        ];
        // dd($itdocs);
        ITDocs::create($itdocs);
        Alert::toast('Data berhasil disimpan', 'success');
        return redirect()->route('itdocs');
    }
    public function deleteITDocs()
    {
        ITDocs::where('troubleID', request()->troubleID)->delete();
        Alert::toast('Data berhasil dihapus', 'success');
        return redirect()->route('itdocs');
    }
    public function editITDocs()
    {
        $validator = Validator::make(request()->all(), [
            'user' => 'required',
            'devices' => 'required',
            'trouble' => 'required',
            'status' => 'required',
            'photo' => 'mimes:jpeg,jpg,png|max:2048',
        ], [
            'user.required' => 'Nama Karyawan wajib diisi',
            'devices.required' => 'Sistem wajib diisi',
            'trouble.required' => 'Masalah wajib diisi',
            'status.required' => 'Status wajib diisi',
            'photo.mimes' => 'File harus berupa gambar (jpeg, jpg, png)',
        ]);
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('itdocs');
        }
        $validated = $validator->validated();
        $itdocsToUpdate = ITDocs::where('troubleID', request()->troubleID)->first();
        $itdocs = [
            'nik' => $validated['user'],
            'devices' => $validated['devices'],
            'trouble' => $validated['trouble'],
            'status' => $validated['status'],
            'action' => request()->has('action') ? request()->action : null,
        ];
        if (request()->hasFile('photo')) {
            // Jika ada foto baru diupload:
            // Hapus foto lama jika ada dan file-nya benar-benar ada di storage
            if ($itdocsToUpdate->photo && Storage::disk('public')->exists($itdocsToUpdate->photo)) {
                Storage::disk('public')->delete($itdocsToUpdate->photo);
            }
            // Simpan foto baru
            $photoPath = request()->file('photo')->storeAs('itdocs', Str::uuid()->toString() . '.' . request()->file('photo')->getClientOriginalExtension(), 'public');
            $itdocs['photo'] = $photoPath;
        } else {
            // Jika tidak ada foto baru diupload:
            // Pertahankan foto yang sudah ada di database dengan mengambil dari model yang diambil
            $itdocs['photo'] = $itdocsToUpdate->photo;
        }
        ITDocs::where('troubleID', request()->troubleID)->update($itdocs);
        Alert::toast('Data berhasil diubah', 'success');
        return redirect()->route('itdocs');
    }
}
