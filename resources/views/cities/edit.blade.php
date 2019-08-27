@extends('layouts.app')

@section('page-title')
    
 City
@endsection

@section('small-title')
 
@endsection

@section('content')


    <!-- Main content -->
    <section class="content">
        
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Edit City</h3>
          @include('flash::message')

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
            {{-- @include('validation_errors') --}}
            {!! Form::model($model, [
                'action' => ['CitiesController@update', $model->id],
                'method' => 'put'
            ]) !!}

            <div class="form-group">
                <label for="name">Name</label>
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>

            {!! Form::close() !!}
        </div>
    </div>
      <!-- /.box -->

    </section>
<!-- /.content -->
@endsection
