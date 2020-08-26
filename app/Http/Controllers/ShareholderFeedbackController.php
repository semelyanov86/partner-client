<?php

namespace App\Http\Controllers;

use App\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ShareholderFeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:shareholder');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $places = Place::whereNull('deleted_at')->orderBy('name')->get();

        return view('shareholder.feedback')->with('places', $places);
    }

    protected function validator(array $data)
    {
        $messages = [
            'image-upload.image' => 'Файл должен быть изображением',
            'image-upload.mimes' => 'Допустимы только следующие форматы: jpeg, png, jpg, gif',
            'image-upload.max' => 'Максимальный размер файла 3 Мб',
            'comment.required' => 'Текст комментария не заполнен',
            'place.required' => 'Не выбран населенный пункт',
        ];

        return Validator::make($data, [
            'image-upload' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:3072'],
            'comment' => ['required'],
            'place' => ['required'],
        ], $messages);
    }

    public function send(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('phone', 'comment', 'place', 'email'));
        }

        $place = Place::find($request->input('place'));
        $data = ['phone' => $request->input('phone'),
            'comment' => $request->input('comment'),
            'place' => $place->name,
            'email' => $request->input('email'),
            ];

        try {
            Mail::send('shareholder.mail.feedback', $data, function ($message) use ($request) {
                $message->from(env('MAIL_FROM_ADDRESS', 'app@mail.com'), 'Client portal');

                if ($request['image-upload']) {
                    $message->attach($request['image-upload']->getRealPath(), [
                            'as' => 'image-upload.'.$request['image-upload']->getClientOriginalExtension(),
                            'mime' => $request['image-upload']->getMimeType(), ]
                    );
                }

                $message->to(env('FEEDBACK_MAIL', 'admin@admin.ru'))->subject('Обратная связь');
            });
        } catch (\Exception $exception) {
            return redirect()->back()
                ->withErrors(['error_msg' => 'Не удалось отправить сообщение! Попробуйте позднее!'])
                ->withInput($request->only('phone', 'comment', 'place', 'email'));
        }

        return redirect()->route('client.thanks')->withMessage('Спасибо за ваш отзыв!');
    }
}
