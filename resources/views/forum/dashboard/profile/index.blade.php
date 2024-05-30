@extends('layout.base', ['navigation' => false])

@section('title', 'Profile')

@section('content')
    <div class="posts">
        <div class="posts__body">
            <div class="row my-4">
                <div class="card">
                    @include('forum.layout.tabs')
                    <div class="col-12">
                        <div class="row mb-5">
                            <div class="col-lg-4">
                                <div class="base-card">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="{{ $user->avatar ?? asset('bootstrap-forum/fonts/icons/avatars/A.svg') }}"
                                            alt="Admin" class="rounded-circle" width="110">
                                        <div class="mt-3">
                                            <h4>{{ $user->getFilamentName() }}</h4>
                                            <p class="text-secondary mb-1">{{ $user->getRelatedUserLastPost() }}</p>
                                            <p class="text-muted font-size-sm">{{ $user->getUserJoinedAt() }}</p>

                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <div>Threads -
                                                <span>{{ $user->getRelatedUserThreads()->count() }}</span>
                                            </div>
                                            <div>Posts -
                                                <span>{{ $user->getRelatedUserPosts()->count() }}</span></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <form action="{{ route('forum.profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="base-card">
                                        <x-error-box :resources="'User Profile'" />
                                        <div class="row mb-3 mx-1">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="first_name">First Name</label>
                                                    <input type="text" id="first_name" class="form-control" name="first_name" value="{{ old('first_name', $user->first_name) }}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="last_name">Last Name</label>
                                                    <input type="text" id="last_name" class="form-control" name="last_name" value="{{ old('last_name', $user->last_name) }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3 mx-1">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="email">Email Address</label>
                                                    <input type="email" id="email" class="form-control" name="email" value="{{ old('email', $user->email) }}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="new_password">New Password</label>
                                                    <input type="text" id="new_password" class="form-control" name="new_password">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mx-1">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="email">Change Avatar</label>
                                                    <input type="file" class="form-control" name="avatar">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-3 p-0 m-3 float-end">
                                            <a href="" class="primary-btn btn btn--type-03">Cancel</a>
                                            <button type="submit" class="primary-btn btn btn--type-02">Update Profile</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
