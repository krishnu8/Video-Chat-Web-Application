<?php
session_start();
include_once 'Database/Create_database.php';
$randomCode = rand(1000, 9999);

date_default_timezone_set('Asia/Kolkata');
$current_time_india = date('Y-m-d H:i:s');

if (isset($_SESSION['Join_session'])) {
    $pin = $_SESSION['Join_session'];
}

if (isset($_SESSION['Create_session'])) {
    $pin = $_SESSION['Create_session'];
}

if (isset($_COOKIE['username'])) {
    $username = $_COOKIE['username'];
    $update_status = " UPDATE `user` SET `update_time` = '$current_time_india' WHERE `Name` = '$username'";
    mysqli_query($con, $update_status);
} else {
    header('Location: index.php');
    exit();
}

$check_status = 'SELECT * FROM `user`';
$result = mysqli_query($con, $check_status);

if ($result) {
    $count = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $update_time = $row['update_time'];
        $update_time_2min = date('Y-m-d H:i:s', strtotime($update_time . ' + 2 minutes'));

        if ($update_time_2min >= $current_time_india) {
            $count++;
        }
    }
} else {
    echo 'Error: ' . mysqli_error($con);
}

?>
<html>

<head>
    <title>Find Yourself</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Your CSS styles and other head content -->
    <script src="https://unpkg.com/peerjs@1.3.1/dist/peerjs.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        body {
            /* background-image: url('Image/lonly.jpg');
            background-size: cover; */
        }

        .col-sm-12::-webkit-scrollbar {
            width: 0;
            /* Hide scrollbar width */
            height: 0;
            /* Hide scrollbar height */
        }

        /* Hide scrollbar for Firefox */
        .col-sm-12 {
            scrollbar-width: none;
            /* Hide scrollbar for Firefox */
        }

        .bottom-right {
            position: relative;
        }

        .bottom-right .btn {
            position: absolute;
            bottom: 0;
            right: 0;
            margin-bottom: 10px;
            /* Optional: Add some margin */
            margin-right: 10px;
            /* Optional: Add some margin */
        }

        .bottom-left {
            position: relative;
        }

        .bottom-left img {
            position: absolute;
            right: 0;
            top: 0;
        }

        .active-user-text {
            font-size: 18px;
            font-weight: 500;
            color: #333;
            margin-bottom: 0;
            /* Remove default bottom margin */
        }

        .active-status {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: #28a745;
            /* Green color for active status */
            margin-left: 5px;
            /* Adjust spacing */
            display: inline-block;
            vertical-align: middle;
        }

        video#remote-video {
            height: 100%;
            width: 100%;
        }

        video#local-video {
            height: 100%;
            width: 100%;
        }

        @media only screen and (max-width: 900px) {
            .bot {
                height: 100px;
                width: 100px;
                font-size: 40px;
            }
        }
    </style>
</head>
<script>
    $(document).ready(function() {

        function sendMessage() {
            var message = $('#messageInput').val();
            var pin = <?php echo json_encode($pin); ?>; // Assuming $pin is a PHP variable

            $.ajax({
                url: 'text_message.php',
                type: 'POST',
                data: {
                    message: message,
                    pin: pin
                },
                success: function(response) {
                    // Handle success
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
            console.log("Message sent: " + message);
            $('#messageInput').val("");
        }

        $('#messageInput').keypress(function(event) {
            if (event.keyCode === 13) { // Check if Enter key is pressed
                $('#sendButton').click(); // Trigger click event of send button
            }
        });

        $('#sendButton').click(function() {
            sendMessage(); // Call the sendMessage function
        });
    });


    // fetch message from database 

    $(document).ready(function() {
        var pin = <?php echo json_encode($pin); ?>;

        // Function to fetch messages from the server
        function fetchMessages(pin) {
            $.ajax({
                url: 'fetch_message.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    pin: pin
                }, // Send pin with the request
                success: function(messages) {
                    // Handle success
                    console.log(messages); // Output the fetched messages to console
                    displayMessages(messages);
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        }

        // Function to display messages
        function displayMessages(messages) {
            var messageContainer = $('#messageContainer');
            messageContainer.empty(); // Clear previous messages
            var username = "<?php echo $_COOKIE['username']; ?>";
            // Iterate through the messages and append them to the message container
            $.each(messages, function(index, message) {
                var messageHtml = '';
                if (message.Sender === username) {
                    messageHtml += '<div class="d-flex flex-row justify-content-end mb-4 pt-1">';
                    messageHtml += '<div>';
                    messageHtml += '<p class="small p-2 me-3 mb-1 text-white rounded-3 bg-info">' +
                        message.Message + '</p>';
                    messageHtml += '</div>';
                    messageHtml += '</div>';
                } else {
                    messageHtml += '<div class="d-flex flex-row justify-content-start mb-4 pt-1">';
                    messageHtml += '<div>';
                    messageHtml +=
                        '<p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">' +
                        message.Message + '</p>';
                    messageHtml += '</div>';
                    messageHtml += '</div>';
                }

                messageContainer.append(messageHtml);
            });

        }

        // Call the fetchMessages function initially when the page loads
        fetchMessages(pin);

        // Call the fetchMessages function every second
        setInterval(function() {
            fetchMessages(pin);
        }, 1000); // 1000 milliseconds = 1 second
    });
</script>

<body>
    <p id="notification" style="z-index: 100; position: absolute; margin-top: 200px; width: 30%; text-align: center"
        hidden></p>
    <div class="entry-modal" id="entry-modal" style="display: none">
        <p>Create or Join Meeting</p>
        <input id="room-input" class="room-input" placeholder="Enter Room ID" value="<?php echo isset($pin) ? $pin : ''; ?>">
        <div>
            <button onclick="createRoom()">Create Room</button>
            <button onclick="joinRoom()">Join Room</button>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-10 col-lg-10"><img src="Image/hey.png" alt="logo" height="60px"></div>
            <div class="col-sm-2 d-flex align-items-center justify-content-center">
                <p class="active-user-text">Active user</p>
                <div class="active-status"></div>
                <span class="ms-1"><?php echo $count; ?></span> <!-- Additional text with margin -->
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12 col-lg-4">
                <div class="row">
                    <div class="col-sm-12 col-lg-12" style="height:45vh; background-color: beige;">
                        <div class="bottom-left">
                            <img src="Image/hey.png" alt="jack" height="70px" style="opacity: 0.5;">
                        </div>
                        <img src="Image/waiting.gif" alt="Waiting" style= "height:100%;width: 100%;" hidden
                            id="image_waiting">

                        <video id="remote-video"></video>
                    </div>
                    <div class="col-sm-12 col-lg-12 mt-2 bottom-right" style="height:45vh; background-color: yellow;">
                        <video id="local-video" style="height: 100%;"></video>

                        <form method="post" action="start.php">
                            <button type="submit" class="btn btn-warning bot" id="stop"
                                name="Stop">Stop</button>
                            <button type="submit" class="btn btn-primary bot" id="start" name="Start"
                                id="start">Start</button>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-8">

                <div class="row">

                    <div class="col-sm-12 col-lg-12" style="height:645px; overflow-y: scroll;" id="messageContainer">
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="text-muted d-flex justify-content-start align-items-center mt-3">
                            <div class="input-group">
                                <input type="text" id="messageInput" class="form-control rounded"
                                    placeholder="Type Your Message" />
                                <button type="button" id="sendButton" class="btn btn-outline-primary">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        const PRE = "DELTA"
        const SUF = "MEET"
        var room_id;
        var getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
        var local_stream;
        var screenStream;
        var peer = null;
        var currentPeer = null
        var screenSharing = false

        function createRoom() {
            console.log("Creating Room");
            let room = document.getElementById("room-input").value.trim(); // Trim any leading/trailing spaces
            if (room === "") {
                alert("Please enter a room number");
                return;
            }
            room_id = PRE + room + SUF;

            peer = new Peer(room_id);

            peer.on('open', (id) => {
                console.log("Peer Connected with ID: ", id);
                hideModal();
                getUserMedia({
                    video: true,
                    audio: true
                }, (stream) => {
                    local_stream = stream;
                    setLocalStream(local_stream);
                    waiting.hidden = true
                }, (err) => {
                    console.error("Error accessing media devices:", err);
                    // Handle error (e.g., show error message to user)
                });
                notify("Waiting for Other User to Join.");
                // alert('Waiting for Other User to Join');
                var startButton = document.getElementById("start");
                startButton.style.display = "none";

            });

            peer.on('call', (call) => {
                console.log("Incoming call detected");
                call.answer(local_stream);
                call.on('stream', (stream) => {
                    setRemoteStream(stream);
                });
                currentPeer = call;
            });

            peer.on('error', (err) => {
                console.error("PeerJS Error:", err);
                // Handle PeerJS errors (e.g., show error message to user)
            });
        }


        function setLocalStream(stream) {

            let video = document.getElementById("local-video");
            video.srcObject = stream;
            video.muted = true;
            video.play();
        }

        function setRemoteStream(stream) {
            let video = document.getElementById("remote-video");
            video.srcObject = stream;
            video.play();
        }

        function hideModal() {
            document.getElementById("entry-modal").hidden = true
        }

        function notify(msg) {
            let notification = document.getElementById("notification")
            notification.innerHTML = msg
            notification.hidden = false
            let waiting = document.getElementById("image_waiting");
            waiting.hidden = false
            setTimeout(() => {
                notification.hidden = true;
                waiting.hidden = true;
            }, 2000)
        }

        function joinRoom() {
            console.log("Joining Room")
            let room = document.getElementById("room-input").value;
            if (room == " " || room == "") {
                alert("Please enter room number")
                return;
            }
            room_id = PRE + room + SUF;
            hideModal()
            peer = new Peer()
            peer.on('open', (id) => {
                console.log("Connected with Id: " + id)
                getUserMedia({
                    video: true,
                    audio: true
                }, (stream) => {
                    local_stream = stream;
                    setLocalStream(local_stream)
                    notify("Connecting.........")
                    let call = peer.call(room_id, stream)
                    var startButton = document.getElementById("start");
                    startButton.style.display = "none";
                    call.on('stream', (stream) => {
                        setRemoteStream(stream);
                    })
                    currentPeer = call;
                }, (err) => {
                    console.log(err)
                })

            })
        }

        function exitCall() {
            if (currentPeer) {
                currentPeer.close(); // Close the current peer connection
            }
            if (local_stream) {
                local_stream.getTracks().forEach(function(track) {
                    track.stop(); // Stop all tracks in the local stream
                });
            }
            if (screenStream && screenSharing) {
                stopScreenSharing(); // Stop screen sharing if active
            }
            clearVideoElementsAndShowModal(); // Clear video elements and show entry modal
            // Inform remote peer that the call is ending
            if (currentPeer) {
                currentPeer.send({
                    type: 'call_ended'
                });
            }
        }

        // Function to handle call closing and cleanup on the remote side
        peer.on('data', (data) => {
            if (data.type === 'call_ended') {
                clearVideoElementsAndShowModal(); // Clear video elements and show entry modal
            }
        });

        function clearVideoElementsAndShowModal() {
            document.getElementById("local-video").srcObject = null; // Clear local video
            document.getElementById("remote-video").srcObject = null; // Clear remote video
            document.getElementById("entry-modal").hidden = false; // Show entry modal again
        }
    </script>


    <?php
    if (isset($_SESSION['Join_session'])) {
        echo '<script>joinRoom();</script>';
    }
    
    if (isset($_SESSION['Create_session'])) {
        echo '<script>createRoom();</script>';
    }
    session_destroy();
    ?>
</body>

</html>
