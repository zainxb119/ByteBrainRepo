<?php

function ValidName(string $name, string $field_name = 'Name', string &$message = null): bool
{
    $message = null;
  if (strlen($name) < 3)
    $message = "$field_name cannot be shorter than 3 characters";
  else if (strlen($name) > 15)
    $message = "$field_name cannot be longer than 15 characters";
  else if (!limitedChars($name, "a-z", $field_name, $message)) {
  }

  return !isset($message);
}

function ValidPhone(string $number, string &$message = null): bool
{
    $message = null;
  if (!preg_match('/^((\+?|00)973\s?)?[36][0-9]{7}$/', $number)) {
    $message = "Invalid phone number";
    return false;
  }
  return true;
}

function ValidEmail(string $email, string &$message = null): bool
{
    $message = null;
  if (
    !preg_match(
      '/^[a-zA-Z0-9]+(?:[\.\-_][a-zA-Z0-9]+)*@[a-zA-Z0-9]+(?:[\.\-_][a-zA-Z0-9]+)*$/',
      $email
    )
  ) {
    $message = 'Invalid email';
    return false;
  }
  return true;
}

function ValidBirthyear(string $birthyear, string &$message = null): bool
{
    $message = null;
    $yr = "/^(199[5-9]|200[0-3])$/";
  if (!preg_match($yr, $birthyear)) 
  {
    $message = "Invalid birth year";
    return false;
  }
  return true;
}

function limitedChars(string $subject, string $allowedChars, string $field_name, string &$message = null): bool
{
    $message = null;
  if (preg_match_all("/[^$allowedChars]/i", $subject, $matches, PREG_SET_ORDER)) {
    $out = "";
    $count = 0;
    foreach ($matches as list($char)) {
      if (strpos($out, $char) === false) {
        $out .= " " . $char;
        $count++;
      }
    }
    $message = ($count == 1) ? 
      "Character " . htmlspecialchars($out) . " is not allowed" :
      "Characters " . htmlspecialchars($out) . " are not allowed";
    $message .= " in $field_name";
    return false;
  }

  return true;
}
?>