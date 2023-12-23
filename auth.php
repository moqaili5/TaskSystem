<?php
session_start();

// Function to set the user ID in the session
function setUserIDInSession($user_id) {
    $_SESSION['user'] = $user_id;
}

// Function to check if the user is authenticated
function isAuthenticated() {
    return isset($_SESSION['user']);
}

// Function to log out the user
function logout() {
    session_unset();
    session_destroy();
}
