<?php
// contact.php - InfinityFree Compatible

header('Content-Type: text/plain; charset=UTF-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = isset($_POST['name']) ? strip_tags(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? strip_tags(trim($_POST['email'])) : '';
    $subject = isset($_POST['subject']) ? strip_tags(trim($_POST['subject'])) : 'No Subject';
    $message = isset($_POST['message']) ? strip_tags(trim($_POST['message'])) : '';
    
    $errors = [];
    
    if (empty($name)) $errors[] = "Name required";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email required";
    if (empty($message)) $errors[] = "Message required";
    
    if (empty($errors)) {
        
        // === METHOD 1: Save to file (Hamesha kaam karega) ===
        $log_entry = "========================================\n";
        $log_entry .= "Date: " . date("Y-m-d H:i:s") . "\n";
        $log_entry .= "Name: " . $name . "\n";
        $log_entry .= "Email: " . $email . "\n";
        $log_entry .= "Subject: " . $subject . "\n";
        $log_entry .= "Message: " . $message . "\n";
        $log_entry .= "========================================\n\n";
        
        // Save in htdocs folder
        file_put_contents("messages.txt", $log_entry, FILE_APPEND | LOCK_EX);
        
        // === METHOD 2: Try email (may work on InfinityFree) ===
        $to = "your-email@gmail.com"; // <-- APNA EMAIL YAHAN DAALO
        $email_subject = "Portfolio: " . $subject;
        $email_body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: noreply@yourdomain.infinityfreeapp.com\r\n";
        $headers .= "Reply-To: $email\r\n";
        
        @mail($to, $email_subject, $email_body, $headers);
        
        echo "success";
        
    } else {
        echo "error: " . implode(", ", $errors);
    }
    
} else {
    echo "error: Invalid request";
}
?>