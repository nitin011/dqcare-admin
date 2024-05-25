@extends('backend.layouts.empty') 
@section('title', 'Preview')
@section('content')
@php
/**
 * Patient File 
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    Defenzelite <hq@defenzelite.com>
 * @license  https://www.defenzelite.com Defenzelite Private Limited
 * @version  <zStarter: 1.1.0>
 * @link        https://www.defenzelite.com
 */
@endphp
    <!-- push external head elements to head -->
    @push('head')
    @endpush
    
    
    <iframe 
        id="myIframe" 
        src="{{ asset($patient_file->file) }}" 
        style="position:fixed; top:0; left:0; bottom:0; right:0; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;"\
        frameborder="0">
    </iframe>



    <!-- push external js -->
    @push('script')
    <script>   
    $(document).ready(function() {
      // Access the iframe's content
      $('#myIframe').on('load', function() {
        var iframeContent = $(this).contents();

        // Find the img tag inside the iframe
        var img = iframeContent.find('img');

        // Apply the CSS styles to the img tag
        img.css({
          'object-fit': 'contain',
          'width': '100%',
          'height': '100%'
        });
      });
    });
    </script>
    @endpush
@endsection
