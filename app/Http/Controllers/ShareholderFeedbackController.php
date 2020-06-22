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
        $messages = array(
            'image-upload.image' => 'Файл должен быть изображением',
            'image-upload.mimes' => 'Допустимы только следующие форматы: jpeg, png, jpg, gif',
            'image-upload.max' => 'Максимальный размер файла 3 Мб',
            'comment.required' => 'Текст комментария не заполнен',
            'place.required' => 'Не выбран населенный пункт',
        );
        return Validator::make($data, [
            'image-upload' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:3072'],
            'comment' => ['required'],
            'place' => ['required'],
        ], $messages);
    }

    public function send(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails())
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('phone', 'comment', 'place', 'email'));
        }

        $place = Place::find($request->input('place'));
        $data = array('phone' => $request->input('phone'),
            'comment' => $request->input('comment'),
            'place' => $place->name,
            'email' => $request->input('email'),
            );

        Mail::send('shareholder.mail.feedback', $data, function ($message) use ($request) {
            $message->from(env('MAIL_FROM_ADDRESS', 'app@mail.com'), 'Client portal');

            if ($request['image-upload'])
            {
                $message->attach($request['image-upload']->getRealPath(), array(
                        'as' => 'image-upload.' . $request['image-upload']->getClientOriginalExtension(),
                        'mime' => $request['image-upload']->getMimeType())
                );
            }

            $message->to('morhant_91@mail.ru')->subject('Обратная связь');

        });

        return redirect()->route('client.thanks')->withMessage('Спасибо за ваш отзыв!');
    }
}
