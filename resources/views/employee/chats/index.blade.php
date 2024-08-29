@extends('layouts.employee')
@section('title', 'Chats')
@section('content')
<h5 class="page-title">Chats</h5>
    @forelse($chats as $chat)
         @if(isset($chat->recentmessage))
        <div class="card chat-card">
            <a href="{{ route('employee.chats.show', $chat->id) }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="inbox-widget">
                                <div class="inbox-item">
                                    @if ($chat->employer->thumbnail)
                                        <div class="inbox-item-img">
                                            <img src="{{ asset('storage/uploads/employers/' . $chat->employer->slug . '/' . $chat->employer->avatar . '') }}"
                                                class="rounded-circle"
                                                alt="{{ $chat->employer->company_name ?? '' }}">
                                        </div>
                                    @else
                                        <div class="inbox-item-img">
                                            <img src="{{ asset('assets/images/users/avatar-2.jpg') }}"
                                                class="rounded-circle" alt="{{  $chat->employer->company_name ?? '' }}">
                                        </div>
                                    @endif

                                    <h4 class="inbox-item-author">
                                        {{  $chat->employer->company_name ?? '' }}
                                    </h4>

                                    <p class="inbox-item-text">{!! Str::limit($chat->job->position_name, 42, ' ...') !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5 inbox-widget">
                            <p class="text-muted inbox-item">
                                <small>{{ isset($chat->recentmessage) ? $chat->recentmessage->message : '' }}</small></p>
                        </div>
                        <div class="col-sm-2 inbox-widget">
                            <p class="text-muted float-end inbox-item"><small>
                                    {{ isset($chat->recentmessage) ? $chat->recentmessage->created_at->diffForHumans() : '' }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endif
    @empty
        <p class="text-center py-5">
            No Chats found.
        </p>
    @endforelse
@endsection
