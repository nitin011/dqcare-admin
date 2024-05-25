@extends('backend.layouts.main')
@section('title', 'Features Activation Settings')
@push('head')
<link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
@endpush
@section('content')
@php
$breadcrumb_arr = [['name' => 'Setting', 'url' => 'javascript:void(0);', 'class' => ''], ['name' => 'Features Activation', 'url' => 'javascript:void(0);', 'class' => 'active']];
@endphp
<div class="container-fluid">
  <div class="page-header">
      <div class="row align-items-end">
          <div class="col-lg-8">
              <div class="page-header-title">
                  <i class="ik ik-grid bg-blue"></i>
                  <div class="d-inline">
                      <h5>{{ __('Features Activation') }}</h5>
                      <span>{{ __('This setting will be automatically updated in your website.') }}</span>
                  </div>
              </div>
          </div>
          <div class="col-lg-4">
              <div>

                  {{-- <a style="margin-left: 129px;" class="btn btn-icon btn-sm btn-outline-success" href="#" data-toggle="modal" data-target="#siteModal"><i
                      class="fa fa-info"></i></a> --}}
                  @include('backend.include.breadcrumb')
              </div>
              @include('backend.setting.sitemodal',['title'=>"How to use",'content'=>"You able to add or remove some functionality from this settings."])
          </div>
      </div>
  </div>
<div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1">Order  </h5>
                        <div class="text-center">
                            <input type="checkbox" class="js-switch save" data-key="order_activation" value="1" @if(getSetting('order_activation') == 1) checked @endif data-switchery="true"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1">Wallet  </h5>
                        <div class="text-center">
                            <input type="checkbox" class="js-switch save" data-key="wallet_activation" value="1" @if(getSetting('wallet_activation') == 1) checked @endif data-switchery="true"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1">Article  </h5>
                        <div class="text-center">
                            <input type="checkbox" class="js-switch save" data-key="article_activation" value="1" @if(getSetting('article_activation') == 1) checked @endif data-switchery="true"/>
                        </div>                         
                    </div>                 
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1">Paragraph  Content </h5>
                        <div class="text-center">
                            <input type="checkbox" class="js-switch save" data-key="paragraph_content_activation" value="1" @if(getSetting('paragraph_content_activation') == 1) checked @endif data-switchery="true"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1">Slider </h5>
                        <div class="text-center">
                            <input type="checkbox" class="js-switch save" data-key="slider_activation" value="1" @if(getSetting('slider_activation') == 1) checked @endif data-switchery="true"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1">Ticket </h5>
                        <div class="text-center">
                            <input type="checkbox" class="js-switch save" data-key="ticket_activation" value="1" @if(getSetting('ticket_activation') == 1) checked @endif data-switchery="true"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1">Lead </h5>
                        <div class="text-center">
                            <input type="checkbox" class="js-switch save" data-key="lead_activation" value="1" @if(getSetting('lead_activation') == 1) checked @endif data-switchery="true"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1 ">Website Enquiry </h5>
                        <div class="text-center">
                            <input type="checkbox" class="js-switch save" data-key="website_enquiry_activation" value="1" @if(getSetting('website_enquiry_activation') == 1) checked @endif data-switchery="true"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1">User log </h5>
                        <div class="text-center">
                            <input type="checkbox" class="js-single save" data-key="user_log_activation" value="1" @if(getSetting('user_log_activation') == 1) checked @endif data-switchery="true"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1">Roles and Permission</h5>  
                        <div class="text-center">
                            <input type="checkbox" class="js-switch save" data-key="roles_and_permission_activation" value="1" @if(getSetting('roles_and_permission_activation') == 1) checked @endif data-switchery="true"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1">Payout</h5>
                        <div class="text-center">
                            <input type="checkbox" class="js-switch save" data-key="payout_activation" value="1" @if(getSetting('payout_activation') == 1) checked @endif data-switchery="true"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1">Payment gateway</h5>
                        <div class="text-center">
                            <input type="checkbox" class="js-switch save" data-key="payment_gateway_activation" value="1" @if(getSetting('payment_gateway_activation') == 1) checked @endif data-switchery="true"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1">Pages</h5>
                        <div class="text-center">
                            <input type="checkbox" class="js-switch save" data-key="pages_activation" value="1" @if(getSetting('pages_activation') == 1) checked @endif data-switchery="true"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1">User management</h5>
                        <div class="text-center">
                            <input type="checkbox" class="js-switch save" data-key="user_management_activation" value="1" @if(getSetting('user_management_activation') == 1) checked @endif data-switchery="true"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1">Newsletter</h5>
                        <div class="text-center">
                            <input type="checkbox" class="js-switch save" data-key="newsletter_activation" value="1" @if(getSetting('newsletter_activation') == 1) checked @endif data-switchery="true"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1">FAQ</h5>
                        <div class="text-center">
                            <input type="checkbox" class="js-switch save" data-key="faq_activation" value="1" @if(getSetting('faq_activation') == 1) checked @endif data-switchery="true"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1">Location</h5>
                        <div class="text-center">
                         <input type="checkbox" class="js-switch save" data-key="location_activation" value="1" @if(getSetting('location_activation') == 1) checked @endif data-switchery="true"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center p-1">Ekyc Verification</h5>
                        <div class="text-center">
                         <input type="checkbox" class="js-switch save" data-key="ekyc_verification_activation" value="1" @if(getSetting('ekyc_verification_activation') == 1) checked @endif data-switchery="true"/>
                        </div>
                    </div>
                </div>
            </div>
</div>
</div>                   
                
            
          
   
       

    <!-- push external js -->
    @endsection
    @push('script')
    
    <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
    <script>
        
        $('.save').change(function(){
           var key = $(this).data('key');
           var val = 0;
           if($(this).prop('checked')){
            val = 1;
           }
           
            $.ajax( {
                url: "{{ route('panel.setting.activation.store') }}",
                dataType: "json",
                method: "post",
                data:{
                    key:  key,
                    val:  val,
                },
                success: function (json) {
                    callback( json );
                }
            } );
        })
    </script>
    @endpush