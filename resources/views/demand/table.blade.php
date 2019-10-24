<div class="table-responsive">
    <table id="demand-table">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Create Date</th>
                <th class="text-center">Creator</th>
                <th class="text-center">Item</th>
                <th class="text-center">Total</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($demands as $demand)
            <tr>
                <td class="text-center">{{ $i++ }}</td>
                <td class="text-center">{{ explode(' ', $demand->created_at)[0] }}</td>
                <td>{{ $demand['creator']->name }}</td>
                <td>{{ $demand['demand_list'][0]['demand_item'][0]->name }}</td>
                <?php
                    $price = $demand['demand_list'][0]->price;
                    $ppn = ($demand->ppn === 1) ? 1/10 : 0;
                    $materai = ($demand->materai === 1) ? 6000 : 0;
                    $total = $price + ($price * $ppn) + $materai;
                ?>
                <td class="text-right">{{ number_format($total, 0) }}</td>
                <td class="text-center">
                    @if ($demand->status === 0)
                    <span class="demand-status manager-status">Manager Checking</span>
                    @elseif ($demand->status === 1)
                    <span class="demand-status dirut-status">Dirut Checking</span>
                    @elseif ($demand->status === 2)
                    <span class="demand-status approved-status">Approved</span>
                    @elseif ($demand->status === 9)
                    <span class="demand-status rejected-status">Rejected</span>
                    @endif
                </td>
                <td class="text-center">
                    @if (Auth::user()->role_id < 4)
                    <a href="#" data-id="{{ $demand->id }}" role-id="{{ Auth::user()->role_id }}" class="approveDemand" data-toggle="modal" data-target="#approveDemand">Approve</a>
                    @endif
                    <a href="#" data-id="{{ $demand->id }}" class="detailDemand" data-toggle="modal" data-target="#detailDemand">Detail</a>
                    @if (Auth::user()->id === $demand->created_by)
                    <a href="#" data-id="{{ $demand->id }}" class="editDemand" data-toggle="modal" data-target="#editDemand">Edit</a>
                    <a href="#" data-id="{{ $demand->id }}" class="deleteDemand" data-toggle="modal" data-target="#deleteDemand">Delete</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Create Date</th>
                <th class="text-center">Creator</th>
                <th class="text-center">Item</th>
                <th class="text-center">Total</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
        </tfoot>
    </table>
</div>