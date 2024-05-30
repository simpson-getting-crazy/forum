@extends('layout.base', ['navigation' => false])

@section('title', 'Setting')

@section('content')
    <div class="posts">
        <div class="posts__body">
            <div class="row my-4">
                <div class="card">
                    @include('forum.layout.tabs')
                    <div class="col-12">
                        <form action="{{ route('forum.setting.update') }}" method="POST">
                            @csrf
                            <div class="base-card mb-5">
                                <x-error-box :resources="'Setting'" />
                                <div class="row mx-1">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <h5>Locale Setting</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mx-1">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="email">Change Language</label>
                                            <select name="lang" class="form-control">
                                                <option value="en" @selected(session()->get('lang') == 'en')>English</option>
                                                <option value="id" @selected(session()->get('lang') == 'id')>Indonesian</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-3 p-0 m-3 float-end">
                                    <a href="" class="primary-btn btn btn--type-03">Cancel</a>
                                    <button type="submit" class="primary-btn btn btn--type-02">Update Setting</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
