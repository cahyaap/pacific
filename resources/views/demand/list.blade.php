<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')

<body>
    @include('layouts.navbar')
    <div class="py-4 container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (Auth::user()->id === 1)
                <div class="card">
                    <div class="card-header">
                        Item List
                        <a href="#" id="showhide" status="hide" style="float: right;">Show Item</a>
                    </div>

                    <div class="card-body" id="showhide_card">
                        <div class="text-right">
                            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#addDemandItem">Create Item</a>
                        </div><br>
                        <div class="text-center" id="load-item-table" style="margin: 10px 0;">
                            <span><img src="{{ asset('loading.gif') }}" height="50px">
                                <p>Loading data, please wait...</p>
                            </span>
                        </div>
                        <div id="item-table-container">

                        </div>
                    </div>
                </div><br>
                @endif
                <div class="card">
                    <div class="card-header">Request List</div>

                    <div class="card-body">
                        <div class="text-right">
                            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#addDemand">Create Request</a>
                            <!-- <a class="btn btn-primary" href="#">Manage Item</a> -->
                        </div><br>
                        <div class="text-center" id="load-table" style="margin: 10px 0;">
                            <span><img src="{{ asset('loading.gif') }}" height="50px">
                                <p>Loading data, please wait...</p>
                            </span>
                        </div>
                        <div id="demand-table-container">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('demand.modal', ['items' => $items])
    @include('layouts.footer')
</body>
@include('layouts.script')
<script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    function getDemand(div) {
        $.ajax({
            url: "{{ route('getDemandTable') }}",
            data: {
                send: true
            },
            beforeSend: function() {
                $('#load-table').show();
                $(div).hide();
            },
            success: function(data) {
                $(div).html(data);
                $('#load-table').hide();
                $(div + ' table').DataTable();
                $(div).show();
            }
        });
    }

    function getItem(div) {
        $.ajax({
            url: "{{ route('getItemTable') }}",
            data: {
                send: true
            },
            beforeSend: function() {
                $('#load-item-table').show();
                $(div).hide();
            },
            success: function(data) {
                $(div).html(data);
                $('#load-item-table').hide();
                $(div + ' table').DataTable();
                $(div).show();
            }
        });
    }

    function showHideCard(div) {
        var status = $(div).attr('status');
        if (status === "show") {
            $(div + '_card').hide();
            $(div).html('Show Item');
            $(div).attr('status', 'hide');
        } else {
            $(div + '_card').show();
            $(div).html('Hide Item');
            $(div).attr('status', 'show');
        }
    }

    $(document).ready(function() {
        getDemand('#demand-table-container');
        getItem('#item-table-container');

        var total = 0;
        var price = 0;
        var quantity = 0;
        var materai = 0;
        var materaiStatus = 0;
        var ppn = 1 / 10;
        var tempPpn = 0;
        var ppnStatus = 0;
        $('#price').change(function() {
            price = $(this).val();
            if (ppnStatus === 1){
                tempPpn = (price * quantity) * ppn;
            }
            total = (price * quantity) + tempPpn + materai;
            (ppnStatus === 0) ? $('#ppnValue').html("") : $('#ppnValue').html("PPN: "+tempPpn);
            (materaiStatus === 0) ? $('#materaiValue').html("") : $('#materaiValue').html("Materai: "+materai);
            $('#total').val(total);
            total = 0;
        });
        $('#quantity').change(function() {
            quantity = $(this).val();
            if (ppnStatus === 1){
                tempPpn = (price * quantity) * ppn;
            }
            total = (price * quantity) + tempPpn + materai;
            (ppnStatus === 0) ? $('#ppnValue').html("") : $('#ppnValue').html("PPN: "+tempPpn);
            (materaiStatus === 0) ? $('#materaiValue').html("") : $('#materaiValue').html("Materai: "+materai);
            $('#total').val(total);
            total = 0;
        });
        $('#ppn').change(function() {
            if ($(this).val() === "1" && ppnStatus === 0) {
                tempPpn = (price * quantity) * ppn;
                ppnStatus = 1;
            } else if ($(this).val() === "0" && ppnStatus === 1) {
                tempPpn = 0;
                ppnStatus = 0;
            }
            total = (price * quantity) + tempPpn + materai;
            (ppnStatus === 0) ? $('#ppnValue').html("") : $('#ppnValue').html("PPN: "+tempPpn);
            $('#total').val(total);
            total = 0;
        });
        $('#materai').change(function() {
            if ($(this).val() === "1" && materaiStatus === 0) {
                materai = 6000;
                materaiStatus = 1;
            } else if ($(this).val() === "0" && materaiStatus === 1) {
                materai = 0;
                materaiStatus = 0;
            }
            total = (price * quantity) + tempPpn + materai;
            (materaiStatus === 0) ? $('#materaiValue').html("") : $('#materaiValue').html("Materai: "+materai);
            $('#total').val(total);
            total = 0;
        });

        $('#showhide_card').hide();
        $('#showhide').click(function() {
            showHideCard('#showhide');
        });

        $('#add-item').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('createItem') }}",
                type: 'POST',
                dataType: 'JSON',
                data: {
                    _token: CSRF_TOKEN,
                    name: $('#itemname').val(),
                    desc: $('#itemdesc').val()
                },
                success: function(data) {
                    getItem('#item-table-container');
                    $('.close').click();
                }
            });
        });

        $(document).on('click', '.editItem', function() {
            $.ajax({
                url: "{{ route('getItemData') }}",
                data: {
                    send: true,
                    id: $(this).attr('data-id')
                },
                success: function(data) {
                    $('#itemId').val(data.data.id);
                    $('#edititemname').val(data.data.name);
                    $('#edititemdesc').val(data.data.desc);
                }
            });
        });

        $('#edit-item').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('editItem') }}",
                type: 'POST',
                dataType: 'JSON',
                data: {
                    _token: CSRF_TOKEN,
                    name: $('#edititemname').val(),
                    desc: $('#edititemdesc').val(),
                    id: $('#itemId').val()
                },
                success: function(data) {
                    getItem('#item-table-container');
                    $('.close').click();
                }
            });
        });

        var id;

        $(document).on('click', '.deleteItem', function() {
            id = $(this).attr('data-id');
        });

        $(document).on('click', '#delete-item', function() {
            $.ajax({
                url: "{{ route('deleteItem') }}",
                type: 'POST',
                dataType: 'JSON',
                data: {
                    _token: CSRF_TOKEN,
                    id: id
                },
                success: function(data) {
                    getItem('#item-table-container');
                    $('.close').click();
                }
            });
        });

        $('#add-demand').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('createDemand') }}",
                type: 'POST',
                dataType: 'JSON',
                data: {
                    _token: CSRF_TOKEN,
                    ppn: $('#ppn').val(),
                    materai: $('#materai').val(),
                    note: $('#note').val(),
                    item: $('#item').val(),
                    quantity: $('#quantity').val(),
                    price: $('#price').val()
                },
                success: function(data) {
                    getDemand('#demand-table-container');
                    $('.close').click();
                }
            });
        });
    });
</script>

</html>