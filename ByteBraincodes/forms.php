<?php

function inject_value($value)
{
  if (isset($value))
    return "value='" . htmlspecialchars($value) . "'";
}
