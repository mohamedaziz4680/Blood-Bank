@extends('layouts.app')


@section('page-title')
 Cities   
@endsection

@section('small-title')
 list of cities 
@endsection

@section('content')


    <!-- Main content -->
    <section class="content">
        
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">CIties</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <a href="{{url(route('governorate.cities.create',$governorate_id))}}" class="btn btn-primary"><i class="fa fa-plus"></i> New City</a>
          @include('flash::message')
          @if (count($records))
                
                  <table class="table table-bordered">
                    <tbody>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th class="text-center">Edit</th>
                      <th class="text-center">Delete</th>
                      <th style="width: 40px">Label</th>
                    </tr>
                    @foreach ($records as $record)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$record->name}}</td>
                            <td class="text-center">
                                <a href="{{route('governorate.cities.edit', [$record->id, $governorate_id])}}" class="btn btn-success">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                {!! Form::open([
                                    'action' => ['CitiesController@destroy', [$record->id, $governorate_id]],
                                    'method' => 'delete'
                                ]) !!}
                                <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                {!! Form::close()!!}
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
                
                <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            <li><a href="#">«</a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">»</a></li>
                        </ul>
                    </div>
                 
            @else
                <div class="alert alert danger" role="alert">
                    No data
                </div>
          @endif
        </div>
    </div>
      <!-- /.box -->

    </section>
<!-- /.content -->
@endsection
