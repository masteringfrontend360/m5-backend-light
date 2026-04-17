

<?php
session_start();

$_SESSION['usuario'] = 'Ana';
echo htmlspecialchars($_SESSION['usuario'], ENT_QUOTES, 'UTF-8');
