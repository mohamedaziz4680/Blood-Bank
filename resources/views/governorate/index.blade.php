@extends('layouts.app')
@inject('client', 'App\Models\Client')
@inject('donation', 'App\Models\DonationRequest')

@section('page-title')
 Governorates   
@endsection

@section('small-title')
 list of governorates 
@endsection

@section('content')


    <!-- Main content -->
    <section class="content">
        
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Governorates</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <a href="{{url(route('governorate.create'))}}" class="btn btn-primary"><i class="fa fa-plus"></i> New Governorate</a>
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
                            <td><a href="{{url(route('governorate.cities.index', $record->id))}}">{{$record->name}}</a></td>
                            <td class="text-center">
                                <a href="{{url(route('governorate.edit', $record->id))}}" class="btn btn-success">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                {!! Form::open([
                                    'action' => ['GovernorateController@destroy', $record->id],
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
