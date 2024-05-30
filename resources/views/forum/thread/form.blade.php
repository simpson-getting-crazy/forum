@extends('layout.base', ['navigation' => false])

@section('title', 'Thread')

@section('content')
    <main>
        <div class="container">
            <form action="{{ route('forum.thread.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="create">
                    <div class="create__head">
                        <div class="create__title"><img src="{{ asset('bootstrap-forum/fonts/icons/main/New_Topic.svg') }}" alt="New topic">Create New Thread
                        </div>
                        <span>Forum Guidelines</span>
                    </div>
                    <div class="create__section">
                        <label class="create__label" for="title">Thread Title</label>
                        <input type="text" class="form-control" id="title" placeholder="Title" name="title" value="{{ old('title') }}">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="create__section">
                                <label class="create__label" for="category">Select Category</label>
                                <label class="custom-select">
                                    <select name="category_id" id="category">
                                        <option>Choose</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ Str::title($category->name) }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="create__section create__textarea">
                        <label class="create__label" for="description">Description</label>
                        <textarea rows="5" class="form-control summernotes" name="description">{{ old('description') }}</textarea>
                    </div>
                    <div class="create__advanced">
                        <div class="row">
                            <div class="col-lg-4 col-xl-4">
                                <div class="create__section">
                                    <label class="create__label">Who can see this?</label>
                                    <div class="create__radio">
                                        <label class="create__box">
                                            <label class="custom-radio">
                                                <input type="radio" name="visibility" value="all" @checked(old('visibility') == 'all')>
                                                <i></i>
                                            </label>
                                            <span>Everyone</span>
                                        </label>
                                        <label class="create__box">
                                            <label class="custom-radio">
                                                <input type="radio" name="visibility" value="friends" @checked(old('visibility') == 'friends')>
                                                <i></i>
                                            </label>
                                            <span>Only Friends</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="create__footer">
                        <a href="#" class="create__btn-cansel btn">Cancel</a>
                        <button type="submit" class="create__btn-create btn btn--type-02">Create Thread</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection
