<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Post;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PostsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Post::query()->select(sprintf('%s.*', (new Post)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'post_show';
                $editGate = 'post_edit';
                $deleteGate = 'post_delete';
                $crudRoutePart = 'posts';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('active', function ($row) {
                return '<input type="checkbox" disabled '.($row->active ? 'checked' : null).'>';
            });

            $table->rawColumns(['actions', 'placeholder', 'active']);

            return $table->make(true);
        }

        return view('admin.posts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('post_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $post->id]);
        }

        return redirect()->route('admin.posts.index');
    }

    public function edit(Post $post)
    {
        abort_if(Gate::denies('post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->all());

        return redirect()->route('admin.posts.index');
    }

    public function show(Post $post)
    {
        abort_if(Gate::denies('post_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        abort_if(Gate::denies('post_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $post->delete();

        return back();
    }

    public function massDestroy(MassDestroyPostRequest $request)
    {
        Post::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('post_create') && Gate::denies('post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Post();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
