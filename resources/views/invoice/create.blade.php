@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($invoice) ? 'Edit' : 'Create' }} Invoice</h2>

    <form method="POST" action="{{ isset($invoice) ? route('invoices.update', $invoice) : route('invoice.store') }}">
        @csrf
        @if(isset($invoice)) @method('PUT') @endif

        <div class="mb-3">
            <label>Invoice Number</label>
            <input type="text" name="invoice_number" class="form-control" value="{{ old('invoice_number', $invoice->invoice_number ?? '') }}" {{ isset($invoice) ? 'readonly' : '' }} required>
        </div>

        <div class="mb-3">
            <label>Project</label>
            <select name="project_id" class="form-control" required>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ (old('project_id', $invoice->project_id ?? '') == $project->id) ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Invoice Date</label>
            <input type="date" name="invoice_date" class="form-control" value="{{ old('invoice_date', $invoice->invoice_date ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Due Date</label>
            <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $invoice->due_date ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Tax Amount</label>
            <input type="number" name="tax_amount" class="form-control" value="{{ old('tax_amount', $invoice->tax_amount ?? 0) }}">
        </div>

        <div class="mb-3">
            <label>Discount</label>
            <input type="number" name="discount" class="form-control" value="{{ old('discount', $invoice->discount ?? 0) }}">
        </div>

        <hr>
        <h4>Invoice Items</h4>
        <div id="items">
            @foreach(old('items', $invoice->items ?? [ ['description' => '', 'quantity' => 1, 'rate' => 0] ]) as $i => $item)
                <div class="row mb-2">
                    <div class="col">
                        <input type="text" name="items[{{ $i }}][description]" class="form-control" placeholder="Description" value="{{ $item['description'] ?? '' }}">
                    </div>
                    <div class="col">
                        <input type="number" name="items[{{ $i }}][quantity]" class="form-control" placeholder="Qty" value="{{ $item['quantity'] ?? 1 }}">
                    </div>
                    <div class="col">
                        <input type="number" name="items[{{ $i }}][rate]" class="form-control" placeholder="Rate" value="{{ $item['rate'] ?? 0 }}">
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addItem()">+ Add Item</button>

        <div>
            <button type="submit" class="btn btn-primary">{{ isset($invoice) ? 'Update' : 'Create' }}</button>
        </div>
    </form>
</div>

<script>
function addItem() {
    let index = document.querySelectorAll('#items .row').length;
    let html = `
        <div class="row mb-2">
            <div class="col"><input type="text" name="items[${index}][description]" class="form-control" placeholder="Description"></div>
            <div class="col"><input type="number" name="items[${index}][quantity]" class="form-control" placeholder="Qty" value="1"></div>
            <div class="col"><input type="number" name="items[${index}][rate]" class="form-control" placeholder="Rate" value="0"></div>
        </div>`;
    document.getElementById('items').insertAdjacentHTML('beforeend', html);
}
</script>
@endsection
