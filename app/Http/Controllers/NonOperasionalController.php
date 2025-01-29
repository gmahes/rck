<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Imports\xls;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Customers;
use DOMDocument;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use SimpleXMLElement;
use Illuminate\Support\Facades\Auth;


class NonOperasionalController extends Controller
{
    private $xml;
    public function xmlCoretax()
    {
        $attr = [
            'title' => 'XML Coretax',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'sbu' => Customers::all()->sortBy('name')
        ];
        return view('non-operasional.upxls', $attr);
    }
    public function convertXlsToXml()
    {
        $import = new xls;
        Excel::import($import, request()->file('file'));
        $attr = [
            'title' => 'XML Coretax',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'sbu' => Customers::all()->sortBy('name'),
            'invoices' => $import->data
        ];
        $this->xml = new SimpleXMLElement('<TaxInvoiceBulk xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"></TaxInvoiceBulk>');
        $this->xml->addChild('TIN', '0704142322402000');
        $this->xml->addChild('ListOfTaxInvoice');
        foreach ($attr['invoices'] as $invoice) {
            if ($invoice['status'] == 'Tidak Terdaftar') {
                Alert::error('Gagal', 'Pelanggan ' . $invoice['pelanggan'] . ' tidak terdaftar');
                return redirect()->route('xml-coretax');
            }
            $date = Carbon::createFromFormat('d/m/Y', $invoice['tgl_invoice'])->format('Y-m-d');
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
}
