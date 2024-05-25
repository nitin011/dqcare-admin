@extends('backend.layouts.main') 
@section('title', 'QR Code')
@section('content')
@php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
/**
 * Price Ask Request 
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    Defenzelite <hq@defenzelite.com>
 * @license  https://www.defenzelite.com Defenzelite Private Limited
 * @version  <zStarter: 1.1.0>
 * @link        https://www.defenzelite.com
 */
    $breadcrumb_arr = [
        ['name'=>'QR Code', 'url'=> "javascript:void(0);", 'class' => 'active']
];
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    <style>
        #qr-reader__dashboard_section_csr button{
            padding: 5px;
            margin-bottom: 10px;
            background: #fff;
            font-size: 15px;
            border-radius: 4px;
        }
    </style>
    @endpush
    <div class="container-fluid p-0 m-0">
       
        <div class="row">
            <div class="col-md-6 text-center">
                <div class="card">
                    <div class="card-header">
                        <h3>QR Code</h3>
                        <a href="https://www.simplesoftware.io/#/docs/simple-qrcode" class="float-right ml-auto">click here for more</a>
                    </div>
                    <div class="card-body text-center">
                        @php
                            $qrcode = QrCode::size(100)->generate(Request::url()) ;
                        @endphp
                        <div class="p-2" id="html-content-holder" style="width: fit-content; margin: 0 auto;">
                            {!!$qrcode!!}
                        </div>
                        <p>Scan me to return to the original page.</p>
                        <div id="previewImg" class="d-none">
                        </div>
                        
                        <a href="javascript:void(0)" id="download-qr" class=" btn btn-outline-primary">Download QR</a>
                        <a href="javascript:void(0);" onclick="copyTextToClipboard('{{ Request::url()}}')" class="ml-3 btn-link">Copy Link</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Scan QR Code</h3>
                        <a href="javascript:void(0);" class="btn btn-primary ml-auto" id="startscan">Start Scaning</a>
                     </div>
                    <div class="card-body">
                        <div class="report-print">
                            <div class="d-block mx-auto text-center">
                                <div id="qr-reader" style="mx-auto" style="width:500px"></div>
                                <div id="qr-reader-results"></div>
                            </div>
                        </div>  
                    </div>
                </div>               
            </div>                 
        </div>
         
      
    </div>
     @push('script')
     
        <script src="{{ asset('backend/js/html2canvas.js') }}"></script>
        <script>
            
            var element = $("#html-content-holder"); // global variable
            var getCanvas; // global variable
            $("#download-qr").on('click', function () {
                html2canvas(document.getElementById("html-content-holder")).then(function (canvas) {		
                    var anchorTag = document.createElement("a");
                    document.body.appendChild(anchorTag);
                    document.getElementById("previewImg").appendChild(canvas);
                    anchorTag.download = "qrcode.jpg";
                    anchorTag.href = canvas.toDataURL();
                    anchorTag.target = '_blank';
                    anchorTag.click();
                });
            });

            function copyTextToClipboard(text) {
                if (!navigator.clipboard) {
                    fallbackCopyTextToClipboard(text);
                    return;
                }
                navigator.clipboard.writeText(text).then(function() {
                }, function(err) {
                });
            }
        </script>
        <script src="{{ asset('backend/js/qrcode.js') }}"></script>
        <script>
            var resultContainer = document.getElementById('qr-reader-results');
            var lastResult, countResults = 0;
           
            function onScanSuccess(decodedText, decodedResult) {
                var url = decodedText;
                var accessToken = "{{ encrypt(auth()->id()) }}";
                if (decodedText !== lastResult) {
                    ++countResults;
                    lastResult = decodedText;
                    // Handle on success condition with the decoded message.
                    window.open(url+'?at='+accessToken);
                    return false;
                    // window.location.href = url+'?at='+accessToken;
                }
            }
            var html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader", {
                    fps: 10,
                    qrbox: 250
                });
                html5QrcodeScanner.clear();
            $('#startscan').click(function() {
                html5QrcodeScanner.render(onScanSuccess);
            });
        </script>
    @endpush
@endsection
