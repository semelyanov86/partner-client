@extends('shareholder.layouts.main_app')
@section('page-title') Оставить отзыв @endsection
@section('page-content')
    <div class="card m-auto w-100" >
        <div class="card-header">
           <h4 class="text-center">
               Отзыв-сообщение
           </h4>
            <p>
                Оставьте отзыв/предложение.
                <br>
                Все указанные данные в этом сообщении доступны только уполномоченным сотрудникам головного офиса.
            </p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                @if(count($errors) > 0)
                    <p class="alert alert-danger">
                        @if($errors->has('image-upload'))
                            {{$errors->first('image-upload')}};
                            <br>
                        @endif
                        @if($errors->has('comment'))
                            {{$errors->first('comment')}};
                            <br>
                        @endif
                        @if($errors->has('place'))
                            {{$errors->first('place')}};
                            <br>
                        @endif
                    </p>
                @endif
                <form action="{{route('client.feedback.submit')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <label for="comment">Комментарий: <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="comment" name="comment" placeholder="" required>{{ old('comment', null) }}</textarea>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="email">Контакты для связи E-mail (по желанию):</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="far fa-envelope"></i></div>
                                </div>
                                <input type="email" class="form-control" id="email" name="email" placeholder="my@mail.ru" value="{{ old('email', null) }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="phone">Контакты для связи Телефон : <span class="text-danger">*</span></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="mdi mdi-phone"></i></div>
                                </div>
                                <input type="text" class="form-control masked-phone" id="phone" name="phone" value="{{ Auth::user()->phone }}" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="place">Населенный пункт. : <span class="text-danger">*</span></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-city"></i></div>
                                </div>
                                <select class="form-control" id="place" name="place" required>
                                    <option value="">Не выбрано</option>
                                    @foreach ($places as $place)
                                        @if($place->id ==  old('place', null))
                                            <option selected="selected" value="{{$place->id}}">{{$place->name}}</option>
                                        @else
                                            <option value="{{$place->id}}">{{$place->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="image-upload">Картинка (до 3мб) :</label>
                            <div class="input-group mb-2">
                                <div class="custom-file">
                                    <input type="file" name="image-upload" class="form-control-file">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center py-3">
                            <button type="submit" class="btn btn-teal w">ОТПРАВИТЬ</button>
                        </div>
                    </div>
                </form>
            </li>
        </ul>
    </div>
@endsection
