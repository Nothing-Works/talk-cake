@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-half">
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
                                <div class="control">
                                    <label for="title">Title</label>
                                    <input id="title" name="title" class="input"/>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <label for="body">Body</label>
                                    <textarea id="body" name="body" class="textarea"
                                              placeholder="what is in your mind"></textarea>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <button type="submit" class="button is-link">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection