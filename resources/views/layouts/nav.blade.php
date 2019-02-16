<navigation-bar inline-template v-cloak>
    <div class="container">
        <div class="navbar-brand">
            <a class="navbar-item" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <a @click="toggle" role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
               :class="{ 'is-active': show }" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <div class="navbar-menu" :class="{ 'is-active': show }">
            <div class="navbar-start">
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        Browse
                    </a>
                    <div class="navbar-dropdown">
                        <a href="/threads" class="navbar-item">
                            All Threads
                        </a>
                        <a href="/threads?popular=1"
                           class="navbar-item">
                            Popular All Time
                        </a>
                        <a href="/threads?unanswered=1"
                           class="navbar-item">
                            Unanswered Threads
                        </a>
                        @auth
                            <a href="/threads?by={{\Illuminate\Support\Facades\Auth::user()->name}}"
                               class="navbar-item">
                                My threads
                            </a>
                        @endauth
                    </div>
                </div>
                <a href="/threads/create" class="navbar-item">
                    New Thread
                </a>
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        Channels
                    </a>
                    <div class="navbar-dropdown">
                        @foreach($channels as $channel)
                            <a href="/threads/{{$channel->slug}}" class="navbar-item">
                                {{$channel->name}}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="navbar-end">
                @guest
                    <div class="navbar-item">
                        <div class="buttons">
                            <a class="button is-primary" href="{{ route('register') }}">
                                <strong>Sign up</strong>
                            </a>
                            <a class="button is-light" href="{{ route('login') }}">Log in</a>
                        </div>
                    </div>
                @else
                    <user-notifications></user-notifications>
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="navbar-dropdown">
                            <a class="navbar-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                Log out
                            </a>
                            <a class="navbar-item" href="/profiles/{{ Auth::user()->name }}" >
                                My Profile
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</navigation-bar>
