let otp_val;

function sendOTP() {
    const email = document.getElementById('email').value;
    const otpField = document.getElementById('otp-field');
    const sendOTPBtn = document.getElementById('send-otp-btn');
    const verifyOTPBtn = document.getElementById('verify-otp-btn');
    const messageElement = document.getElementById('message');

    if (!validateEmail(email)) {
        messageElement.textContent = "Please enter a valid email address ending with .com";
        return;
    }

    otp_val = Math.floor(100000 + Math.random() * 900000); // 6-digit OTP
    const emailBody = `<h2>Your OTP is ${otp_val}</h2>`;

    Email.send({
        Host: "smtp.elasticemail.com",
        Username: "oscarkoh070809@gmail.com", // Replace with your email
        Password: "D4wKSK4Fh!nRcMD", // Replace with your password
        To: email,
        From: "oscarkoh070809@gmail.com", // Replace with your email
        Subject: "OTP for forgotten password",
        Body: emailBody,
    }).then(message => {
        if (message === "OK") {
            messageElement.textContent = `OTP sent to ${email}`;
            otpField.style.display = "block";
            sendOTPBtn.style.display = "none";
            verifyOTPBtn.style.display = "block";
        } else {
            messageElement.textContent = "Failed to send OTP. Please try again.";
        }
    });
}

function verifyOTP() {
    const otpInput = document.getElementById('otp_inp').value;
    const messageElement = document.getElementById('message');

    if (otpInput == otp_val) {
        messageElement.textContent = "Email address verified. You can now reset your password.";
        // Here you would typically redirect to a password reset page or show a password reset form
    } else {
        messageElement.textContent = "Invalid OTP. Please try again.";
    }
}

function validateEmail(email) {
    const regex = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.com$/;
    return regex.test(email);
}

// Add event listeners when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('forget-password-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent form submission
    });
});