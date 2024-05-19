<?php
function handleResponse($response, $session , $contentType = 'application/json') {
    if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], $contentType) !== false) {
        header('Content-Type: ' . $contentType);
        echo json_encode($response);
    } else {
        $session->addMessage(array_keys($response)[0], array_values($response)[0]);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

