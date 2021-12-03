@if(Auth::user()->hasRole('supervisorLogistic') || Auth::user()->hasRole('supervisorLogisticMaster'))
    @extends('../layouts.base')

    @section('title', 'Supervisor Reports')

    @section('container')
    <div class="row">
        @include('supervisor.sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            
            <div class="flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 mt-3">
                <h1 class="d-flex justify-content-center mb-4">Reports PR/PO ({{ $str_month }})</h1>

                @if(count($orders) > 0)
                    <div class="d-flex justify-content-end mr-3">
                        <a href="{{ Route('supervisor.downloadReport') }}" class="btn btn-outline-danger mb-3" target="_blank">Export</a>
                    </div>
                @endif

                <div class="table-wrapper-scroll-y my-custom-scrollbar tableFixHead" style="overflow-x:auto;">
                    <table class="table table-bordered sortable">
                        <thead class="thead bg-danger">
                        <tr>
                            <th scope="col">Nomor</th>
                            <th scope="col">Tanggal PR</th>
                            <th scope="col">Nomor PR</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Tanggal PO</th>
                            <th scope="col">Nomor PO</th>
                            <th scope="col">Golongan</th>
                            <th scope="col">Nama Kapal</th>
                            <th scope="col">Serial Number</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Keterangan</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $key=>$o)
                                <tr>
                                    <td>{{ $key + 1  }}</td>
                                    <td>{{ $o -> prDate }}</td>
                                    <td>{{ $o -> noPr }}</td>
                                    @if(isset($o -> supplier -> supplierName))
                                        <td>{{ $o -> supplier -> supplierName }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>{{ $o -> poDate}}</td>
                                    <td>{{ $o -> noPo}}</td>
                                    <td>{{ $o -> item['golongan']}}</td>
                                    <td>{{ $o -> boatName}}</td>
                                    <td>{{ $o -> item -> codeMasterItem}}</td>
                                    <td>{{ $o -> quantity}} {{ $o -> item -> unit }}</td>
                                    <td>Rp. {{ number_format($o -> totalItemPrice, 2, ",", ".") }}</td>
                                    <td>{{ $o -> descriptions}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </main>
    </div>

    <style>
        .tableFixHead          { overflow: auto; height: 250px; }
        .tableFixHead thead th { position: sticky; top: 0; z-index: 1; }

        .my-custom-scrollbar {
            position: relative;
            height: 800px;
            overflow: auto;
        }
        .table-wrapper-scroll-y {
            display: block;
        }

        th{
            color: white;
        }

        td, th{
            word-wrap: break-word;
            min-width: 160px;
            max-width: 160px;
            text-align: center;
        }
    </style>
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
    @endsection
@else
    @include('../layouts/notAuthorized')
@endif