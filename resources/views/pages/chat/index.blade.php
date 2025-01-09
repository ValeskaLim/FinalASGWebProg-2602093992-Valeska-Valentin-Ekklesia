@extends('layout.master')

@section('content')
    <style>
        .list-group-item.active {
            background-color: rgba(221, 227, 233, 0.3);
        }

        #chat_area {
            border: 1px solid #ccc;
            border-radius: 8px;
            height: 400px;
            overflow-y: auto;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .chat-message {
            display: flex;
            align-items: flex-end;
            margin-bottom: 10px;
        }

        .chat-message img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .chat-message-content {
            max-width: 70%;
            padding: 10px;
            border-radius: 8px;
            font-size: 14px;
            word-wrap: break-word;
        }

        .chat-message.you .chat-message-content {
            background-color: #d1e7dd;
            margin-left: auto;
            text-align: right;
        }

        .chat-message.friend .chat-message-content {
            background-color: #f8d7da;
            margin-right: auto;
            text-align: left;
        }

        #chat_input {
            border-radius: 0;
        }

        .input-group .btn-primary {
            border-radius: 0;
        }
    </style>

    <div class="container mt-4">
        <div style="border: 2px solid black;border-radius: 5px;width:fit-content">
            <a href="{{ route('home') }}" class="p-2 d-flex align-items-center text-decoration-none"
                style="color:black;width:100%">
                <img src="{{ asset('assets/back.png') }}" alt="Arrow" width="15" height="15">
                <p class="m-0 ps-2">@lang('messages.back')</p>
            </a>
        </div>
        <h1 class="mb-5">@lang('messages.chat_header')</h1>
        <div class="row">
            <!-- Friends List -->
            <div class="col-md-4">
                <h3>@lang('messages.friend_header_home')</h3>
                <ul class="list-group">
                    @foreach ($friends as $friend)
                        <li id="friend_{{ $friend->id }}" class="list-group-item d-flex align-items-center">
                            <img src="{{ $friend->profile_picture }}" alt="{{ $friend->username }}" class="rounded-circle"
                                width="40" height="40">
                            <a href="#" onclick="loadChat({{ $friend->id }})" class="ms-2 text-decoration-none"
                                style="color:black">{{ $friend->username }}</a>
                            <!-- Display unread badge -->
                            @if ($friend->unread_count > 0)
                                <span id="unread_{{ $friend->id }}"
                                    class="badge bg-danger ms-auto">{{ $friend->unread_count }}</span>
                            @else
                                <span id="unread_{{ $friend->id }}" class="badge bg-danger ms-auto"
                                    style="display: none;">0</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Chat Area -->
            <div class="col-md-8">
                <h3>Chat</h3>
                <div id="chat_area">
                    <!-- Chat messages will appear here -->
                </div>
                <form id="chat_form" class="mt-3" onsubmit="sendMessage(); return false;">
                    <div class="input-group">
                        <input type="text" id="chat_input" class="form-control" placeholder="@lang('messages.input_chat_placeholder')"
                            style="border-top-left-radius: 5px;border-bottom-left-radius: 5px">
                        <button type="button" class="btn btn-primary" onclick="sendMessage()"
                            style="border-top-right-radius: 5px;border-bottom-right-radius: 5px">@lang('messages.send_chat_button')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentFriendId = null;

        // Load chat messages for a specific friend
        function loadChat(friendId) {
            currentFriendId = friendId;

            // Highlight the selected user in the friends list
            document.querySelectorAll('.list-group-item').forEach(item => item.classList.remove('active'));
            document.getElementById('friend_' + friendId).classList.add('active');

            // Fetch messages for this friend
            axios.get(`/chat/fetch/${friendId}`)
                .then(response => {
                    const messages = response.data.messages;
                    const chatArea = document.getElementById('chat_area');
                    chatArea.innerHTML = '';

                    // Populate messages
                    messages.forEach(message => {
                        const messageElement = document.createElement('div');
                        messageElement.classList.add('chat-message');
                        const messageContent = document.createElement('div');
                        messageContent.classList.add('chat-message-content');

                        const profilePicture = document.createElement('img');
                        if (message.sender_id === {{ Auth::id() }}) {
                            // User's message (right-aligned)
                            messageElement.classList.add('you');
                            profilePicture.src =
                                "https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->username) }}&background=random";
                            profilePicture.alt = "{{ Auth::user()->username }}";
                            messageContent.textContent = message.content;
                            messageElement.appendChild(messageContent);
                            messageElement.appendChild(profilePicture);
                        } else {
                            // Friend's message (left-aligned)
                            const friend = @json($friends->keyBy('id'));
                            const sender = friend[message.sender_id];

                            profilePicture.src = "https://ui-avatars.com/api/?name=" + encodeURIComponent(sender
                                .username) + "&background=random";
                            profilePicture.alt = sender.username;
                            messageContent.textContent = message.content;
                            messageElement.classList.add('friend');
                            messageElement.appendChild(profilePicture);
                            messageElement.appendChild(messageContent);
                        }

                        chatArea.appendChild(messageElement);
                    });

                    // Clear unread badge
                    const unreadBadge = document.getElementById('unread_' + friendId);
                    if (unreadBadge) {
                        unreadBadge.style.display = 'none';
                    }

                    chatArea.scrollTop = chatArea.scrollHeight;
                })
                .catch(error => {
                    console.error('Error loading chat:', error);
                });
        }


        // Send a message
        function sendMessage() {
            const content = document.getElementById('chat_input').value.trim();

            if (currentFriendId && content !== '') {
                axios.post(`/chat/send/${currentFriendId}`, {
                        content
                    })
                    .then(response => {
                        const message = response.data.message;

                        const chatArea = document.getElementById('chat_area');
                        const messageElement = document.createElement('div');
                        messageElement.classList.add('chat-message', 'you');

                        const messageContent = document.createElement('div');
                        messageContent.classList.add('chat-message-content');
                        messageContent.textContent = message.content;

                        const profilePicture = document.createElement('img');
                        profilePicture.src =
                            "https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->username) }}&background=random";
                        profilePicture.alt = "{{ Auth::user()->username }}";

                        messageElement.appendChild(messageContent);
                        messageElement.appendChild(profilePicture);
                        chatArea.appendChild(messageElement);

                        document.getElementById('chat_input').value = '';

                        chatArea.scrollTop = chatArea.scrollHeight;
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                    });
            } else {
                alert('Please select a user to chat with and type a message.');
            }
        }
    </script>
@endsection
