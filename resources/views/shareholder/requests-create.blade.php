@extends('shareholder.layouts.main_app')
@section('page-title') Новая заявка @endsection
@section('page-content')
    <div class="row">
        <div class="col-12">
            <p class="alert alert-danger w-100">
               Раздел находится в разработке!!! Отправка заявок не возможна!!!
            </p>
        </div>
    </div>
    <div class="card m-auto w-100" >
        <div class="card-header">
            <h4 class="text-center">
                Онлайн заявка на заем
            </h4>
            <p>
                Для заполнения заявки потребуются: паспортные данные, СНИЛС, ИНН, сведения о трудовой деятельности, контактные данные (Ваши и Ваших поручителей).
                Желательно указать свою личную <span class="text-primary">электронную@почту.ru</span> или почту доверенного лица. Данные поручителей вводятся через запятую в специальных полях.
                После нажатия клавиши "Отправить заявку" она отправляется в обработку, а Вы получаете уведомление об успешной отправке.
                Если уведомления нет, возможно не все поля заполнены, пролистайте заявку, такие поля будут помечены красным текстовым маркером.
                На сайте работает онл@йн чат с оператором, в нем можно получить необходимую информацию, отправить сканкопии / фото документов, фото залогового имущества и другую информацию.
                Для оперативности первым сообщением в онл@йн чате сообщите в каком городе планируете воспользоваться нашими услугами. Для получения новостей вступите в нашу группу ВК
                <a href="https://vk.com/kpkgpartner">https://vk.com/kpkgpartner</a>
                До скорой встречи!
            </p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                @if($errors->has('error_msg'))
                    <p class="alert alert-danger">
                        {{ $errors->first('error_msg') }}
                    </p>
                @elseif(count($errors) > 0)
                    <p class="alert alert-danger">
                      Есть ошибки при заполнении!!!
                    </p>
                @endif
                    <div class="row">
                        <div class="col-12 col-lg-6 py-3">
                            <button class="btn btn-primary w-100" id="get-shareholer-info"><i class="ti-pencil-alt"></i> Заполнить реквизиты из базы</button>
                        </div>
                    </div>
                    <form action="{{route('client.requests.create.submit')}}" method="POST" enctype="multipart/form-data" id="request-form">
                    @csrf
                    <div class="row" id="fields">
                        @foreach($fields as $field)
                            <div class="col-12 {{$field->type != 'textarea' ? ' col-lg-6' : ''}}">
                                <div class="form-group">
                                    <label for="{{$field->key}}" class="{{$field->type == 'boolean' ? ' invisible ' : ''}}">
                                        {{$field->title}}:
                                        @if($field->required == 1)
                                            <span class="text-danger"> *</span>
                                        @endif
                                    </label>

                                    @switch($field->type)
                                        @case('string')
                                        <input type="text" class="form-control {{$errors->has($field->key) ? ' border-danger ' : ''}}" id="{{$field->key}}" name="{{$field->key}}"
                                               placeholder="{{$field->placeholder}}" @if($field->required == 1) required @endif value="{{ old($field->key, null) }}" {{$field->read_only == true ? ' readonly ' : ''}}>
                                        @break

                                        @case('date')
                                        <input type="date" class="form-control {{$errors->has($field->key) ? ' border-danger ' : ''}}" id="{{$field->key}}" name="{{$field->key}}"
                                               placeholder="{{$field->placeholder}}" @if($field->required == 1) required @endif value="{{ old($field->key, null) }}" {{$field->read_only == true ? ' readonly ' : ''}}>
                                        @break

                                        @case('number')
                                        <input type="number" class="form-control {{$errors->has($field->key) ? ' border-danger ' : ''}}" id="{{$field->key}}" name="{{$field->key}}"
                                               placeholder="{{$field->placeholder}}" @if($field->required == 1) required @endif value="{{ old($field->key, null) }}" {{$field->read_only == true ? ' readonly ' : ''}}>
                                        @break

                                        @case('phone')
                                        <input type="text" class="form-control masked-phone {{$errors->has($field->key) ? ' border-danger ' : ''}}" id="{{$field->key}}" name="{{$field->key}}"
                                               @if($field->required == 1) required @endif value="{{ old($field->key, null) }}" {{$field->read_only == true ? ' readonly ' : ''}}>
                                        @break

                                        @case('email')
                                        <input type="email" class="form-control {{$errors->has($field->key) ? ' border-danger ' : ''}}" id="{{$field->key}}" name="{{$field->key}}" placeholder="{{$field->placeholder}}"
                                               @if($field->required == 1) required @endif value="{{ old($field->key, null) }}" {{$field->read_only == true ? ' readonly ' : ''}}>
                                        @break

                                        @case('boolean')
                                        <div class="checkbox {{$errors->has($field->key) ? ' checkbox-danger ' : 'checkbox-primary'}} ">
                                            <input type="checkbox" id="{{$field->key}}" name="{{$field->key}}" {{ old($field->key, null) == 'on' ? ' checked ' : ' unchecked ' }} @if($field->required == 1) required @endif {{$field->read_only == true ? ' readonly ' : ''}}>
                                            <label for="{{$field->key}}">
                                                {{$field->title}}
                                                @if($field->required == 1)
                                                    <span class="text-danger"> *</span>
                                                @endif
                                            </label>
                                        </div>
                                        @break

                                        @case('file')
                                        <input type="file" class=" upload-file {{$errors->has($field->key) ? ' border-danger ' : ''}} " id="{{$field->key}}" name="{{$field->key}}" @if($field->required == 1) required @endif {{$field->read_only == true ? ' readonly ' : ''}}>
                                        @break

                                        @case('textarea')
                                        <textarea class="form-control {{$errors->has($field->key) ? ' border-danger ' : ''}} " id="{{$field->key}}" name="{{$field->key}}"
                                                  placeholder="{{$field->placeholder}}" @if($field->required == 1) required @endif {{$field->read_only == true ? ' readonly ' : ''}}>
                                            {{ old($field->key, null) }}
                                        </textarea>

                                        @break

                                        @default
                                            <input type="text" class="form-control {{$errors->has($field->key) ? ' border-danger ' : ''}}" id="{{$field->key}}" name="{{$field->key}}"
                                                   placeholder="{{$field->placeholder}}" @if($field->required == 1) required @endif value="{{ old($field->key, null) }}" {{$field->read_only == true ? ' readonly ' : ''}}>
                                    @endswitch

                                    @if($errors->has($field->key))
                                        <div class="text-danger">
                                            {{ $errors->first($field->key) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="row">
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
                    </div>
                    <div class="row invisible">
                        <div class="col-12 col-lg-6">
                            <input class="form-control" type="text" id="sms_code" name="sms_code" readonly>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-around">
                        <div class="col-12 col-lg-10">
                            <div class="form-group">
                                <label for="personal_data_accept" class="invisible">
                                    Согласие
                                </label>
                                <div class="checkbox checkbox-primary">
                                    <input type="checkbox" id="personal_data_accept" name="personal_data_accept" required>
                                    <label for="personal_data_accept">
                                        Нажимая кнопку Отправить заявку, я даю свое согласие на обработку персональных данных, в соответствии с Федеральным законом "О персональных данных".
                                        <span class="text-danger"> *</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center py-3">
                            <button type="submit" id="submit-btn" class="btn btn-teal">ОТПРАВИТЬ ЗАЯВКУ</button>
                        </div>
                    </div>
                </form>
            </li>
        </ul>
    </div>

    <!-- Personal data accept Modal -->
    <div class="modal fade" id="personalDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="personalDataModalLabel">Согласие на обработку персональных данных:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="НЕ ПРИНИМАЮ">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Согласие на обработку персональных данных </p>
                    <p>Настоящим в соответствии с Федеральным законом № 152-ФЗ «О персональных данных» от 27.07.2006 года свободно, своей волей и в своем интересе
                        выражаю свое безусловное согласие на обработку моих персональных данных КПКГ "Партнер" ОГРН 1021800991871 ИНН/КПП 1827018260/183801001,
                        зарегистрированным в соответствии с законодательством РФ по адресу:</p>
                    <p>427960, УР, г. Сарапул, ул. Азина, д.65</p>
                    <p>т/ф  (34147) 2-10-80 (далее по тексту - Оператор).</p>
                    <p>Персональные данные - любая информация, относящаяся к определенному или определяемому на основании такой информации физическому лицу.</p>
                    <p>Настоящее Согласие выдано мною на обработку следующих персональных данных:</p>

                    @foreach($fields as $field)
                        @if($field->personal_data == true)
                            <p>- {{$field->title}};</p>
                        @endif
                    @endforeach

                    <p>Согласие дано Оператору для совершения следующих действий с моими персональными данными с использованием средств автоматизации
                        и/или без использования таких средств: сбор, систематизация, накопление, хранение, уточнение (обновление, изменение),
                        использование, обезличивание, а также осуществление любых иных действий, предусмотренных действующим законодательством РФ
                        как неавтоматизированными, так и автоматизированными способами.</p>
                    <p>Данное согласие дается Оператору для обработки моих персональных данных в следующих целях:</p>
                    <p>- предоставление мне услуг/работ;</p>
                    <p>- направление в мой адрес уведомлений, касающихся предоставляемых услуг/работ;</p>
                    <p>- подготовка и направление ответов на мои запросы;</p>
                    <p>- направление в мой адрес информации, в том числе рекламной, о
                        мероприятиях/товарах/услугах/работах Оператора.</p>
                    <p>
                        Настоящее согласие действует до момента его отзыва путем направления соответствующего уведомления на электронный адрес kpkpartner@mail.ru и
                        оператору лично по номеру 8-800-550-40-20. В случае отзыва мною согласия на обработку персональных данных Оператор вправе продолжить обработку
                        персональных данных без моего согласия при наличии оснований, указанных в пунктах 2 – 11 части 1 статьи 6, части 2 статьи 10 и части 2 статьи
                        11 Федерального закона №152-ФЗ «О персональных данных» от 26.06.2006 г.
                    </p>
                </div>
                <div class="modal-footer d-block">
                    <div class="row">
                        <p>Для подтверждения нажмите "Отправить СМС" и введите код из СМС</p>
                    </div>
                    <div class="row" id="pd-status">
                    </div>

                    <div class="row d-flex justify-content-around">
                        <div class="col-auto my-1">
                            <button type="button" class="btn btn-teal pd-send-sms">ОТПРАВИТЬ СМС</button>
                        </div>
                       <div class="col-auto my-1">
                           <button type="button" class="btn btn-secondary pd-decline">НЕ ПРИНИМАЮ</button>
                       </div>
                        <div class="col-auto my-1">
                            <div class="input-group">
                                <input type="text" class="form-control" id="pd-sms-code" placeholder="код из СМС">
                                <span class="input-group-append">
                                <button type="button" class="btn btn-primary pd-accept">ПОДТВЕРДИТЬ</button>
                                </span>
                            </div>
                        </div>
                    </div>
                   </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('custom-scripts')
    <script>
        function fillFields()
        {
            $('#get-shareholer-info').on('click', function () {
                $.ajax({
                    method: "GET",
                    url: "{{route('client.infoForLoanRequest')}}"
                })
                .done(function(data) {
                    $.each(data, function(key, value) {
                        fillInput(key, value);
                    });
                });
            });
        }

        function fillInput(key, value)
        {
            let field = $('#fields #' + key);
            if (field.attr('type') === 'date')
            {
                let dateFormated = value.split('.')[2] + "-" +  value.split('.')[1] + "-" + value.split('.')[0];
                value = dateFormated;
                field.val(value);
            }
            else if (field.attr('type') === 'checkbox') {
                field.prop('checked', value);
            }
            else if (field.hasClass('masked-phone'))
            {
                field.val(value);
                field.mask("+7 (000) 000-0000");
            }
            else
            {
                field.val(value);
            }
        }

        function sendSMS()
        {
            $('#pd-status').empty();
            $.ajax({
                method: "POST",
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                url: "{{route('client.requests.sendSMS')}}"
            })
                .done(function(data) {
                   if (data['success'] === true)
                   {
                       $('#pd-status').append('<p class="alert alert-success w-100"> '+data["msg"]+'</p>');
                   }
                   else if (data['success'] === false)
                   {
                       $('#pd-status').append('<p class="alert alert-danger w-100">'+data["msg"]+'</p>');
                   }

                   if(data['success'] === null)
                   {
                       $('#pd-status').append('<p class="alert alert-danger w-100"> Ошибка при отправке</p>');
                   }
                })
                .fail(function()
                {
                    $('#pd-status').append('<p class="alert alert-danger w-100"> Ошибка при отправке</p>');
                });
        }

        function veryfySMS(sms_code)
        {
            $('#pd-status').empty();
            $.ajax({
                method: "POST",
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                url: "{{route('client.requests.verifySMS')}}",
                data: { code:  $('#pd-sms-code').val(),},
            })
                .done(function(data) {
                    if (data['success'] === true)
                    {
                        $('#pd-status').append('<p class="alert alert-success w-100"> '+data["msg"]+'</p>');
                        $('#personal_data_accept').prop( 'checked', true );
                        $('#personalDataModal').modal('hide');
                        $('#sms_code').val($('#pd-sms-code').val());
                    }
                    else if (data['success'] === false)
                    {
                        $('#pd-status').append('<p class="alert alert-danger w-100">'+data["msg"]+'</p>');
                    }

                    if(data['success'] === null)
                    {
                        $('#pd-status').append('<p class="alert alert-danger w-100"> Ошибка при проверке</p>');
                    }
                })
                .fail(function()
                {
                   $('#pd-status').append('<p class="alert alert-danger w-100"> Ошибка при проверке</p>');
                });
        }

        $(document).ready(function() {
            $('#personal_data_accept').on('click', function () {
                if ($('#request-form')[0].checkValidity() === false)
                {
                    $('#submit-btn').click();
                }
                else
                {
                    $('#personalDataModal').modal('show');
                }

                $(this).prop( 'checked', false );
            });

            $('.pd-accept').on('click', function () {
                veryfySMS($('#pd-sms-code'));
            });

            $('.pd-send-sms').on('click', function () {
                sendSMS();
            });

            $('.pd-decline').on('click', function () {
                $('#personal_data_accept').prop( 'checked', false );
                $('#personalDataModal').modal('hide');
            });

            fillFields();

            $('.upload-file').on('change', function(evt) {
                if (this.files[0] != null)
                {
                    let dangerDivID = $(this).attr('id') + '-danger';
                    let visibleInput =  $(this).parent().children('.input-group').children('input[type=text]');
                    let fileSizeMB = this.files[0].size/1024/1024;
                    if (fileSizeMB > 3)
                    {
                        $(this).parent().append('<div class="text-danger text-center" id="' + dangerDivID + '"> Файл превышает 3 МБ! </div>');
                        $(this).val('');
                        visibleInput.addClass('border-danger');
                        visibleInput.val('');
                    }
                    else
                    {
                        visibleInput.removeClass('border-danger');
                        if ($('#' + dangerDivID).length)
                        {
                            $('#' + dangerDivID).remove();
                        }
                    }
                }

            });
        } );
    </script>
@endsection
