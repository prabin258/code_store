// Function to reveal the specified form by toggling its display
function Reveal(mark){
    // Get references to the form elements
    const form1 = document.getElementById("student_adder");
    const form2 = document.getElementById("physics_questions");
    const form3 = document.getElementById("chemistry_questions");
    const part = document.getElementById(mark);

    // Hide the form if it's already displayed
    if (part.style.display=="block"){
        part.style.display="none";
        return;
    }

    // Hide other forms if they are displayed
    if (form1.style.display=="block"){
        form1.style.display="none";
    }
    if (form2.style.display=="block"){
        form2.style.display="none";
    }
    if (form3.style.display=="block"){
        form3.style.display="none";
    } 
    
    // Display the specified form
    if (part.style.display="none"){
        part.style.display="block";
    } 
}

// Function to perform login
function login(){
    const form = document.getElementById("loginform");
    const data = new FormData(form);

    // Log the form data
    for (const pair of data.entries()) {
        console.log(pair[0], pair[1]);
    }

    // Send login data to the server for processing
    return fetch('http://localhost/test/login_processor.php',{
        method:'POST',
        body: data
    })
    .then(response=>response.json())
    .then(data=> {
        console.log(typeof data);
        // Show notification if login is unsuccessful, otherwise, perform the login function
        if (!data.result) {
            notifieruser();
        } else {
            loginfunction();
        }
    })
    .catch(error => console.error('Error:', error));
}

// Function to show notification for unsuccessful login
function notifieruser(){
    const notification = document.getElementById("notification");
    notification.style.display = "block";
}

// Function to perform login after successful authentication
function loginfunction(){
    const afterlogin = document.getElementById("afterlogin");
    const login = document.getElementById("loginpage");
    login.style.display = "none";
    afterlogin.style.display = "block";
}

// Functions to send data to the server for different forms
function senddata1(){
    const form = document.getElementById("physics");
    const data = new FormData(form);
      
    return fetch('http://localhost/test/physics_questions.php',{
        method: 'POST',
        body: data
    })
    .then(response => {
        // Reset the form after sending data and getting the response (if needed)
        form.reset();
    })
    .catch(error => console.error('Error:', error));
}

function senddata2(){
    const form = document.getElementById("chemistry");
    const data = new FormData(form);
      
    return fetch('http://localhost/test/chemistry_questions.php',{
        method: 'POST',
        body: data
    })
    .then(response => {
        // Reset the form after sending data and getting the response (if needed)
        form.reset();
    })
    .catch(error => console.error('Error:', error));
}

function student_data(){
    const form = document.getElementById("students");
    const data = new FormData(form);
      
    return fetch('http://localhost/test/student_data_creater.php',{
        method: 'POST',
        body: data
    })
    .then(response => {
        // Reset the form after sending data and getting the response (if needed)
        form.reset();
    })
    .catch(error => console.error('Error:', error));
}

// Function to toggle the display of the question generator
function randomGenerator(){
    const one = document.getElementById("question_generator");
    if (one.style.display == "none"){
        one.style.display = "block";
    } else{
        one.style.display = "none";
    }
}
