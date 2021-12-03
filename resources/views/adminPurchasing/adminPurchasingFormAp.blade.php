@if(Auth::user()->hasRole('adminPurchasing'))

    @extends('../layouts.base')

    @section('title', 'Checklist AP')

    @section('container')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> 

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <div class="row">
            @include('adminPurchasing.sidebar')
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @include('../layouts/time')

                <h1 class="text-center">Upload List AP</h1>
                
                @if(count($errors) > 0)
                    @foreach($errors->all() as $message)
                        <div class="alert alert-danger" style="width: 40%; margin-left: 30%">
                            {{ $message }}
                        </div>
                    @endforeach
                @endif

                <div class="d-flex">
                    <div class="p-2 mr-auto">
                        <h5>Cabang</h5>
                        <select name="cabang" class="form-select" onchange="window.location = this.value;">
                            <option selected disabled>Pilih Cabang</option>
                            <option value="/admin-purchasing/form-ap/Jakarta" 
                                @php
                                    if($default_branch == 'Jakarta'){
                                        echo('selected');
                                    }
                                @endphp
                            >Jakarta</option>
                            <option value="/admin-purchasing/form-ap/Banjarmasin"
                                @php
                                    if($default_branch == 'Banjarmasin'){
                                        echo('selected');
                                    }
                                @endphp
                            >Banjarmasin</option>
                            <option value="/admin-purchasing/form-ap/Samarinda"
                                @php
                                    if($default_branch == 'Samarinda'){
                                        echo('selected');
                                    }
                                @endphp
                            >Samarinda</option>
                            <option value="/admin-purchasing/form-ap/Bunati"
                                @php
                                    if($default_branch == 'Bunati'){
                                        echo('selected');
                                    }
                                @endphp
                            >Bunati</option>
                            <option value="/admin-purchasing/form-ap/Babelan"
                                @php
                                    if($default_branch == 'Babelan'){
                                        echo('selected');
                                    }
                                @endphp
                            >Babelan</option>
                            <option value="/admin-purchasing/form-ap/Berau"
                                @php
                                    if($default_branch == 'Berau'){
                                        echo('selected');
                                    }
                                @endphp
                            >Berau</option>
                        </select>
                    </div>
                </div>
                
                <div id="content" style="overflow-x:auto;">
                    <table class="table">
                        <thead class="thead bg-danger">
                        <tr>
                            <th scope="col">Time Created</th>
                            <th scope="col">Status</th>
                            <th scope="col">Nomor PO</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($apList as $ap)
                            <tr>
                                <td>{{ $ap -> creationTime }}</td>
                                @if($ap -> status == 'OPEN')
                                    <td><span style="color: green; font-weight: bold; font-size: 18px">{{ $ap -> status }}</span></td>
                                @else
                                    <td><span style="color: red; font-weight: bold; font-size: 18px">{{ $ap -> status }}</span></td>
                                @endif
                                <td>{{ $ap -> orderHead -> noPo }}</td>
                                <td>
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#detail-{{ $ap -> id }}">Detail</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end">
                    {{ $apList->links() }}
                </div>
            </main>
        </div>


        {{-- Modal Detail --}}
        @foreach($apList as $ap)
            @if(!empty(Session::get('openApListModalWithId')) && Session::get('openApListModalWithId') == $ap -> id)
                <script>
                    let id = {!! json_encode($ap -> id) !!};
                    $(document).ready(function(){
                        $("#detail-" + id).modal('show');
                    });
                </script>
            @endif
            
            <div class="modal fade" id="detail-{{ $ap -> id }}" tabindex="-1" role="dialog" aria-labelledby="detailTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <div class="d-flex justify-content-start">
                                <h3 style="color: white">{{ $ap -> orderHead -> noPo }}</h3>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">

                            @if(session('openApListModalWithId'))
                                <div class="alert alert-success" style="width: 40%; margin-left: 30%">
                                    Saved Successfully
                                </div>
                            @endif
                            
                            @if(session('errorClosePo'))
                                <div class="alert alert-danger" style="width: 40%; margin-left: 30%">
                                    PO Already Been Closed
                                </div>
                            @endif

                            <div class="d-flex justify-content-end mb-3 mr-3">
                                <div class="p-2 mr-auto">
                                    <h5>Total Harga : Rp. {{ number_format($ap -> orderHead -> totalPrice, 2, ",", ".") }}</h5>
                                </div>
                            <form action="/admin-purchasing/form-ap/upload" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                @if($ap -> status == 'OPEN')
                                    <button type="submit" class="btn btn-info mr-3">Submit</button>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#close-{{ $ap -> id }}">Close PO</button>
                                @endif
                            </div>
                                <div class="table-modal">
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="table-header">Date Uploaded</th>
                                                <th class="table-header">Name</th>
                                                <th class="table-header">Status</th>
                                                <th class="table-header">Description</th>
                                                <th class="table-header">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for($i = 1 ; $i <= 20 ; $i++)
                                                @php
                                                    // Helper var
                                                    $status = 'status_partial' . $i;
                                                    $uploadTime = 'uploadTime_partial' . $i;
                                                    $description = 'description_partial' . $i;
                                                    $filename = 'doc_partial' . $i;
                                                @endphp
                                                <tr>
                                                    <td>{{ $ap -> $uploadTime }}</td>
                                                    <td>Partial {{ $i }}</td>
                                                    <td>
                                                        @if($ap -> $status == 'On Review')
                                                            <span style="color: gray; font-weight: bold">{{ $ap -> $status }}</span>
                                                        @elseif($ap -> $status == 'Rejected')
                                                            <span style="color: Red; font-weight: bold">{{ $ap -> $status }}</span>
                                                        @else
                                                            <span style="color: green; font-weight: bold">{{ $ap -> $status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $ap -> $description }}</td>
                                                    <td>
                                                        @if($ap -> $status == 'On Review' || $ap -> $status == 'Approved' || $ap -> status == 'CLOSED')
                                                            <span>{{ $ap -> $filename }}</span>
                                                        @else
                                                            <input type="hidden" name="apListId" value="{{ $ap -> id }}">
                                                            <input type="hidden" name="cabang" value="{{ $default_branch }}">
                                                            <input type="file" name="doc_partial{{ $i }}" class="form-control">
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                            <div class="mt-4">
                                <form action="/admin-purchasing/form-ap/ap-detail" method="POST">
                                    @csrf
                                    <input type="hidden" name="apListId" value="{{ $ap -> id }}">
                                    <input type="hidden" name="cabang" value="{{ $default_branch }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                        <label for="supplier_id">Nama Supplier</label>
                                        <select class="form-control" id="supplier_id" name="supplier_id">
                                            <option class="h-25 w-50" value="" disabled>Choose Supplier...</option>
                                            @foreach($suppliers as $s)
                                                <option class="h-25 w-50" value="{{ $s -> supplierName }}">{{ $s -> supplierName }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                        <label for="noPr">Nomor PR</label>
                                        <input type="text" class="form-control" name="noPr" id="noPr" value="{{ $ap -> orderHead -> noPr }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                        <label for="noInvoice">Nomor Invoice</label>
                                        <input type="text" class="form-control" name="noInvoice" id="noInvoice" placeholder="Input Nomor Invoice" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                        <label for="nominalInvoice">Nominal Invoice</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Rp. </div>
                                            </div>
                                            <input type="number" class="form-control" id="nominalInvoice" name="nominalInvoice" min="1" step="0.1" placeholder="Input Nominal Invoice" required>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                        <label for="noFaktur">Nomor Faktur Pajak</label>
                                        <input type="text" class="form-control" id="noFaktur" placeholder="Input Nomor Faktur Pajak" name="noFaktur" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                        <label for="noDo">Nomor DO</label>
                                        <input type="text" class="form-control" id="noDo" placeholder="Input Nomor DO" name="noDo" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="additionalInformation">Keterangan (optional)</label>
                                        <textarea class="form-control" name="additionalInformation" id="additionalInformation" placeholder="Input Keterangan..." rows="4"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        @endforeach

        @foreach($apList as $ap)
            <div class="modal fade" id="close-{{ $ap -> id }}" tabindex="-1" role="dialog" aria-labelledby="detailTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-md modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <div class="d-flex justify-content-start">
                                <h5 class="text-white">Close PO</h5>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-center align-items-center">
                                <h5>Are you sure you want to close this PO?</h5>
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-2">
                                <span data-feather="alert-circle" style="width: 10vw; height: 10vh;stroke: red;
                                stroke-width: 2;"></span>
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-3">
                                <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
                                <form action="/admin-purchasing/form-ap/close" method="POST">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" name="apListId" value="{{ $ap -> id }}">
                                    <button type="submit" class="btn btn-primary ml-3">Yes</button>
                                </form>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        @endforeach

        <style>
            /* .tableFixHead          { overflow: auto; height: 250px; }
            .tableFixHead thead th { position: sticky; top: 0; z-index: 1; }
            .my-custom-scrollbar {
            position: relative;
            height: 600px;
            overflow: auto;
            }
            .table-wrapper-scroll-y {
                display: block;
            } */
            th{
                color: white;
            }
            th, td{
                word-wrap: break-word;
                min-width: 160px;
                max-width: 160px;
                text-align: center;
            }
            .table-properties{
                word-wrap: break-word;
                min-width: 120px;
                max-width: 120px;
                text-align: center;
            }
            .table-modal{
                height: 400px;
                overflow-y: auto;
            }
            .table-header{
                position: sticky;
                top: 0;
                z-index: 10;
            }
            .icon{
                color: black;
                height: 24px;
                width: 24px
            }
            .center{
                margin-left: 25%;
                width: 50%;
            }
            .alert{
                text-align: center;
            }
            .modal-backdrop {
                height: 100%;
                width: 100%;
            }
        </style>

        {{-- <script>
            $(document).ready(function(){
                $("#detail-1").modal('show');
            });
        </script> --}}

        <script>
            function refreshDiv(){
                $('#content').load(location.href + ' #content')
            }
            setInterval(refreshDiv, 60000);

            setTimeout(function() {
                $('.alert').fadeOut('fast');
            }, 3000);
        </script>
        <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
    @endsection

@else
    @include('../layouts/notAuthorized')
@endif