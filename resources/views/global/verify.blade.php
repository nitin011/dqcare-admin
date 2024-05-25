@extends('frontend.layouts.assets')


@section('meta_data')
    @php
		$meta_title = 'Verify | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'Defenzelite';		
		$meta_author_email = '' ?? 'support@defenzelite.com';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';		
	@endphp
@endsection

@section('content')
   <!-- Hero Start -->
   <div style="margin-top: 50px;">
    <table cellpadding="0" cellspacing="0" style="font-family: Nunito, sans-serif; font-size: 15px; font-weight: 400; max-width: 600px; border: none; margin: 0 auto; border-radius: 6px; overflow: hidden; background-color: #fff; box-shadow: 0 0 3px rgba(60, 72, 88, 0.15);">
        <thead>
            <tr style="background-color: #2f55d4; padding: 3px 0; line-height: 68px; text-align: center; color: #fff; font-size: 24px; font-weight: 700; letter-spacing: 1px;">
                <th scope="col"><img src="assets/images/logo-light.png" height="24" alt=""></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td style="padding: 24px 24px;">
                    <div style="padding: 8px; color: #e43f52; background-color: rgba(228, 63, 82, 0.2); border: 1px solid rgba(228, 63, 82, 0.2); border-radius: 6px; text-align: center; font-size: 16px; font-weight: 600;">
                        Warning: You're approaching your limit. Please upgrade.
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding: 0 24px 15px; color: #8492a6;">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="padding: 0 24px 15px; color: #8492a6;">
                    Before proceeding, please check your email for a verification link.
                </td>
            </tr>

            <tr>
                <td style="padding: 15px 24px;">
                    <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                        <button style="padding: 8px 20px; outline: none; text-decoration: none; font-size: 16px; letter-spacing: 0.5px; transition: all 0.3s; font-weight: 600; border-radius: 6px; background-color: #2f55d4; border: 1px solid #2f55d4; color: #ffffff;" type="submit">Upgrade Account</button>
                    </form>
                </td>
            </tr>

            <tr>
                <td style="padding: 15px 24px 0; color: #8492a6;">
                    Thanks for viewing {{ getSetting('app_name') }}.
                </td>
            </tr>

            <tr>
                <td style="padding: 15px 24px 15px; color: #8492a6;">
                    {{ getSetting('app_name') }} <br> Support Team
                </td>
            </tr>

            <tr>
                <td style="padding: 16px 8px; color: #8492a6; background-color: #f8f9fc; text-align: center;">
                    © <script>document.write(new Date().getFullYear())</script> {{ getSetting('app_name') }}.
                </td>
            </tr>
        </tbody>
    </table>
</div>
<!-- Hero End -->
@endsection