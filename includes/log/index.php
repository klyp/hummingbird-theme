<?php

// includes logging
require get_theme_file_path('includes/log/class.php');
new HummingbirdLog();

// db + ui
require get_theme_file_path('includes/log/table.php');
require get_theme_file_path('includes/log/ui.php');

new HummingbirdLogUI();