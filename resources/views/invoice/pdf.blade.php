<h2>Invoice #{{ $invoice->invoice_number }}</h2>
<p>Project: {{ $invoice->project->name }}</p>
<p>Date:{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</p>

<table>
    <thead>
        <tr>
            <th>Task</th>
            <th>Hours</th>
            <th>Rate</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoice->items as $item)
        <tr>
            <td>{{ $item->task }}</td>
            <td>{{ $item->hours }}</td>
            <td>{{ $item->rate }}</td>
            <td>{{ $item->hours * $item->rate }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p><strong>Total:</strong> ₹{{ $invoice->total_amount }}</p>
