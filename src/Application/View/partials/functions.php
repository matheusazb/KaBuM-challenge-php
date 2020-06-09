<?php

function applyCssFiles($files = [])
{
  if (is_array($files)) {
    foreach ($files as $cssFile) {
      echo sprintf("<link rel=\"stylesheet\" type=\"text/css\" href=\"%s/%s\">", ASSETS_PATH, $cssFile);
    }
  }
}

function applyJsFiles($files = [])
{
  if (is_array($files)) {
    foreach ($files as $jsFile) {
      echo sprintf("<script src=\"%s/%s\" async defer></script>", ASSETS_PATH, $jsFile);
    }
  }
}
