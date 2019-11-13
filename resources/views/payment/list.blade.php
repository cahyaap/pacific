<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')

<body>
    @include('layouts.navbar')
    <div class="py-4 container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Payment List</div>

                    <div class="card-body">
                        <div class="text-center" id="load-table" style="margin: 10px 0;">
                            <span><img src="{{ asset('loading.gif') }}" height="50px">
                                <p>Loading data, please wait...</p>
                            </span>
                        </div>
                        <div id="payment-table-container">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('payment.modal')
    @include('layouts.footer')
</body>
@include('layouts.script')
<script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    function getPayment(div) {
        $.ajax({
            url: "{{ route('getPaymentTable') }}",
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

    $(document).ready(function() {
        getPayment('#payment-table-container');

        var id, approveOrReject;
        $(document).on('click', '.approvePayment, .rejectPayment', function() {
            id = $(this).attr('data-id');
            approveOrReject = $(this).attr('approveOrReject');
        });

        $(document).on('click', '.detailPayment', function() {
            $.ajax({
                url: "{{ route('getPaymentData') }}",
                data: {
                    send: true,
                    id: $(this).attr('data-id')
                },
                beforeSend: function() {
                    $('#printBtn').hide();
                },
                success: function(data) {
                    var detailPpn = 0;
                    var detailMaterai = 0;
                    var detailPrice = data.data[0].demand.demand_list[0].price;
                    var detailQuantity = data.data[0].demand.demand_list[0].quantity;
                    var detailPpnStatus = data.data[0].demand.ppn;
                    var detailMateraiStatus = data.data[0].demand.materai;
                    if (detailPpnStatus === 1) {
                        detailPpn = 1 / 10;
                    }
                    if (detailMateraiStatus === 1) {
                        detailMaterai = 6000;
                    }
                    var detailTotal = 0;
                    var body = "";
                    var numRows = 1;
                    $(data.data[0].demand).each(function(key, value) {
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
                    $('#detail-payment-body').empty();
                    $('#detail-payment-body').append(body);
                    $('#ppnDetail').html(ppn);
                    $('#materaiDetail').html(detailMaterai);
                    $('#totalDetail').html(detailTotal);
                    $('#detail-payment-table').DataTable();
                    $('#statusDetail').html(status);
                    $('#requestBy').html(data.data[0].demand.creator.name);
                    $('#requestDate').html(data.data[0].demand.created_at.split(" ")[0]);
                    $('#requestNotes').html(data.data[0].demand.note);
                }
            });
        });

        $(document).on('click', '#approve-payment, #reject-payment', function() {
            $.ajax({
                url: "{{ route('approveOrRejectPayment') }}",
                type: 'POST',
                dataType: 'JSON',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                    approveOrReject: approveOrReject
                },
                success: function(data) {
                    console.log(data);
                    getPayment('#payment-table-container');
                    $('.close').click();
                }
            });
        });
    });
</script>

</html>