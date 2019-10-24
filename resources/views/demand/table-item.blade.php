<div class="table-responsive">
    <table id="item-table">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Item</th>
                <th class="text-center">Description</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($demand_items as $item)
            <tr>
                <td class="text-center">{{ $i++ }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->desc }}</td>
                <td class="text-center">
                    <a href="#" data-id="{{ $item->id }}" class="editItem" data-toggle="modal" data-target="#editItem">Edit</a>
                    @if (!in_array($item->id, $item_used))
                    <a href="#" data-id="{{ $item->id }}" class="deleteItem" data-toggle="modal" data-target="#deleteItem">Delete</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Item</th>
                <th class="text-center">Description</th>
                <th class="text-center">Action</th>
            </tr>
        </tfoot>
    </table>
</div>