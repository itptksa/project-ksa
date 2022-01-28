@if(Auth::user()->hasRole('logistic'))
    @extends('../layouts.base')

    @section('title', 'Logistic Reports')

    @section('container')
    <div class="row">
        @include('logistic.sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            
            <div class="flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 mt-3 wrapper">
                <h1 class="d-flex justify-content-center mb-4">Reports JR ({{ $str_month }})</h1>

                @if(count($jobs) > 0)
                    <div class="d-flex justify-content-end mr-3">
                        <a href="{{ Route('logistic.downloadReportJR') }}" class="btn btn-outline-success mb-3 btn-lg" target="_blank">Export</a>
                    </div>
                @endif

                <div class="table-wrapper-scroll-y my-custom-scrollbar tableFixHead" style="overflow-x:auto;">
                    <table class="table table-bordered sortable">
                        <thead class="thead bg-danger">
                        <tr>
                            <th scope="col">Nomor</th>
                            <th scope="col">cabang</th>
                            <th scope="col">#ID JR</th>
                            <th scope="col">Tanggal JR</th>
                            <th scope="col">Nomor JR</th>
                            <th scope="col">Created By</th>
                            <th scope="col">Nama Kapal</th>
                            <th scope="col">Lokasi</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Keterangan</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($jobs as $key=>$o)
                                <tr>
                                    <td style="text-transform: uppercase"><strong>{{ $key + 1  }}</td>
                                    <td style="text-transform: uppercase"><strong>{{ $o -> cabang}}</td>
                                    <td style="text-transform: uppercase"><strong>{{ $o -> Headjasa_id }}</td>
                                    <td style="text-transform: uppercase"><strong>{{ $o -> jrDate }}</td>
                                    <td style="text-transform: uppercase"><strong>{{ $o -> noJr}}</td>
                                    <td style="text-transform: uppercase"><strong>{{ $o -> created_by}}</td>
                                    <td style="text-transform: uppercase"><strong>{{ $o -> tugName}} / {{ $o -> bargeName}}</td>
                                    <td style="text-transform: uppercase"><strong>{{ $o -> lokasi}}</td>
                                    <td style="text-transform: uppercase"><strong>{{ $o -> quantity}}</td>
                                    <td style="text-transform: uppercase"><strong>{{ $o -> note}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </main>
    </div>

    <style>
        body{
            /* background-image: url('/images/logistic-background.png'); */
            background-repeat: no-repeat;
            background-size: cover;
        }
        .wrapper{
            padding: 10px;
            border-radius: 10px;
            background-color: antiquewhite;
            height: 800px;
            /* height: 100%; */
        }
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
            background-color: white;
        }
        .modal-backdrop {
            height: 100%;
            width: 100%;
        }
    </style>
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
    @endsection
@else
    @include('../layouts/notAuthorized')
@endif