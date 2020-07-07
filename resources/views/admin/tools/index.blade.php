@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.tool.title') }}
    </div>

    <div class="card-body">
        <p>
            <div class="row">
                <div class="col-12">
                    <h4>Управление режимом блокировки ЛК на тех. обслуживание</h4>
                </div>
               <div class="col-auto">
                   <form  action="{{route('admin.tools.maintenance.up')}}"  method="GET">
                       @csrf
                       <button type="submit" class="btn btn-success mt-2">Разблокировать ЛК</button>
                   </form>
               </div>
            <div class="col-auto">
                <form  action="{{route('admin.tools.maintenance.down')}}"  method="GET">
                    @csrf
                    <button type="submit" class="btn btn-danger mt-2">Заблокировать ЛК</button>
                </form>
            </div>
                <div class="col-12">
                    <hr>
                </div>
           </div>

            <div class="row">
                <div class="col-12">
                    <h4>Очистка кэша</h4>
                </div>
                <div class="col-auto">
                    <form  action="{{route('admin.tools.maintenance.clearCache')}}"  method="GET">
                        @csrf
                        <button type="submit" class="btn btn-success mt-2">Очистить кэш</button>
                    </form>
                </div>
                <div class="col-12">
                    <hr>
                </div>
            </div>

        </p>
    </div>
</div>



@endsection
