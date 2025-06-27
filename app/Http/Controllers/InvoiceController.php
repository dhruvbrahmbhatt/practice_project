<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Project;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $projects = Project::all(); // for dropdown
        $invoices = Invoice::with('project')->latest()->paginate(10);
        return view('projects.index', compact('invoices', 'projects'));
    }

    public function create()
    {
        $projects = Project::all(); // for dropdown
        return view('invoice.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|unique:invoices',
            'project_id' => 'required|exists:projects,id',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.rate' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::create([
            'invoice_number' => $request->invoice_number,
            'project_id' => $request->project_id,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'tax_amount' => $request->tax_amount ?? 0,
            'discount' => $request->discount ?? 0,
            'total_amount' => 0,
            'status' => 'unpaid',
        ]);

        $total = 0;

        foreach ($request->items as $item) {
            $subtotal = $item['quantity'] * $item['rate'];
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'rate' => $item['rate'],
                'total' => $subtotal,
            ]);
            $total += $subtotal;
        }

        // Apply tax & discount
        $total += $invoice->tax_amount;
        $total -= $invoice->discount;

        $invoice->update(['total_amount' => $total]);

        return redirect()->route('invoice.index')->with('success', 'Invoice created successfully.');
    }

    public function edit(Invoice $invoice)
    {
        $projects = Project::all();
        $invoice->load('items');
        return view('invoice.edit', compact('invoice', 'projects'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.rate' => 'required|numeric|min:0',
        ]);

        $invoice->update([
            'project_id' => $request->project_id,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'tax_amount' => $request->tax_amount ?? 0,
            'discount' => $request->discount ?? 0,
        ]);

        $invoice->items()->delete();
        $total = 0;

        foreach ($request->items as $item) {
            $subtotal = $item['quantity'] * $item['rate'];
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'rate' => $item['rate'],
                'total' => $subtotal,
            ]);
            $total += $subtotal;
        }

        $total += $invoice->tax_amount;
        $total -= $invoice->discount;

        $invoice->update(['total_amount' => $total]);

        return redirect()->route('projects.index')->with('success', 'Invoice updated successfully.');
    }
}
