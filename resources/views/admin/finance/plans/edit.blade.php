@extends('layouts.app')

@section('css')
	<link href="{{URL::asset('plugins/tippy/scale-extreme.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('plugins/tippy/material.css')}}" rel="stylesheet" />
@endsection

@section('page-header')
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7"> 
		<div class="page-leftheader">
			<h4 class="page-title mb-0">{{ __('Update Subscription Plan') }}</h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-sack-dollar mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.finance.dashboard') }}"> {{ __('Finance Management') }}</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.finance.plans') }}"> {{ __('Subscription Plans') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="{{url('#')}}"> {{ __('Update Subscription Plan') }}</a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
@endsection

@section('content')						
	<div class="row">
		<div class="col-lg-10 col-md-12 col-xm-12">
			<div class="card border-0">
				<div class="card-header">
					<h3 class="card-title">{{ __('Update Subscription Plan') }}</h3>
				</div>
				<div class="card-body pt-5">									
					<form action="{{ route('admin.finance.plan.update', $id) }}" method="POST" enctype="multipart/form-data">
						@method('PUT')
						@csrf

						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12">						
								<div class="input-box">	
									<h6>{{ __('Plan Status') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<select id="plan-status" name="plan-status" data-placeholder="{{ __('Select Plan Status') }}:">			
										<option value="active" @if ($id->status == 'active') selected @endif>{{ __('Active') }}</option>
										<option value="closed" @if ($id->status == 'closed') selected @endif>{{ __('Closed') }}</option>
									</select>
									@error('plan-status')
										<p class="text-danger">{{ $errors->first('plan-status') }}</p>
									@enderror	
								</div>						
							</div>							
							<div class="col-lg-6 col-md-6 col-sm-12">							
								<div class="input-box">								
									<h6>{{ __('Plan Name') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<div class="form-group">							    
										<input type="text" class="form-control" id="plan-name" name="plan-name" value="{{ $id->plan_name }}" required>
									</div> 
									@error('plan-name')
										<p class="text-danger">{{ $errors->first('plan-name') }}</p>
									@enderror
								</div> 						
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">							
								<div class="input-box">								
									<h6>{{ __('Price') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<div class="form-group">							    
										<input type="text" class="form-control" id="cost" name="cost" value="{{ $id->price }}" required>
									</div> 
									@error('cost')
										<p class="text-danger">{{ $errors->first('cost') }}</p>
									@enderror
								</div> 						
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">							
								<div class="input-box">								
									<h6>{{ __('Currency') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<select id="currency" name="currency" data-placeholder="{{ __('Select Currency') }}:">			
										@foreach(config('currencies.all') as $key => $value)
											<option value="{{ $key }}" @if( $id->currency == $key) selected @endif>{{ $value['name'] }} - {{ $key }} ({{ $value['symbol'] }})</option>
										@endforeach
									</select>
									@error('currency')
										<p class="text-danger">{{ $errors->first('currency') }}</p>
									@enderror
								</div> 						
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">							
								<div class="input-box">								
									<h6>{{ __('Payment Frequence') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<select id="frequency" name="frequency" data-placeholder="{{ __('Select Payment Frequency') }}:" data-callback="duration_select">		
										<option value="monthly" @if ($id->payment_frequency == 'monthly') selected @endif>{{ __('Monthly') }}</option>
										<option value="yearly" @if ($id->payment_frequency == 'yearly') selected @endif>{{ __('Yearly') }}</option>
										<option value="lifetime" @if ($id->payment_frequency == 'lifetime') selected @endif>{{ __('Lifetime') }}</option>
									</select>
								</div> 						
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">							
								<div class="input-box">								
									<h6>{{ __('Featured Plan') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<select id="featured" name="featured" data-placeholder="{{ __('Select if Plan is Featured') }}:">		
										<option value=1 @if ($id->featured == true) selected @endif>{{ __('Yes') }}</option>
										<option value=0 @if ($id->featured == false) selected @endif>{{ __('No') }}</option>
									</select>
								</div> 						
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">							
								<div class="input-box">								
									<h6>{{ __('Free Plan') }}</h6>
									<div class="form-group">							    
										<select id="free-plan" name="free-plan" data-placeholder="{{ __('Make this plan a Free Plan?') }}:">			
											<option value=1 @if ($id->free == true) selected @endif>{{ ('Yes') }}</option>
											<option value=0 @if ($id->free == false) selected @endif>{{ ('No') }}</option>
										</select>
									</div> 
									@error('free-plan')
										<p class="text-danger">{{ $errors->first('free-plan') }}</p>
									@enderror
								</div> 						
							</div>
						</div>

						<div class="card special-shadow border-0" id="payment-gateways">
							<div class="card-body">
								<h6 class="fs-12 font-weight-bold mb-5"><i class="fa fa-bank text-info fs-14 mr-1 fw-2"></i>{{ __('Payment Gateways Plan IDs') }}</h6>

								<div class="row">								
									<div class="col-lg-6 col-md-6 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('PayPal Plan ID') }} <span class="text-danger">({{ __('Required for Paypal') }}) <i class="ml-2 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('You have to get Paypal Plan ID in your Paypal account. Refer to the documentation if you need help with creating one') }}."></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control" id="paypal_gateway_plan_id" name="paypal_gateway_plan_id" value="{{ $id->paypal_gateway_plan_id }}">
											</div> 
											@error('paypal_gateway_plan_id')
												<p class="text-danger">{{ $errors->first('paypal_gateway_plan_id') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('Stripe Product ID') }} <span class="text-danger">({{ __('Required for Stripe') }}) <i class="ml-2 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('You have to get Stripe Product ID in your Stripe account. Refer to the documentation if you need help with creating one') }}."></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control" id="stripe_gateway_plan_id" name="stripe_gateway_plan_id" value="{{ $id->stripe_gateway_plan_id }}">
											</div> 
											@error('stripe_gateway_plan_id')
												<p class="text-danger">{{ $errors->first('stripe_gateway_plan_id') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('Paystack Plan Code') }} <span class="text-danger">({{ __('Required for Paystack') }}) <i class="ml-2 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('You have to get Paystack Plan ID in your Paystack account. Refer to the documentation if you need help with creating one') }}."></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control" id="paystack_gateway_plan_id" name="paystack_gateway_plan_id" value="{{ $id->paystack_gateway_plan_id }}">
											</div> 
											@error('paystack_gateway_plan_id')
												<p class="text-danger">{{ $errors->first('paystack_gateway_plan_id') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('Razorpay Plan ID') }} <span class="text-danger">({{ __('Required for Razorpay') }}) <i class="ml-2 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('You have to get Razorpay Plan ID in your Razorpay account. Refer to the documentation if you need help with creating one') }}."></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control" id="razorpay_gateway_plan_id" name="razorpay_gateway_plan_id" value="{{ $id->razorpay_gateway_plan_id }}">
											</div> 
											@error('razorpay_gateway_plan_id')
												<p class="text-danger">{{ $errors->first('razorpay_gateway_plan_id') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">							
										<div class="input-box">																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																															
											<h6>{{ __('Flutterwave Plan ID') }} <span class="text-danger">({{ __('Required for Flutterwave') }}) <i class="ml-2 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('You have to get Flutterwave Plan ID in your Flutterwave account. Refer to the documentation if you need help with creating one') }}."></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control" id="flutterwave_gateway_plan_id" name="flutterwave_gateway_plan_id" value="{{ $id->flutterwave_gateway_plan_id }}">
											</div> 
											@error('flutterwave_gateway_plan_id')
												<p class="text-danger">{{ $errors->first('flutterwave_gateway_plan_id') }}</p>
											@enderror
										</div> 						
									</div>
								</div>
							</div>						
						</div>

						<div class="card mt-6 mb-7 special-shadow border-0">
							<div class="card-body">
								<h6 class="fs-12 font-weight-bold mb-5"><i class="fa-solid fa-box-circle-check text-info fs-14 mr-1 fw-2"></i>{{ __('Included Features') }}</h6>

								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('Words included in the Plan') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span> <span class="text-muted ml-3">({{ __('Renewed Monthly') }})</span></h6>
											<div class="form-group">							    
												<input type="number" class="form-control" id="words" name="words" value="{{ $id->words }}" required>
												<span class="text-muted fs-10">{{ __('Each text generation task will count total input by user and output words by openai') }}</span>
											</div> 
											@error('words')
												<p class="text-danger">{{ $errors->first('words') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-lg-12 col-md-12 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('Images included in the Plan') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span> <span class="text-muted ml-3">({{ __('Renewed Monthly') }})</span></h6>
											<div class="form-group">							    
												<input type="number" class="form-control" id="images" name="images" value="{{ $id->images }}" required>
												<span class="text-muted fs-10">{{ __('Valid for all image sizes') }}</span>
											</div> 
											@error('images')
												<p class="text-danger">{{ $errors->first('images') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-lg-12 col-md-12 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('Characters included in the Plan') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span> <span class="text-muted ml-3">({{ __('Renewed Monthly') }})</span></h6>
											<div class="form-group">							    
												<input type="number" class="form-control" id="characters" name="characters" value="{{ $id->characters }}" required>
												<span class="text-muted fs-10">{{ __('For AI Voiceover feature') }}</span>
											</div> 
											@error('characters')
												<p class="text-danger">{{ $errors->first('characters') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-lg-12 col-md-12 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('Minutes included in the Plan') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span><span class="text-muted ml-3">({{ __('Renewed Monthly') }})</span></h6>
											<div class="form-group">							    
												<input type="number" class="form-control" id="minutes" name="minutes" value="{{ $id->minutes }}" required>
												<span class="text-muted fs-10">{{ __('For AI Speech to Text feature') }}</span>
											</div> 
											@error('minutes')
												<p class="text-danger">{{ $errors->first('minutes') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<h6>{{ __('OpenAI Model for All Text Results') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<select id="default-model-user" name="model" data-placeholder="{{ __('Select OpenAI Model Type') }}:">			
												<option value="text-ada-001" @if ($id->model == 'text-ada-001') selected @endif>{{ __('Ada') }} ({{ __('GPT 3') }})</option>
												<option value="text-babbage-001" @if ($id->model == 'text-babbage-001') selected @endif>{{ __('Babbage') }} ({{ __('GPT 3') }})</option>
												<option value="text-curie-001" @if ($id->model == 'text-curie-001') selected @endif>{{ __('Curie') }} ({{ __('GPT 3') }})</option>
												<option value="text-davinci-003" @if ($id->model == 'text-davinci-003') selected @endif>{{ __('Davinci') }} ({{ __('GPT 3') }})</option>
												<option value="gpt-3.5-turbo" @if ($id->model == 'gpt-3.5-turbo') selected @endif>{{ __('GPT 3.5 Turbo') }}</option>
												<option value="gpt-3.5-turbo-16k" @if ( $id->model == 'gpt-3.5-turbo-16k') selected @endif>{{ __('GPT 3.5 Turbo') }} ({{ __('16K') }})</option>
												<option value="gpt-4" @if ($id->model == 'gpt-4') selected @endif>{{ __('GPT 4') }} ({{ __('8K') }})</option>
												<option value="gpt-4-32k" @if ($id->model == 'gpt-4-32k') selected @endif>{{ __('GPT 4') }} ({{ __('32K') }})</option>
											</select>
										</div>
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<h6>{{ __('Templates Access') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<select id="templates" name="templates" data-placeholder="{{ __('Set Templates Access') }}">
												<option value="all" @if ($id->templates == 'all') selected @endif>{{ __('All Templates') }}</option>
												<option value="free" @if ($id->templates == 'free') selected @endif>{{ __('Only Free Templates') }}</option>																																											
												<option value="standard" @if ($id->templates == 'standard') selected @endif> {{ __('Up to Standard Templates') }}</option>
												<option value="professional" @if ($id->templates == 'professional') selected @endif> {{ __('Up to Professional Templates') }}</option>
												<option value="premium" @if ($id->templates == 'premium') selected @endif> {{ __('Up to Premium Templates') }} ({{ __('All') }})</option>																																																														
											</select>
										</div>
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('Max Allowed Words Limit for All Text Results') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span><i class="ml-2 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('OpenAI will treat this limit as a stop marker. i.e. If you set it to 500, openai will try to stop as it will create a text with 500 tokens, but it can also ignore it on some cases') }}."></i></h6>
											<div class="form-group">							    
												<input type="number" class="form-control" id="tokens" name="tokens" value="{{ $id->max_tokens }}" required>
											</div> 
											@error('tokens')
												<p class="text-danger">{{ $errors->first('words') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<h6>{{ __('AI Image Feature') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<select id="image-feature" name="image-feature" data-placeholder="{{ __('Allow/Deny AI Image Feature Usage') }}">
												<option value=1 @if ($id->image_feature == true) selected @endif>{{ __('Allow') }}</option>
												<option value=0 @if ($id->image_feature == false) selected @endif> {{ __('Deny') }}</option>																														
											</select>
										</div>
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<h6>{{ __('AI Voiceover Feature') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<select id="voiceover-feature" name="voiceover-feature" data-placeholder="{{ __('Allow/Deny AI Voiceover Feature Usage') }}">
												<option value=1 @if ($id->voiceover_feature == true) selected @endif>{{ __('Allow') }}</option>
												<option value=0 @if ($id->voiceover_feature == false) selected @endif> {{ __('Deny') }}</option>																														
											</select>
										</div>
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<h6>{{ __('AI Speech to Text Feature') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<select id="whisper-feature" name="whisper-feature" data-placeholder="{{ __('Allow/Deny AI Speech to Text Feature Usage') }}">
												<option value=1 @if ($id->transcribe_feature == true) selected @endif>{{ __('Allow') }}</option>
												<option value=0 @if ($id->transcribe_feature == false) selected @endif> {{ __('Deny') }}</option>																															
											</select>
										</div>
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<h6>{{ __('AI Chat Feature') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<select id="chat-feature" name="chat-feature" data-placeholder="{{ __('Allow/Deny AI Chat Feature Usage') }}">
												<option value=1 @if ($id->chat_feature == true) selected @endif>{{ __('Allow') }}</option>
												<option value=0 @if ($id->chat_feature == false) selected @endif> {{ __('Deny') }}</option>																														
											</select>
										</div>
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<h6>{{ __('AI Code Feature') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<select id="code-feature" name="code-feature" data-placeholder="{{ __('Allow/Deny AI Code Feature Usage') }}">
												<option value=1 @if ($id->code_feature == true) selected @endif>{{ __('Allow') }}</option>
												<option value=0 @if ($id->code_feature == false) selected @endif> {{ __('Deny') }}</option>																														
											</select>
										</div>
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<h6>{{ __('AI Chat Types Access') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<select id="chats" name="chats" data-placeholder="{{ __('Set AI Chat Type Access') }}">
												<option value="all" @if ($id->chats == 'all') selected @endif>{{ __('All Chat Types') }}</option>
												<option value="free" @if ($id->chats == 'free') selected @endif>{{ __('Only Free Chat Types') }}</option>																																											
												<option value="standard" @if ($id->chats == 'standard') selected @endif> {{ __('Up to Standard Chat Types') }}</option>
												<option value="professional" @if ($id->chats == 'professional') selected @endif> {{ __('Up to Professional Chat Types') }}</option>
												<option value="premium" @if ($id->chats == 'premium') selected @endif> {{ __('Up to Premium Chat Types') }} ({{ __('All') }})</option>																																																														
											</select>
										</div>
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('Number of Team Members') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span><i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('Define how many team members a user is allowed to create under this subscription plan') }}."></i></h6>
											<div class="form-group">							    
												<input type="number" class="form-control" id="team-members" name="team-members" value="{{ $id->team_members }}" required>
											</div> 
											@error('team-members')
												<p class="text-danger">{{ $errors->first('team-members') }}</p>
											@enderror
										</div> 						
									</div>
								</div>
							</div>
						</div>

						<div class="row mt-6">
							<div class="col-12">
								<div class="input-box">	
									<h6>{{ __('Primary Heading') }} <span class="text-muted">({{ __('Optional') }})</span></h6>
									<div class="form-group">							    
										<input type="text" class="form-control" id="primary-heading" name="primary-heading" value="{{ $id->primary_heading }}">
									</div>
								</div>
							</div>
						</div>

						<div class="row mt-6">
							<div class="col-lg-12 col-md-12 col-sm-12">	
								<div class="input-box">	
									<h6>{{ __('Plan Features') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span> <span class="text-danger ml-3">({{ __('Comma Seperated') }})</span></h6>							
									<textarea class="form-control" name="features" rows="10">{{ $id->plan_features }}</textarea>
									@error('features')
										<p class="text-danger">{{ $errors->first('features') }}</p>
									@enderror	
								</div>											
							</div>
						</div>
						

						<!-- ACTION BUTTON -->
						<div class="border-0 text-right mb-2 mt-1">
							<a href="{{ route('admin.finance.plans') }}" class="btn btn-cancel mr-2">{{ __('Cancel') }}</a>
							<button type="submit" class="btn btn-primary">{{ __('Update') }}</button>							
						</div>				

					</form>					
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script src="{{URL::asset('plugins/tippy/popper.min.js')}}"></script>
	<script src="{{URL::asset('plugins/tippy/tippy-bundle.umd.min.js')}}"></script>
	<script>
		 $(function () {
			tippy('[data-tippy-content]', {
				animation: 'scale-extreme',
				theme: 'material',
			});
		 });

		 function duration_select(value) {
			if (value == 'lifetime') {
				$('#payment-gateways').css('display', 'none');
			} else {
				$('#payment-gateways').css('display', 'block');
			}
		 }
	</script>
@endsection
