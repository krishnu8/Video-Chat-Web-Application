<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hey</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        < />

        <
        script src = "https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity = "sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin = "anonymous" >
            <
            /> <
        script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity = "sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin = "anonymous" >
    </script>
    <!-- Custom CSS -->
    <style>
        /* Custom styles */
        .hero-section {
            background-image: url('Image/wallpaperflare.com_wallpaper\ \(3\).jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
        }

        .feature-icon {
            color: #FFC107;
            /* Bootstrap yellow color */
        }

        .footer-text {
            font-size: 14px;
        }

        .social-icons a {
            color: #333;
            margin-right: 10px;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: #FFC107;
            /* Bootstrap yellow color */
        }
    </style>
</head>

<body>
    <button type="button" class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
        style="position: absolute; opacity: 0;" id="getStartedBtn">
        Get Started
    </button>
    <?php
    // Get the value of the "username" cookie
    if (!isset($_COOKIE['username'])) {
        ?>
    <script>
        $(document).ready(function() {
            // Trigger the click event on the button automatically
            $('#getStartedBtn').trigger('click');
        });
    </script>
    <?php
    }
    ?>




    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <!-- style="margin-top: 200px;" -->
                    <h1 class="text-white mb-4">Connect, Chat, and Grow Together on Hey</h1>
                    <p class="lead text-white mb-4">Hey is your platform to connect with new friends and potential
                        partners whose vibes match yours, engage in meaningful conversations, and improve your
                        communication skills while spending quality time.</p>
                    <a href="Home.php" class="btn btn-light btn-lg">Get Started</a>
                </div>
            </div>
        </div>
    </section>


    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Welcome to Hey!</h5>
                </div>
                <div class="modal-body">
                    <p>Welcome to Hey! We're excited to have you here. This is a place where you can connect with
                        others, make new friends, and even find a potential partner. Your journey with us starts by
                        sharing your name:</p>
                    <hr>
                    <form action="index_action.php" method="POST">
                        <label for="inputName" class="form-label">Please enter your name:</label>
                        <input type="text" class="form-control" id="inputName" placeholder="Enter your name"
                            name="Name">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="Submit_form">Understood</button>
                </div>

                </form>
            </div>
        </div>
    </div>



    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="Image/heart.jpg" alt="Find Friends" class="feature-icon mb-3" height="30px">
                    <h3>Find Friends</h3>
                    <p>Connect with like-minded individuals whose interests align with yours.</p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="Image/meet.png" alt="Meaningful Conversations" class="feature-icon mb-3" height="30px">
                    <h3>Meaningful Conversations</h3>
                    <p>Engage in deep and meaningful conversations that nurture friendships.</p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="Image/chat.png" alt="Improve Communication" class="feature-icon mb-3" height="30px">
                    <h3>Improve Communication</h3>
                    <p>Hone your communication skills by interacting with diverse personalities.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-left">
                    <p class="footer-text">&copy; 2024 Hey. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-right social-icons">
                    <a href="https://www.facebook.com/share/x2etX3dV2p3UFisK/?mibextid=qi2Omg" target="_blank"
                        class="text-decoration-none"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/krishnu_808?igsh=Y21vMjBlcWRhYmlx" target="_blank"
                        class="text-decoration-none"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com/krishnu_808?igsh=Y21vMjBlcWRhYmlx" target="_blank"
                        class="text-decoration-none"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
