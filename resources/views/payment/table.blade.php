<div class="table-responsive">
    <table id="payment-table">
        <thead>
            <tr>
                <th class="text-center">Date</th>
                <th class="text-center">Creator</th>
                <th class="text-center">Item</th>
                <th class="text-center">Total</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
            <tr>
                <?php $p = $payment['demand']; ?>
                <td class="text-center">{{ explode(' ', $payment->created_at)[0] }}</td>
                <td>{{ $p['creator']->name }}</td>
                <td>{{ $p['demand_list'][0]['demand_item']->name }}</td>
                <?php
                    $price = $totals[$p->id];
                    $ppn = ($p->ppn === 1) ? 1/10 : 0;
                    $materai = ($p->materai === 1) ? 6000 : 0;
                    $total = $price + ($price * $ppn) + $materai;
                ?>
                <td class="text-right">{{ number_format($total, 0) }}</td>
                <td class="text-center">
                    @if ($payment->status === 0)
                    <span class="demand-status manager-status">Process on Manager</span>
                    @elseif ($payment->status === 1)
                    <span class="demand-status dirut-status">Process on Dirut</span>
                    @elseif ($payment->status === 2)
                    <span class="demand-status approved-status">Approved</span>
                    @elseif ($payment->status === 9)
                    <span class="demand-status rejected-status">Rejected</span>
                    @endif
                </td>
                <td class="text-center">
                    @if ((Auth::user()->role_id === 1 || (Auth::user()->role_id === 2 && $payment->status === 0) || (Auth::user()->role_id === 3 && $payment->status === 1)) && $payment->status < 2)
                    <a href="#" data-id="{{ $payment->id }}" approveOrReject="approve" class="approvePayment" data-toggle="modal" data-target="#approvePayment">Approve</a>
                    <a href="#" data-id="{{ $payment->id }}" approveOrReject="reject" class="rejectPayment" data-toggle="modal" data-target="#rejectPayment">Reject</a>
                    @endif
                    <a href="#" data-id="{{ $payment->id }}" class="detailPayment" data-toggle="modal" data-target="#detailPayment">Detail</a>
                    @if (Auth::user()->role_id === 1 || (Auth::user()->id === $payment->created_by || Auth::user()->role_id === 1) && $payment->status < 2)
                    <a href="#" data-id="{{ $payment->id }}" class="editPayment" data-toggle="modal" data-target="#editPayment">Edit</a>
                    <a href="#" data-id="{{ $payment->id }}" class="deletePayment" data-toggle="modal" data-target="#deletePayment">Delete</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center">Date</th>
                <th class="text-center">Creator</th>
                <th class="text-center">Item</th>
                <th class="text-center">Total</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
        </tfoot>
    </table>
</div>