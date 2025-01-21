<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/images/logo.png">
    <title>Congnisight </title>
    <link rel="stylesheet" href="assets/css/style.css">
</head> 
<body>
    <div class="bg-video">
        <video autoplay muted loop>
            <source src="assets/video/video1.mp4" type="video/mp4">
        </video>
        <nav id="navbar">
            <ul>
                <li><a class="link" href="index"><img src="assets/images/logo_noback.png" style="width:75px;" alt="logo"></a></li>
                <li><a class="link mobile_view" href="#home">Home</a></li>
                <li><a class="link mobile_view" href="#about">About Autism</a></li>
                <li><a class="link mobile_view" href="login">Login</a></li>
                <li class="menu-button" onclick="showSidebar()"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg></li>
            </ul>
            <ul class="menu-bar">
                <li class="cross-button" onclick="hideSidebar()"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></li>
                <li onclick="hideSidebar()"><a class="link" href="#home">Home</a></li>
                <li onclick="hideSidebar()"><a class="link" href="#about">About Autism</a></li>
                <li><a class="link" href="login">Login</a></li>
            </ul>
        </nav>
        <div class="home" id="home">
            <div class="content">
                <h6 class="pacifico-regular glow-text">Welcome to Congnisight</h6>
            </div> 
        </div>  
        
        <div class="about" id="about">
            <div class="img">
                <img src="assets/images/1.jpg" width="400px" height="400px" alt="">
            </div>
            <div class="content">
                <p>People with autism have challenges with communication and social skills. They often find it hard to have conversations and may not notice social cues. Some people with autism may not talk at all, and others may not have trouble talking. All people with autism have some degree of challenge with communication (such as making friends or maintaining relationships at school or work).<br><br>People with autism also have some type of restricted interests or repetitive behaviors. They may focus on one topic, like cars or a television show, or they may be attached to a certain object or activity. A person with autism may not like changes in their schedule or changes in the way they do something.<br><br>
    
                    Although the medical community uses the term “autism” to refer to a disorder or a disability, many consider autistic people to be neurodiverse—that autism is a difference, not a “disability.” It is important to respect the viewpoint of the person with autism and/or their families regarding the type of services or care they want to receive. <br>
                    
                </p>
            </div>
            
        </div>
    </div>
    
   
</body>
</html>
<script src="assets/js/script.js"></script>