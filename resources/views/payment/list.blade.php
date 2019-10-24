<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')

<body>
    @include('layouts.navbar')
    <div class="py-4 container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Payment</div>

                    <div class="card-body">
                        <div class="text-center" id="load-table" style="margin: 10px 0;">
                            <span><img src="{{ asset('loading.gif') }}" height="50px">
                                <p>Loading data, please wait...</p>
                            </span>
                        </div>
                        <div id="payment-table-container">
                            Payment here
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</body>
@include('layouts.script')
<script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $(document).ready(function() {

    });
</script>

</html>