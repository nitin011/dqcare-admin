@extends('backend.layouts.main') 
@section('title', 'Map Location')
@section('content')
@php
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
        ['name'=>'Map Location', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    @endpush
    <div class="container-fluid p-0 m-0">
    	<div class="map_wrapper">
            <div id="map" class="map_container">
            </div>
            <div class="map_results">
                <div class="map_detail">
                </div>
                <div class="map_listings">
                    <div class="map_listings_headline">
                        <h2>Results <span class="map_listings_number"></span></h2>
                    </div>
                    <div class="map_listings_results">
        
                    </div>
                </div>
            </div>
        </div>
    </div>
     @push('script')
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
     <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places,geometry"></script>
     <script src="src/storeLocator.all.js"></script>
     
     <script>
         $(function() {
             $('.map_container').storeLocator({
                 OPTIONS
             });
         });
     </script>
     
     <script id="YOUR_LIST_TEMPLATE_ID" type="text/x-jQuery-tmpl">
         TEMPLATE
     </script>
     <script id="YOUR_DETAIL_TEMPLATE_ID" type="text/x-jQuery-tmpl">
         TEMPLATE
     </script>
    @endpush
@endsection
