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
                $(div + ' table').DataTable({
                    "aaSorting": [
                        [0, "desc"]
                    ]
                });
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

        function changePriceQuantity(div) {
            if (div === '#price') {
                price = $(div).val();
            }
            if (div === '#quantity') {
                quantity = $(div).val();
            }
            if (ppnStatus === 1) {
                tempPpn = (price * quantity) * ppn;
            }
            total = (price * quantity) + tempPpn + materai;
            (ppnStatus === 0) ? $('#ppnValue').html(""): $('#ppnValue').html("PPN: " + tempPpn);
            (materaiStatus === 0) ? $('#materaiValue').html(""): $('#materaiValue').html("Materai: " + materai);
            $('#total').val(total);
            total = 0;
        }

        function changePpnMaterai(div) {
            if (div === "#ppn") {
                if ($(div).val() === "1" && ppnStatus === 0) {
                    tempPpn = (price * quantity) * ppn;
                    ppnStatus = 1;
                } else if ($(div).val() === "0" && ppnStatus === 1) {
                    tempPpn = 0;
                    ppnStatus = 0;
                }
            }
            if (div === "#materai") {
                if ($(div).val() === "1" && materaiStatus === 0) {
                    materai = 6000;
                    materaiStatus = 1;
                } else if ($(div).val() === "0" && materaiStatus === 1) {
                    materai = 0;
                    materaiStatus = 0;
                }
            }
            total = (price * quantity) + tempPpn + materai;
            (ppnStatus === 0) ? $('#ppnValue').html(""): $('#ppnValue').html("PPN: " + tempPpn);
            $('#total').val(total);
            total = 0;
        }

        var itemCounter = 1;
        $('.remove_item_btn').hide();

        $('#add_more_container').hide();

        $('.add_mode_btn').click(function() {
            itemCounter = itemCounter + 1;
            $('#item_counter').val(itemCounter);
            var html = "<div class='row item' id='item_" + itemCounter + "'><div class='col-md-12'><div class='form-group'><strong><label class='item_label' id='label_" + itemCounter + "'>Item " + itemCounter + " </label><a href='#' id='remove_" + itemCounter + "' class='remove_item_btn'> [ remove ]</a></strong><input type='desc' id='desc_" + itemCounter + "' name='desc_" + itemCounter + "' class='form-control item_desc' required='required' placeholder='Item name/description'></textarea></div></div><div class='col-md-6'><div class='form-group'><input type='number' id='price_" + itemCounter + "' name='price_" + itemCounter + "' class='form-control item_price' required='required' placeholder='Price per unit' min='0'></div></div><div class='col-md-6'><div class='form-group'><input type='number' id='quantity_" + itemCounter + "' name='quantity_" + itemCounter + "' class='form-control item_quantity' required='required' placeholder='Quantity' min='0'></div></div></div>";
            $('#item_container').append(html);
            if (itemCounter > 1) {
                $('.remove_item_btn').show();
            }
        });

        $(document).on('click', '.remove_item_btn', function() {
            itemCounter = itemCounter - 1;
            var remove_id = $(this).attr('id');
            var item_id = remove_id.split('_')[1];
            for (var i = 1; i <= itemCounter; i++) {

            }
            $('#item_' + item_id).remove();
            if (itemCounter <= 1) {
                $('.remove_item_btn').hide();
            }
        });

        // create request
        $('#price').change(function() {
            changePriceQuantity('#price');
        });
        $('#quantity').change(function() {
            changePriceQuantity('#quantity');
        });
        $('#ppn').change(function() {
            changePpnMaterai('#ppn');
        });
        $('#materai').change(function() {
            changePpnMaterai('#materai');
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

        $(document).on('click', '.deleteItem, .deleteDemand', function() {
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

        function changeEditPriceQuantity(div) {
            if (div === '#editprice') {
                editPrice = $(div).val();
            }
            if (div === '#editquantity') {
                editQuantity = $(div).val();
            }
            if (editPpnStatus === 1) {
                editTempPpn = (editPrice * editQuantity) * editPpn;
            }
            editTotal = (editPrice * editQuantity) + editTempPpn + editMaterai;
            (editPpnStatus === 0) ? $('#editPpnValue').html(""): $('#editPpnValue').html("PPN: " + editTempPpn);
            (editMateraiStatus === 0) ? $('#editMateraiValue').html(""): $('#editMateraiValue').html("Materai: " + editMaterai);
            $('#edittotal').val(editTotal);
            editTotal = 0;
        }

        function changeEditPpnMaterai(div) {
            if (div === "#editppn") {
                if ($(div).val() === "1" && editPpnStatus === 0) {
                    editTempPpn = (editPrice * editQuantity) * editPpn;
                    editPpnStatus = 1;
                } else if ($(div).val() === "0" && editPpnStatus === 1) {
                    editTempPpn = 0;
                    editPpnStatus = 0;
                }
            }
            if (div === "#editmaterai") {
                if ($(div).val() === "1" && editMateraiStatus === 0) {
                    editMaterai = 6000;
                    editMateraiStatus = 1;
                } else if ($(div).val() === "0" && editMateraiStatus === 1) {
                    editMaterai = 0;
                    editMateraiStatus = 0;
                }
            }
            editTotal = (editPrice * editQuantity) + editTempPpn + editMaterai;
            (editPpnStatus === 0) ? $('#editPpnValue').html(""): $('#editPpnValue').html("PPN: " + editTempPpn);
            $('#edittotal').val(editTotal);
            editTotal = 0;
        }

        var editTotal = 0;
        var editPrice = 0;
        var editQuantity = 0;
        var editMaterai = 0;
        var editMateraiStatus = 0;
        var editPpn = 0;
        var editTempPpn = 0;
        var editPpnStatus = 0;

        $(document).on('click', '.editDemand', function() {
            $.ajax({
                url: "{{ route('getDemandData') }}",
                data: {
                    send: true,
                    id: $(this).attr('data-id')
                },
                success: function(data) {
                    editPrice = data.data[0].demand_list[0].price;
                    editQuantity = data.data[0].demand_list[0].quantity;
                    editPpnStatus = data.data[0].ppn;
                    editMateraiStatus = data.data[0].materai;
                    if (editPpnStatus === 1) {
                        editPpn = 1 / 10;
                    }
                    if (editMateraiStatus === 1) {
                        editMaterai = 6000;
                    }
                    editTotal = (editPrice * editQuantity) + ((editPrice * editQuantity) * editPpn) + editMaterai;
                    $('#demandId').val(data.data[0].id);
                    $('#edititem').val(data.data[0].demand_list[0].demand_item_id);
                    $('#editprice').val(editPrice);
                    $('#editquantity').val(editQuantity);
                    $('#editppn').val(editPpnStatus);
                    $('#editmaterai').val(editMateraiStatus);
                    $('#edittotal').val(editTotal);
                    $('#editnote').val(data.data[0].note);
                }
            });
        });

        // edit request
        $('#editprice').change(function() {
            changeEditPriceQuantity('#editprice');
        });
        $('#editquantity').change(function() {
            changeEditPriceQuantity('#editquantity');
        });
        $('#editppn').change(function() {
            changeEditPpnMaterai('#editppn');
        });
        $('#editmaterai').change(function() {
            changeEditPpnMaterai('#editmaterai');
        });

        $('#edit-demand').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('editDemand') }}",
                type: 'POST',
                dataType: 'JSON',
                data: {
                    _token: CSRF_TOKEN,
                    ppn: $('#editppn').val(),
                    materai: $('#editmaterai').val(),
                    note: $('#editnote').val(),
                    item: $('#edititem').val(),
                    quantity: $('#editquantity').val(),
                    price: $('#editprice').val(),
                    id: $('#demandId').val()
                },
                success: function(data) {
                    getDemand('#demand-table-container');
                    $('.close').click();
                }
            });
        });

        $(document).on('click', '#delete-demand', function() {
            $.ajax({
                url: "{{ route('deleteDemand') }}",
                type: 'POST',
                dataType: 'JSON',
                data: {
                    _token: CSRF_TOKEN,
                    id: id
                },
                success: function(data) {
                    getDemand('#demand-table-container');
                    $('.close').click();
                }
            });
        });

        $(document).on('click', '.detailDemand', function() {
            var detailDemandId = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('getDemandData') }}",
                data: {
                    send: true,
                    id: detailDemandId
                },
                beforeSend: function() {
                    $('#printBtn').hide();
                },
                success: function(data) {
                    var detailPpn = 0;
                    var detailMaterai = 0;
                    var detailPrice = data.data[0].demand_list[0].price;
                    var detailQuantity = data.data[0].demand_list[0].quantity;
                    var detailPpnStatus = data.data[0].ppn;
                    var detailMateraiStatus = data.data[0].materai;
                    if (detailPpnStatus === 1) {
                        detailPpn = 1 / 10;
                    }
                    if (detailMateraiStatus === 1) {
                        detailMaterai = 6000;
                    }
                    var detailTotal = 0;
                    var body = "";
                    var numRows = 1;
                    $(data.data).each(function(key, value) {
                        $(value.demand_list).each(function(k, v) {
                            body = body + "<tr>";
                            body = body + "<td class='text-center'>" + numRows + "</td>";
                            body = body + "<td>" + v.demand_item.name + "</td>";
                            body = body + "<td class='text-right'>" + v.quantity + " Qty</td>";
                            body = body + "<td class='text-right'>" + v.price + "</td>";
                            body = body + "<td class='text-right'>" + v.quantity * v.price + "</td>";
                            body = body + "</tr>";
                            detailTotal = detailTotal + (v.quantity * v.price);
                            numRows++;
                        });
                    });

                    var ppn = detailPpn * detailTotal;
                    var status = "";

                    if (data.data[0].status === 0) {
                        status = "Process on Manager";
                    } else if (data.data[0].status === 1) {
                        status = "Process on Dirut";
                    } else if (data.data[0].status === 2) {
                        $('#printBtn').show();
                        status = "Approved";
                    } else if (data.data[0].status === 9) {
                        status = "Rejected";
                    }
                    detailTotal = detailTotal + (detailTotal * detailPpn) + detailMaterai;
                    var url = "{{ route('printDemand',['id'=>'print-id']) }}";
                    url = url.replace('print-id', detailDemandId);
                    $('#printBtn').attr('href', url);
                    $('#detail-demand-body').empty();
                    $('#detail-demand-body').append(body);
                    $('#ppnDetail').html(ppn);
                    $('#materaiDetail').html(detailMaterai);
                    $('#totalDetail').html(detailTotal);
                    $('#detail-demand-table').DataTable();
                    $('#statusDetail').html(status);
                    $('#requestBy').html(data.data[0].creator.name);
                    $('#requestDate').html(data.data[0].created_at.split(" ")[0]);
                    $('#requestNotes').html(data.data[0].note);
                }
            });
        });

        var approveOrReject;
        $(document).on('click', '.deleteItem, .deleteDemand, .approveDemand, .rejectDemand', function() {
            id = $(this).attr('data-id');
            approveOrReject = $(this).attr('approveOrReject');
        });

        $(document).on('click', '#approve-demand, #reject-demand', function() {
            $.ajax({
                url: "{{ route('approveOrReject') }}",
                type: 'POST',
                dataType: 'JSON',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                    approveOrReject: approveOrReject
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