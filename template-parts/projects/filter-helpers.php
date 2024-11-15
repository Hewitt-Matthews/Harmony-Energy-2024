<?php
function get_current_language_prefix() {
    if (function_exists('weglot_get_current_language')) {
        $current_lang = weglot_get_current_language();
        // Return empty string for default language (English)
        return ($current_lang === 'en') ? '' : $current_lang . '/';
    }
    return '';
}

function get_projects_base_path() {
    if (function_exists('weglot_get_current_language')) {
        $current_lang = weglot_get_current_language();
        // Return translated version for French
        if ($current_lang === 'fr') {
            return 'projets';
        }
        // Add other language translations as needed
        // if ($current_lang === 'de') return 'projekte';
        // if ($current_lang === 'pl') return 'projekty';
        // if ($current_lang === 'it') return 'progetti';
    }
    return 'projects'; // Default English
}