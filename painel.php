<?php
header('Content-type: application/json');
print file_get_contents('/dados/cap/status/painel.json');

