@extends('phobrv::layout.app')

@section('header')
<a href="{{route('order.index')}}"  class="btn btn-default float-left">
	<i class="fa fa-backward"></i> @lang('Back')
</a>
@endsection

@section('content')
<div class="box box-primary">
	<form action="{{route('order.update',['order'=>$data['post']->id])}}" method="post"  class="form-horizontal">
		<div class="box-body">
			@csrf
			@method('put')
			@include('phobrv::input.inputSelect',['label'=>'Tình trạng đơn hàng','key'=>'status','array'=>config('brvreceive.orderStatus'),'default'=>'pedding'])
			@include('phobrv::input.inputText',['label'=>'Người mua','key'=>'name','readonly'=>'readonly'])
			@include('phobrv::input.inputText',['label'=>'Địa chỉ','key'=>'name','readonly'=>'readonly'])
			@include('phobrv::input.inputText',['label'=>'Phone','key'=>'phone','readonly'=>'readonly'])
			@include('phobrv::input.inputText',['label'=>'Ghi chú đơn hàng','key'=>'description','readonly'=>'readonly'])
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label"> Content </label>
				<div class="col-sm-10">
					{!! $data['post']->content !!}
				</div>
			</div>
		</div>
		<div class="box-footer">
			<button type="submit" class="btn btn-primary  pull-right">
				@lang('Update')
			</button>
		</div>
	</form>
</div>
@endsection

@section('styles')

@endsection

@section('scripts')

@endsection