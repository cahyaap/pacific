<div class="table-responsive">
    <table id="demand-table">
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
            @foreach ($demands as $demand)
            <tr>
                <td class="text-center">{{ explode(' ', $demand->created_at)[0] }}</td>
                <td>{{ $demand['creator']->name }}</td>
                <td>{{ $demand['demand_list'][0]['demand_item']->name }}</td>
                <?php
                    $price = $totals[$demand->id];
                    $ppn = ($demand->ppn === 1) ? 1/10 : 0;
                    $materai = ($demand->materai === 1) ? 6000 : 0;
                    $total = $price + ($price * $ppn) + $materai;
                ?>
                <td class="text-right">{{ number_format($total, 0) }}</td>
                <td class="text-center">
                    @if ($demand->status === 0)
                    <span class="demand-status manager-status">Process on Manager</span>
                    @elseif ($demand->status === 1)
                    <span class="demand-status dirut-status">Process on Dirut</span>
                    @elseif ($demand->status === 2)
                    <span class="demand-status approved-status">Approved</span>
                    @elseif ($demand->status === 9)
                    <span class="demand-status rejected-status">Rejected</span>
                    @endif
                </td>
                <td class="text-center">
                    @if ((Auth::user()->role_id === 1 || (Auth::user()->role_id === 2 && $demand->status === 0) || (Auth::user()->role_id === 3 && $demand->status === 1)) && $demand->status < 2)
                    <a href="#" data-id="{{ $demand->id }}" approveOrReject="approve" class="approveDemand" data-toggle="modal" data-target="#approveDemand">Approve</a>
                    <a href="#" data-id="{{ $demand->id }}" approveOrReject="reject" class="rejectDemand" data-toggle="modal" data-target="#rejectDemand">Reject</a>
                    @endif
                    <a href="#" data-id="{{ $demand->id }}" class="detailDemand" data-toggle="modal" data-target="#detailDemand">Detail</a>
                    @if (Auth::user()->role_id === 1 || (Auth::user()->id === $demand->created_by || Auth::user()->role_id === 1) && $demand->status < 2)
                    <a href="#" data-id="{{ $demand->id }}" class="editDemand" data-toggle="modal" data-target="#editDemand">Edit</a>
                    <a href="#" data-id="{{ $demand->id }}" class="deleteDemand" data-toggle="modal" data-target="#deleteDemand">Delete</a>
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