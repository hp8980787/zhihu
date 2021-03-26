<div class="col-md-4">
    <ul class="messages-notifications list-group-item">
        <li class="list-group-item @if(Request::route()->getName()=='messages') active  @endif ">
            <a
               href="{{ route('messages') }}">私信 ({{ $messagesCount }})</a>
        </li>
        <li class="list-group-item @if(Request::route()->getName()=='notifications') active  @endif">
            <a href="{{ route('notifications') }}">通知({{ sizeof($user->unreadNotifications) }})</a>
        </li>
    </ul>
</div>
