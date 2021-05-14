@extends('phobrv::layout.app')

@section('header')
<ul>
	<li>
		{{ Form::open(array('route'=>'order.setDefaultSelect','method'=>'post')) }}
		<table class="form" width="100%" border="0" cellspacing="1" cellpadding="1">
			<tbody>
				<tr>
					<td style="text-align:center; padding-right: 10px;">
						<div class="form-group">
							{{ Form::select('select',$orderStatus,(isset($data['select']) ? $data['select'] : '0'),array('id'=>'choose','class'=>'form-control')) }}
						</div>
					</td>
					<td>
						<div class="form-group">
							<button id="btnSubmitFilter" class="btn btn-primary ">@lang('Filter')</button>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		{{Form::close()}}
	</li>
</ul>
@endsection

@section('content')
<div class="box box-primary">
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Date</th>
					<th>Info</th>
					<th class="text-center">Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@isset($data['orders'])
				@foreach($data['orders'] as $r)
				<tr>
					<td align="center">{{$loop->index+1}}</td>
					<td>{{$r->created_at}}</td>
					<td>
						Name: {{$r->name}} <br>
						Phone: {{$r->phone}} <br>
						Add: {{$r->add}} <br>
					</td>
					<td align="center" style="font-weight: bold;">
						<span style="color: @if($r->status == 'pendding') orange @elseif($r->status == 'success') green @else red @endif  ">
							{{$orderStatus[$r->status]}}
						</span>
					</td>
					<td align="center">
						<a href="{{route('order.edit',array('order'=>$r->id))}}">
							<i class="fa fa-edit" title="Sửa"></i>
						</a>
						&nbsp;&nbsp;&nbsp;
						<a style="color: red" href="#" onclick="destroy('destroy{{$r->id}}')"><i class="fa fa-times" title="Sửa"></i></a>
						<form id="destroy{{$r->id}}" action="{{ route('order.destroy',array('order'=>$r->id)) }}" method="post" style="display: none;">
							@method('delete')
		                    @csrf
		                </form>
					</td>
				</tr>

				@endforeach
				@endif
			</tbody>

		</table>

	</div>
</div>

@endsection

@section('styles')

@endsection

@section('scripts')

<script type="text/javascript">
	function destroy(form){
		var anwser =  confirm("Bạn muốn xóa order này?");
		if(anwser){
			event.preventDefault();
			document.getElementById(form).submit();
		}
	}
</script>
@endsection