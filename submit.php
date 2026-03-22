<?php
$conn = new mysqli("localhost", "your_user", "your_password", "your_db");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $intent = $conn->real_escape_string($_POST['intent']);
    $theme  = $conn->real_escape_string($_POST['theme']);
    $utype  = $conn->real_escape_string($_POST['utype']);
    $stage  = $conn->real_escape_string($_POST['stage']);
    $query  = $conn->real_escape_string($_POST['query']);
    $lang   = $conn->real_escape_string($_POST['lang']);
    $anon   = isset($_POST['anon']) ? 1 : 0;
    
    $audioPath = "";
    if (isset($_FILES['audio_file'])) {
        $name = "uploads/" . time() . ".webm";
        if (move_uploaded_file($_FILES['audio_file']['tmp_name'], $name)) {
            $audioPath = $name;
        }
    }

    $sql = "INSERT INTO career_hub_submissions (intent, theme, user_type, stage, query_text, audio_path, lang, can_feature) 
            VALUES ('$intent', '$theme', '$utype', '$stage', '$query', '$audioPath', '$lang', $anon)";

    if ($conn->query($sql)) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }
}
?>