@extends('user::admin.index')

@section('title')
    @lang('user::user.title')
@stop

@section('content')
    <section class="content-header">
        <h1>
            @lang('user::user.title')
        </h1>
    </section>

    <section id="user" class="content">
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>@lang('user::user.id')</td>
                        <td>@lang('user::profile.field.name')</td>
                        <td>@lang('user::profile.field.alias')</td>
                        <td>@lang('user::profile.field.email')</td>
                        <td>@lang('user::profile.field.gender')</td>
                        <td>@lang('user::profile.field.locale')</td>
                        <td>@lang('user::user.created_at')</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->alias }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->gender }}</td>
                            <td>{{ config(sprintf('app.locales.%s', $user->locale)) }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                                <a class="btn-sm btn-default" href="{{ route('user.admin.users.edit', ['id' => $user->id]) }}"><i class="fa fa-edit"></i></a>
                                <a class="btn-sm btn-danger js-delete" href="{{ route('user.admin.users.delete', ['id' => $user->id]) }}"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                {!! $users->render(new Vain\Presenters\AdminLtePresenter($users)) !!}
            </div>
        </div>
    </section>
    @include('user::admin.users.modal')
@endsection