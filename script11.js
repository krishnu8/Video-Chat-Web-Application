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
        getUserMedia({ video: true, audio: true }, (stream) => {
            local_stream = stream;
            setLocalStream(local_stream);
        }, (err) => {
            console.error("Error accessing media devices:", err);
            // Handle error (e.g., show error message to user)
        });
        notify("Waiting for peer to join.");
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
    setTimeout(() => {
        notification.hidden = true;
    }, 3000)
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
        getUserMedia({ video: true, audio: true }, (stream) => {
            local_stream = stream;
            setLocalStream(local_stream)
            notify("Joining peer")
            let call = peer.call(room_id, stream)
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
        local_stream.getTracks().forEach(function (track) {
            track.stop(); // Stop all tracks in the local stream
        });
    }
    if (screenStream && screenSharing) {
        stopScreenSharing(); // Stop screen sharing if active
    }
    clearVideoElementsAndShowModal(); // Clear video elements and show entry modal
    // Inform remote peer that the call is ending
    if (currentPeer) {
        currentPeer.send({ type: 'call_ended' });
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
