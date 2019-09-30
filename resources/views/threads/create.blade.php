@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="columns is-centered">
            <div class="column">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Create a New Thread
                        </p>
                    </header>
                    <div class="card-content">
                        <form action="/threads" method="POST">
                            @csrf
                            <div class="field">
                                <label class="label" for="channel_id">Choose a Channel</label>
                                <div class="control">
                                    <div class="select">
                                        <select id="channel_id" name="channel_id" required>
                                            <option value="">Choose one ...</option>
                                            @foreach ($channels as $channel)
                                                <option
                                                    value="{{$channel->id}}" {{old('channel_id')==$channel->id?'selected':''}}>{{$channel->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <label class="label" for="title">Title</label>
                                    <input id="title" name="title" class="input" value="{{old('title')}}" required/>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <label class="label" for="body">Body</label>
                                    <wysiwyg name="body"></wysiwyg>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <button type="submit" class="button is-link">Submit</button>
                                    <div class="g-recaptcha"
                                         data-sitekey="6LeaNqcUAAAAAMdZa08Dx8aOPS7J-LtuayiNrFZ-"></div>
                                </div>
                            </div>
                            @include('layouts.errors')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
